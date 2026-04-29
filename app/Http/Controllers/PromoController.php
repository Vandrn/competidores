<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;

use App\Http\Requests\StorePromoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Services\BigQueryService;

class PromoController extends Controller
{
    public function index(Request $request)
    {
    $q = trim((string) $request->get('q', ''));
    $pais = $request->get('pais');

    // Calcular semana actual (lunes a domingo)
    $today = now();
    $startOfWeek = $today->copy()->startOfWeek();
    $endOfWeek = $today->copy()->endOfWeek();
    $semana_actual = $startOfWeek->format('d/m') . ' - ' . $endOfWeek->format('d/m');

    // Usar BigQueryService para obtener promos
    $bq = app(BigQueryService::class);
    $promos = $bq->getPromos($q, $pais);

    return view('promos.index', compact('promos','q','pais','semana_actual'));
    }

    public function store(StorePromoRequest $request, BigQueryService $bq)
    {
        $data = $request->validated();

        if ($request->boolean('no_fecha')) {
            // Calcular semana actual (lunes a domingo)
            $today = now();
            $startOfWeek = $today->copy()->startOfWeek();
            $endOfWeek = $today->copy()->endOfWeek();
            $data['fecha_inicio'] = $startOfWeek->format('Y-m-d');
            $data['fecha_fin']    = $endOfWeek->format('Y-m-d');
        }

        // 1) Subir imágenes a GCS usando Google\Cloud\Storage\StorageClient
        $uploadedUrls = [];
        if ($request->hasFile('images')) {
            $storage = new \Google\Cloud\Storage\StorageClient([
                'projectId' => env('BIGQUERY_PROJECT_ID'),
                'keyFilePath' => base_path(env('BIGQUERY_KEY_FILE')),
            ]);
            $bucket = $storage->bucket(env('GOOGLE_CLOUD_STORAGE_BUCKET'));
            foreach ($request->file('images') as $file) {
                Log::info('Imagen recibida', [
                    'originalName' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ]);
                $path = sprintf('%s/%s/%s.%s',
                    date('Y'), date('m'),
                    Str::uuid(), $file->getClientOriginalExtension()
                );
                $object = $bucket->upload(
                    fopen($file->getRealPath(), 'r'),
                    [
                        'name' => $path,
                    ]
                );
                $url = sprintf('https://storage.googleapis.com/%s/%s', env('GOOGLE_CLOUD_STORAGE_BUCKET'), $path);
                $uploadedUrls[] = $url;
            }
        }

        // Insertar en BigQuery
        $bq->insertPromo([
            'pais'          => $data['pais'],
            'modalidad'     => $data['modalidad'],
            'cadena'        => mb_strtoupper($data['cadena']),
            'tipo'          => $data['tipo'],
            'categoria'     => $data['categoria'] ?? null,
            'temporada'     => $data['temporada'] ?? null,
            'descripcion'   => $data['descripcion'],
            'fecha_inicio'  => $data['fecha_inicio'],
            'fecha_fin'     => $data['fecha_fin'],
            'observaciones' => $data['observaciones'] ?? null,
            'reporter_email'=> $data['reporter_email'] ?? null,
            'images'        => $uploadedUrls,
        ]);

        return redirect()->route('promos.index')->with('ok','Promoción guardada en BigQuery y GCS.');
    }


    public function show($promoId, BigQueryService $bq)
    {
        // Obtener la promo por ID desde BigQuery
        Log::info('PromoController@show llamado', ['promoId' => $promoId]);
        $promo = $bq->getPromoById($promoId);
        // Normalizar fechas y timestamps para el frontend
        if ($promo) {
            if (isset($promo['submission_ts']) && is_object($promo['submission_ts'])) {
                $promo['submission_ts'] = (string) $promo['submission_ts'];
            }
            if (isset($promo['promos']) && is_array($promo['promos'])) {
                foreach ($promo['promos'] as &$p) {
                    if (isset($p['fecha_inicio']) && is_object($p['fecha_inicio'])) {
                        $p['fecha_inicio'] = (string) $p['fecha_inicio'];
                    }
                    if (isset($p['fecha_fin']) && is_object($p['fecha_fin'])) {
                        $p['fecha_fin'] = (string) $p['fecha_fin'];
                    }
                    if (isset($p['images']) && is_array($p['images'])) {
                        foreach ($p['images'] as &$img) {
                            if (isset($img['uploaded_ts']) && is_object($img['uploaded_ts'])) {
                                $img['uploaded_ts'] = (string) $img['uploaded_ts'];
                            }
                        }
                    }
                }
                unset($p);
            }
        }
        Log::info('Resultado getPromoById', ['promo' => $promo]);
        if (request()->expectsJson() || request()->ajax() || request()->isMethod('GET') && request()->wantsJson()) {
            if (!$promo) {
                Log::warning('Promo no encontrada', ['promoId' => $promoId]);
                return response()->json(['error' => 'No encontrado'], 404);
            }
            return response()->json($promo);
        }
        if (!$promo) {
            Log::warning('Promo no encontrada (vista)', ['promoId' => $promoId]);
            abort(404);
        }
        return view('promos.show', compact('promo'));
    }
}
