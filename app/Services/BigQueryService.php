<?php
namespace App\Services;

use Illuminate\Support\Facades\Log;

use Google\Cloud\BigQuery\BigQueryClient;
use Illuminate\Support\Str;

class BigQueryService
{
    protected BigQueryClient $bq;
    // Duplicate constructor and insertPromo removed

    public function getPromos($q = null, $pais = null)
    {
        $query = "SELECT * FROM `" . env('BIGQUERY_PROJECT_ID') . "." . env('BIGQUERY_DATASET') . "." . env('BIGQUERY_TABLE') . "` WHERE 1=1";
        if ($q) {
            $query .= " AND (cadena LIKE '%$q%' OR descripcion LIKE '%$q%' OR tipo LIKE '%$q%')";
        }
        if ($pais) {
            $query .= " AND pais = '$pais'";
        }
    $query .= " ORDER BY submission_ts DESC LIMIT 12";

        $job = $this->bq->runQuery($this->bq->query($query));
        return iterator_to_array($job->rows());
    }
    public function __construct()
    {
        $this->bq = new BigQueryClient([
            'projectId' => env('BIGQUERY_PROJECT_ID'),
            'keyFilePath' => base_path(env('BIGQUERY_KEY_FILE')),
        ]);
    }

    public function insertPromo(array $data): void
    {
        $dataset = $this->bq->dataset(env('BIGQUERY_DATASET'));
        $table   = $dataset->table(env('BIGQUERY_TABLE'));

        $row = [
            'submission_id'   => (string) Str::uuid(),
            'submission_ts'   => now()->format('Y-m-d\TH:i:s\Z'),
            'pais'            => $data['pais'],
            'reporter_email'  => $data['reporter_email'] ?? '',
            'promos'          => [
                [
                    'promo_id'     => (string) Str::uuid(),
                    'cadena'       => $data['cadena'],
                    'modalidad'    => $data['modalidad'],
                    'tipo'         => $data['tipo'],
                    'categoria'    => $data['categoria'] ?? '',
                    'temporada'    => $data['temporada'] ?? '',
                    'descripcion'  => $data['descripcion'],
                    'fecha_inicio' => isset($data['fecha_inicio']) && $data['fecha_inicio'] ? date('Y-m-d', strtotime($data['fecha_inicio'])) : '',
                    'fecha_fin'    => isset($data['fecha_fin']) && $data['fecha_fin'] ? date('Y-m-d', strtotime($data['fecha_fin'])) : '',
                    'observaciones'=> $data['observaciones'] ?? '',
                    'images'       => array_map(function($url) {
                        return [
                            'gcs_path'    => $url,
                            'public_url'  => $url,
                            'uploaded_ts' => now()->format('Y-m-d\TH:i:s\Z'),
                        ];
                    }, $data['images'] ?? []),
                ]
            ],
        ];

        Log::info('Row a insertar en BigQuery', ['row' => $row]);

        $insertResponse = $table->insertRows([['data' => $row]]);
        if (!$insertResponse->isSuccessful()) {
            $errorDetails = collect($insertResponse->failedRows())->pluck('errors')->flatten(1)->map(function($err) {
                return '[' . ($err['reason'] ?? '') . '] ' . ($err['message'] ?? '') . ' (location: ' . ($err['location'] ?? 'n/a') . ')';
            })->implode('; ');
            Log::error('BigQuery insert error', ['details' => $errorDetails, 'row' => $row]);
            throw new \RuntimeException('Error insertando en BigQuery: ' . $errorDetails);
        }
    }

    public function getPromoById($promoId)
    {
    $query = "SELECT t.* FROM `" . env('BIGQUERY_PROJECT_ID') . "." . env('BIGQUERY_DATASET') . "." . env('BIGQUERY_TABLE') . "` t, UNNEST(t.promos) p WHERE p.promo_id = '$promoId' LIMIT 1";
    $job = $this->bq->runQuery($this->bq->query($query));
    $rows = iterator_to_array($job->rows());
    return $rows[0] ?? null;
    }
}
