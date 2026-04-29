@extends('layouts.app')

@section('title','Reporte de Competencia – Mockup')

@section('content')
<style>
  :root {
    --brand: #1f3b70;
    --accent: #ffc300;
    --bg: #f6f7fb;
    --card: #ffffff;
    --text: #1f2937;
    --muted: #6b7280;
    --border: #e5e7eb;
    --radius: 14px;
    --shadow: 0 10px 25px rgba(0, 0, 0, .06);
  }

  * {
    box-sizing: border-box
  }

  html,
  body {
    height: 100%
  }

  body {
    margin: 0;
    font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji";
    background: var(--bg);
    color: var(--text);
  }

  header {
    position: sticky;
    top: 0;
    z-index: 10;
    background: linear-gradient(180deg, #223c78, #1f3b70);
    color: #fff;
    padding: 18px 22px;
    box-shadow: var(--shadow);
  }

  header .wrap {
    max-width: 1200px;
    margin: auto;
    display: flex;
    align-items: center;
    gap: 18px;
    flex-wrap: wrap
  }

  h1 {
    font-size: clamp(18px, 2.2vw, 26px);
    margin: 0;
    font-weight: 700
  }

  .filters {
    margin-left: auto;
    display: flex;
    gap: 10px;
    flex-wrap: wrap
  }

  .chip {
    background: rgba(255, 255, 255, .12);
    border: 1px solid rgba(255, 255, 255, .22);
    color: #fff;
    padding: 8px 10px;
    border-radius: 999px;
    font-size: 13px
  }

  main {
    max-width: 1200px;
    margin: 24px auto;
    padding: 0 18px;
    display: grid;
    gap: 28px
  }

  .card {
    background: var(--card);
    border: 1px solid var(--border);
    border-radius: var(--radius);
    box-shadow: var(--shadow)
  }

  .form {
    padding: 20px
  }

  .form h2 {
    margin: 0 0 14px;
    font-size: 20px
  }

  .grid {
    display: grid;
    gap: 14px
  }

  .grid.cols-2 {
    grid-template-columns: repeat(2, minmax(0, 1fr))
  }

  .grid.cols-3 {
    grid-template-columns: repeat(3, minmax(0, 1fr))
  }

  @media (max-width:980px) {

    .grid.cols-2,
    .grid.cols-3 {
      grid-template-columns: 1fr
    }
  }

  label {
    font-weight: 600;
    font-size: 13px;
    color: #374151
  }

  .check {
    display: flex;
    gap: 8px;
    align-items: center;
    font-weight: 600;
    font-size: 13px
  }

  .ctl {
    display: grid;
    gap: 6px
  }

  input[type="text"],
  input[type="date"],
  select,
  textarea {
    width: 100%;
    padding: 12px 14px;
    border: 1px solid var(--border);
    border-radius: 12px;
    background: #fff;
    font: inherit;
    color: var(--text);
    outline: none;
    transition: .16s ease;
  }

  textarea {
    min-height: 84px;
    resize: vertical
  }

  input:focus,
  select:focus,
  textarea:focus {
    border-color: #9bb3ff;
    box-shadow: 0 0 0 3px rgba(54, 106, 255, .12)
  }

  .upload {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
    padding: 18px;
    border: 2px dashed var(--border);
    border-radius: 12px;
    background: #fafafa;
    cursor: pointer;
    text-align: center;
    color: var(--muted);
  }

  .upload:hover {
    background: #f3f4f6
  }

  .previews {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(120px, 1fr));
    gap: 10px
  }

  .thumb {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    border: 1px solid var(--border);
    background: #fff
  }

  .thumb img {
    display: block;
    width: 100%;
    height: 120px;
    object-fit: cover
  }

  .thumb button {
    position: absolute;
    top: 6px;
    right: 6px;
    border: none;
    background: rgba(0, 0, 0, .55);
    color: #fff;
    border-radius: 8px;
    padding: 4px 7px;
    cursor: pointer
  }

  .actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: 8px
  }

  .btn {
    border: none;
    padding: 12px 16px;
    border-radius: 12px;
    font-weight: 600;
    cursor: pointer
  }

  .btn.primary {
    background: var(--brand);
    color: #fff
  }

  .btn.ghost {
    background: #fff;
    border: 1px solid var(--border);
    color: #374151
  }

  .btn.primary:hover {
    filter: brightness(1.05)
  }

  .toolbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 16px 20px;
    border-bottom: 1px solid var(--border)
  }

  .toolbar h3 {
    margin: 0;
    font-size: 18px
  }

  /* Galería responsiva moderna */
  .gallery {
    padding: 16px;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 24px;
    align-items: start;
  }

  @media (max-width:700px) {
    .gallery {
      grid-template-columns: 1fr;
    }
  }

  .promo-card {
    display: grid;
    grid-template-rows: auto 1fr auto;
    gap: 10px;
    padding: 14px
  }

  .promo-head {
    display: flex;
    gap: 10px;
    align-items: center;
    justify-content: space-between
  }

  .title {
    font-weight: 700
  }

  .tag {
    padding: 4px 8px;
    background: #eef2ff;
    color: #3742a5;
    border: 1px solid #dee5ff;
    border-radius: 999px;
    font-size: 12px
  }

  .promo-imgs {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 8px
  }

  .promo-imgs img {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 10px;
    border: 1px solid var(--border)
  }

  .meta {
    display: flex;
    gap: 8px;
    align-items: center;
    color: var(--muted);
    font-size: 13px
  }

  dialog {
    border: none;
    padding: 0;
    border-radius: 16px;
    width: min(920px, 92vw)
  }

  dialog::backdrop {
    background: rgba(0, 0, 0, .4)
  }

  .modal {
    background: #fff;
    border-radius: 16px;
    overflow: hidden
  }

  .modal-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 14px 16px;
    background: #f9fafb;
    border-bottom: 1px solid var(--border)
  }

  .modal-body {
    display: grid;
    grid-template-columns: 1.2fr .8fr;
    gap: 16px;
    padding: 14px
  }

  @media (max-width:900px) {
    .modal-body {
      grid-template-columns: 1fr
    }
  }

  .modal-body img {
    width: 100%;
    max-height: 380px;
    object-fit: cover;
    border-radius: 12px;
    border: 1px solid var(--border)
  }

  .thumbs-row {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
    gap: 8px;
    margin-top: 8px
  }

  .thumbs-row img {
    height: 70px
  }

  .kv {
    display: grid;
    grid-template-columns: 110px 1fr;
    gap: 6px 10px;
    font-size: 14px
  }

  .kv div:nth-child(odd) {
    color: #6b7280
  }
</style>

<header>
  <div class="wrap">
    <h1>Reporte de Competencia</h1>
    <div class="filters">
      <span class="chip" id="chipPais">País: {{ $pais ?? 'GT' }}</span>
      <span class="chip" id="chipFecha">{{ $semana_actual }}</span>
    </div>
  </div>
</header>

<main>
  {{-- ===== Formulario ===== --}}
  <section class="card form" aria-labelledby="form-title">
    <h2 id="form-title">Registrar nueva promoción</h2>

    @if(session('ok'))
    <div style="margin-bottom:10px; padding:10px; border:1px solid var(--border); border-radius:10px; background:#f3f4f6;">
      {{ session('ok') }}
    </div>
    @endif

    @if($errors->any())
    <div style="margin-bottom:10px; padding:10px; border:1px solid #fecaca; border-radius:10px; background:#fee2e2;">
      <ul style="margin:0; padding-left:18px;">
        @foreach($errors->all() as $e)
        <li>{{ $e }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form id="promoForm" class="grid" action="{{ route('promos.store') }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="grid cols-3">
        <div class="ctl">
          <label for="pais">País</label>
          <select id="pais" name="pais" required onchange="document.getElementById('chipPais').textContent = `País: ${this.value}`">
            @foreach(['GT'=>'Guatemala','SV'=>'El Salvador','HN'=>'Honduras','NI'=>'Nicaragua','CR'=>'Costa Rica','PA'=>'Panamá'] as $code=>$name)
            <option value="{{ $code }}" @selected(old('pais')===$code)>{{ $name }}</option>
            @endforeach
          </select>
        </div>
        <div class="ctl">
          <label for="modalidad">Tipo de Campaña</label>
          <select id="modalidad" name="modalidad" required>
            @foreach(['Campañas Físicas','Campañas Digitales','Fisicas/Digitales'] as $m)
            <option value="{{ $m }}" @selected(old('modalidad')===$m)>{{ $m }}</option>
            @endforeach
          </select>
        </div>
        <div class="ctl">
          <label for="cadena">Cadena de Tiendas</label>
          <select id="cadena" name="cadena" required data-old="{{ old('cadena') }}">
            <option value="" disabled selected>Seleccione cadena…</option>
          </select>
        </div>
      </div>

      <div class="grid cols-3">
        <div class="ctl">
          <label for="tipo">Tipo de Promo</label>
          <select id="tipo" name="tipo" required>
            @foreach(['Oferta', 'Rebaja', 'Liquidación','Promoción', 'Campaña', 'Oferta Limitada', 'Lanzamiento', 'Descuento por volumen', 'Cupón', 'Regalo', 'Bono', 'Incentivo', 'Muestra Gratis' ] as $t)
            <option @selected(old('tipo')===$t)>{{ $t }}</option>
            @endforeach
          </select>
        </div>
        <div class="ctl">
          <label for="categoria">Categoria</label>
          <select id="categoria" name="categoria" required>
            @foreach(['Calzado & CC', 'Calzado', 'Ropa', 'Calzado & Ropa', 'ACC', 'Ropa & ACC' ] as $c)
            <option @selected(old('categoria')===$c)>{{ $c}}</option>
            @endforeach
          </select>
        </div>
        <div class="ctl">
          <label for="temporada">Temporada</label>
          <select id="temporada" name="temporada" required>
            @foreach(['Aguinaldo','Back To Office', 'Back To School', 'Back To School Bilingue', 'Black Friday', 'Black Weekend', 'Bono 14', 'Ciber Monday', 'Dia de la Madre', 'Dia del niño', 'Dia del Padre', 'Dia del Trabajo', 'EOSS', 'Fiestas Agostinas', 'Independencia', 'MSS', 'San Valentin', 'Semana Morazanica', 'Semana Santa'] as $tm)
            <option @selected(old('temporada')===$tm)>{{ $tm }}</option>
            @endforeach
          </select>
        </div>
      </div>

      <div class="ctl">
        <label for="desc">Descripción de la promo</label>
        <textarea id="desc" name="descripcion" placeholder="Ej: 20% con ClubBI hasta el 31 de agosto" required>{{ old('descripcion') }}</textarea>
      </div>

      <div class="ctl">
        <label class="check"><input id="noFecha" name="no_fecha" type="checkbox" value="1" onchange="toggleFechas(this.checked); mostrarFechasSemana(this.checked)" /> Sin fecha definida (no tiene inicio/fin)</label>
        <div id="fechasSemana" style="display:none; font-size:13px; color:#374151; margin-top:6px;">
          <span>Inicio: <strong>{{ \Carbon\Carbon::now()->startOfWeek()->format('d/m/Y') }}</strong></span><br>
          <span>Fin: <strong>{{ \Carbon\Carbon::now()->endOfWeek()->format('d/m/Y') }}</strong></span>
        </div>
        <script>
          function mostrarFechasSemana(checked) {
            document.getElementById('fechasSemana').style.display = checked ? 'block' : 'none';
          }
        </script>
      </div>

      <div class="grid cols-3">
        <div class="ctl">
          <label for="ini">Fecha inicio</label>
          <input id="ini" name="fecha_inicio" type="date" value="{{ old('fecha_inicio') }}" />
        </div>
        <div class="ctl">
          <label for="fin">Fecha fin</label>
          <input id="fin" name="fecha_fin" type="date" value="{{ old('fecha_fin') }}" />
        </div>
        <div class="ctl">
          <label for="observ">Observaciones</label>
          <input id="observ" name="observaciones" type="text" placeholder="Opcional" value="{{ old('observaciones') }}" />
        </div>
      </div>

      <div class="ctl">
        <label>Publicidad (imágenes)</label>
        <label class="upload">
          <input id="files" name="images[]" type="file" accept="image/*" multiple hidden onchange="handleFiles(this.files)" />
          <span>+ Agregar imagen (JPG/PNG)</span>
        </label>
        <div id="previews" class="previews"></div>
      </div>

      <div class="actions">
        <button type="reset" class="btn ghost" onclick="resetPreviews()">Limpiar</button>
        <button type="submit" class="btn primary">Guardar</button>
      </div>
    </form>
  </section>

  {{-- ===== Listado / Galería ===== --}}
  <section class="card">
    <div class="toolbar">
      <h3>Promociones registradas</h3>
      <form method="get" style="display:flex; gap:8px; align-items:center">
        <input name="q" id="search" type="text" placeholder="Buscar tienda o texto…" value="{{ $q }}" style="padding:10px 12px; border:1px solid var(--border); border-radius:10px;" />
        <select name="pais" style="padding:10px 12px; border:1px solid var(--border); border-radius:10px;">
          <option value="">Todos</option>
          @foreach(['GT','SV','HN','NI','CR','PA'] as $p)
          <option value="{{ $p }}" @selected($pais===$p)>{{ $p }}</option>
          @endforeach
        </select>
        <button class="btn primary" type="submit">Filtrar</button>
      </form>
    </div>

    <div id="gallery" class="gallery">
      @forelse($promos as $promo)
      @php
      $promoData = $promo['promos'][0] ?? [];
      $images = $promoData['images'] ?? [];
      @endphp
      <article class="card promo-card">
        <div class="promo-head">
          <div class="title">{{ $promoData['cadena'] ?? 'Sin cadena' }}</div>
          <span class="tag" title="Modalidad">{{ $promoData['modalidad'] ?? '' }}</span>
        </div>

        <div>
          <div class="promo-imgs">
            @if(count($images))
            @foreach(array_slice($images,0,2) as $im)
            <img src="{{ $im['public_url'] ?? $im['gcs_path'] ?? '' }}" alt="img">
            @endforeach
            @else
            <div style="grid-column:1/-1; color:var(--muted); font-size:13px; border:1px dashed var(--border); border-radius:10px; padding:18px; text-align:center">
              Sin imágenes
            </div>
            @endif
          </div>
        </div>

        <div style="display:grid; gap:6px">
          <div style="font-size:14px">{{ $promoData['descripcion'] ?? '' }}</div>
          <div class="meta">
            <span>📅 {{ $promoData['fecha_inicio'] ?? '' }} a {{ $promoData['fecha_fin'] ?? '' }}</span>
            <span>•</span>
            <span>🎯 {{ $promoData['tipo'] ?? '' }}</span>
          </div>
          <div class="actions" style="justify-content:space-between">
            <span class="chip" style="background:#f3f4f6; color:#374151; border-color:#e5e7eb">{{ $promo['pais'] ?? '' }}</span>
            <button class="btn primary" type="button" onclick='showPromoModal("{{ $promoData["promo_id"] ?? "" }}")'>Ver más</button>
            <!-- Modal para detalle de promoción -->
            <div id="promoModal" class="modal" style="display:none; position:fixed; top:0; left:0; width:100vw; height:100vh; background:rgba(0,0,0,0.3); z-index:9999; align-items:center; justify-content:center;">
              <div class="modal-content" style="background:#fff; border-radius:10px; max-width:500px; width:90vw; padding:32px; position:relative;">
                <button onclick="closePromoModal()" style="position:absolute; top:12px; right:12px; background:none; border:none; font-size:22px;">&times;</button>
                <div id="promoModalBody">Cargando...</div>
              </div>
            </div>
            <script>
              function showPromoModal(promoId) {
                const modal = document.getElementById('promoModal');
                const body = document.getElementById('promoModalBody');
                modal.style.display = 'flex';
                body.innerHTML = 'Cargando...';
                fetch('/promos/' + promoId, {
                    headers: {
                      'Accept': 'application/json'
                    }
                  })
                  .then(async r => {
                    if (!r.ok) {
                      const err = await r.json().catch(() => ({}));
                      body.innerHTML = `<div style='color:red'>${err.error || 'Error al cargar la promoción.'}</div>`;
                      return null;
                    }
                    return r.json();
                  })
                  .then(data => {
                    if (!data) return;
                    console.log('Respuesta promo:', data);
                    // Si la promo tiene array promos, mostrar el primero
                    let promo = data.promos ? data.promos[0] : data;
                    if (!promo) {
                      body.innerHTML = '<div style="color:red">No se encontró la promoción.</div>';
                      return;
                    }
                    body.innerHTML = `
                    <h3>
                      <strong>${promo.cadena || ''}</strong>
                      <span class="tag">${promo.modalidad || ''}</span>
                    </h3>
                    <p><strong>Tipo:</strong> ${promo.tipo || ''}</p>
                    <p><strong>Descripción:</strong> ${promo.descripcion || ''}</p>
                    <p><strong>Fechas:</strong> ${promo.fecha_inicio || 'Sin fecha'} a ${promo.fecha_fin || 'Sin fecha'}</p>
                    <p><strong>Observaciones:</strong> ${promo.observaciones || 'N/A'}</p>
                    <div class="row">${(promo.images||[]).map(img => `<img src='${img.public_url}' style='max-width:100px; margin:4px; border-radius:6px;'>`).join('')}</div>
                  `;
                  })
                  .catch(() => {
                    body.innerHTML = '<div style="color:red">Error al cargar la promoción.</div>';
                  });
              }

              function closePromoModal() {
                document.getElementById('promoModal').style.display = 'none';
              }
            </script>
          </div>
        </div>
      </article>
      @empty
      <div style="grid-column:1/-1; padding:40px; text-align:center; color:var(--muted)">Sin resultados</div>
      @endforelse
    </div>

  </section>

  {{-- ===== Listado de Promociones desde BigQuery ===== --}}
  <section class="card gallery">
    <h2 style="padding:16px 20px;">Promociones recientes</h2>
    <div class="gallery">
      @forelse($promos as $promo)
      @php
      $promoData = $promo['promos'][0] ?? [];
      $images = $promoData['images'] ?? [];
      @endphp
      <div class="promo-card">
        <div class="promo-head">
          <span class="title">{{ $promoData['cadena'] ?? 'Sin cadena' }}</span>
          <span class="tag">{{ $promoData['tipo'] ?? '' }}</span>
        </div>
        <div class="meta">
          <span>{{ $promo['pais'] ?? '' }}</span>
          <span>{{ $promo['submission_ts'] ?? '' }}</span>
        </div>
        <div>
          <strong>Descripción:</strong> {{ $promoData['descripcion'] ?? '' }}<br>
          <strong>Modalidad:</strong> {{ $promoData['modalidad'] ?? '' }}<br>
          <strong>Vigencia:</strong> {{ $promoData['fecha_inicio'] ?? '' }} a {{ $promoData['fecha_fin'] ?? '' }}<br>
          <strong>Observaciones:</strong> {{ $promoData['observaciones'] ?? '' }}
        </div>
        <div class="promo-imgs">
          @foreach($images as $img)
          <img src="{{ $img['public_url'] ?? $img['gcs_path'] ?? '' }}" alt="promo image" />
          @endforeach
        </div>
      </div>
      @empty
      <div style="grid-column:1/-1; padding:40px; text-align:center; color:var(--muted)">Sin resultados</div>
      @endforelse
    </div>
  </section>
</main>

{{-- ===== Modal ===== --}}
<dialog id="dlg">
  <div class="modal">
    <div class="modal-head">
      <div id="dlgTitle" class="title">Detalle</div>
      <button class="btn ghost" type="button" onclick="closeDlg()">Cerrar</button>
    </div>
    <div class="modal-body">
      <div>
        <img id="dlgHero" alt="Imagen principal" />
        <div id="dlgThumbs" class="thumbs-row"></div>
      </div>
      <div style="display:grid; gap:12px">
        <div class="kv">
          <div>Cadena</div>
          <div id="kvCadena"></div>
          <div>País</div>
          <div id="kvPais"></div>
          <div>Modalidad</div>
          <div id="kvModalidad"></div>
          <div>Tipo</div>
          <div id="kvTipo"></div>
          <div>Vigencia</div>
          <div id="kvVig"></div>
        </div>
        <div>
          <label style="font-weight:700">Descripción</label>
          <p id="kvDesc" style="margin:.3rem 0 0; color:var(--text)"></p>
        </div>
        <div>
          <label style="font-weight:700">Observaciones</label>
          <p id="kvObs" style="margin:.3rem 0 0; color:var(--muted)"></p>
        </div>
      </div>
    </div>
  </div>
</dialog>
{{-- ===== JS ===== --}}
<script>
// ====== Formateador auxiliar ======
function fmtRange(label){ return label; }

/*SECCIÓN 1 – IMÁGENES (acumular varias, previsualizar, quitar) */
let selectedFiles = [];

function syncInputFromState(){
  const input = document.getElementById('files');
  const dt = new DataTransfer();
  selectedFiles.forEach(f => dt.items.add(f));
  input.files = dt.files;
}

function resetPreviews(){
  selectedFiles = [];
  document.getElementById('previews').innerHTML = '';
  document.getElementById('files').value = '';
}

function handleFiles(files){
  const zone = document.getElementById('previews');
  [...files].forEach(file => {
    const exists = selectedFiles.some(f =>
      f.name === file.name && f.size === file.size && f.lastModified === file.lastModified
    );
    if (exists) return;

    selectedFiles.push(file);
    const reader = new FileReader();
    reader.onload = e => {
      const wrap = document.createElement('div');
      wrap.className = 'thumb';
      wrap.innerHTML = `
        <img src="${e.target.result}" alt="preview">
        <button title="Quitar">✕</button>
      `;
      wrap.querySelector('button').onclick = () => {
        selectedFiles = selectedFiles.filter(f =>
          !(f.name === file.name && f.size === file.size && f.lastModified === file.lastModified)
        );
        wrap.remove();
        syncInputFromState();
      };
      zone.appendChild(wrap);
    };
    reader.readAsDataURL(file);
  });
  syncInputFromState();
}

/*SECCIÓN 2 – CADENAS POR PAÍS (select dinámico)*/
const cadenasPorPais = {
  CR: ["Columbia","Adidas","Adoc","Aldo Nero","Arena","Arenas","Arenas Skate & Surf","Berskha","Best Brands","Cachos",
       "CAT - Caterpillar","Charly Loft","DelBarco","Ecco","Extremos","Flexi","Fusion","Hot Shoes","Hush Puppies",
       "Mix Shoes and Bags","Naturalizer","Nike","Nine West","Nuevo Mundo","Payless","Puma","Reebok","Simán","Skechers",
       "Sportline","The North Face","Timberland","UnoSport","Usaflex","Zapatto (CNC)","Zara","ZumZum"],
  SV: ["Adidas","Adoc","Aldo Nero","Berskha","CAT - Caterpillar","Columbia","Flexi","GAP","Hush Puppies","Idol Fashion Store",
       "Jam Calza","Kamar Store","Kenneth Cole","Lee Shoes","MD","Naturalizer","Nike","Nine West","Only Shoes","Par2",
       "Park Avenue","Payless","Prisma Moda","Puma","Sears","Simán","Skechers","Sportline","Stradivarius","The North Face",
       "Tienda Libre","Timberland","Usaflex","Via Brasil","Zara"],
  GT: ["Adidas","Adoc","Aldo Nero","Bass","Berskha","CAT - Caterpillar","Clarks","Cobán","Columbia","Converse","Flexi","GAP",
       "Hush Puppies","Kenneth Cole","Lee Shoes","MD","Naturalizer","Nike","Nine West","Par2","Payless","Prisma Moda","Puma",
       "Reebok","Rikely","Roy","Saúl E  Méndez","Simán","Skechers","SportCity","Sportline","Stradivarius","The North Face",
       "Timberland","Torre Blanca","Zara"],
  HN: ["Adidas","Adoc","Aldo Nero","Carrion","CAT - Caterpillar","Charly","Columbia","Diunsa","Flexi","Hush Puppies",
       "Kenneth Cole","Magic Shoes","MD","Naturalizer","Nike","Nine West","Par2","Payless","Puma","Reebok","Roy","Sermay",
       "Skechers","Sportline","The North Face","Timberland","Time Out"],
  NI: ["Adidas","Adoc","CAT - Caterpillar","Columbia","El Gran Mall","Flexi","Go Marcas","Hush Puppies","Kicks","MD",
       "Naturalizer","Nike","Nine West","Palm (Nuevo)","Par2","Payless","Puma","Shoes & More (Nuevo)","Simán","Sportline",
       "Timberland"],
  PA: ["ADIDAS","ALDO NERO","AQUA FASHION","BBB SHOES & BOOTS","BELLAGIO","BELLINI","CALZASHOES","CLARKS","COLUMBIA",
       "CONWAY","DOMANI","ECCO","EL TITAN","ENERGY","ESTAMPA","FELIX","FLEXI","FLORSHEIM","GUESS","JOHNSTON & MURPHY",
       "KENNETH COLE","MADISON","MERCADO DE CALZADO","MR. JONES","NINE WEST","OUTDOOR ADVENTURE","PAYLESS","SKECHERS",
       "SPORTLINE","STEVENS","STUDIO F","VÉLEZ"]
};
Object.keys(cadenasPorPais).forEach(k => {
  cadenasPorPais[k] = [...new Set(cadenasPorPais[k])];
});

function fillCadenasSelect(){
  const pais = document.getElementById('pais').value || '';
  const sel  = document.getElementById('cadena');
  const old  = sel.getAttribute('data-old') || '';
  const opciones = cadenasPorPais[pais] || [];
  sel.innerHTML = `<option value="" disabled ${old ? '' : 'selected'}>Seleccione cadena…</option>` +
    opciones.map(c => `<option value="${c}">${c}</option>`).join('');
  if (old && opciones.includes(old)) sel.value = old;
  sel.disabled = opciones.length === 0;
}
document.getElementById('pais').addEventListener('change', fillCadenasSelect);
fillCadenasSelect();

/* SECCIÓN 3 – FECHAS SIN INICIO/FIN */
function toggleFechas(noFecha){
  const iniEl = document.getElementById('ini');
  const finEl = document.getElementById('fin');
  if(noFecha){
    iniEl.value = ''; finEl.value = '';
    iniEl.disabled = true; finEl.disabled = true;
    iniEl.removeAttribute('required'); finEl.removeAttribute('required');
  } else {
    iniEl.disabled = false; finEl.disabled = false;
    iniEl.setAttribute('required',''); finEl.setAttribute('required','');
  }
}

/* SECCIÓN 4 – MODAL (detalle de promo)*/
async function openDlg(id){
  const res = await fetch(`{{ url('/promos') }}/${id}`);
  if(!res.ok) return alert('No se pudo cargar el detalle.');
  const p = await res.json();

  document.getElementById('dlgTitle').textContent = `${p.cadena} – ${p.tipo}`;
  document.getElementById('kvCadena').textContent = p.cadena;
  document.getElementById('kvPais').textContent = p.pais;
  document.getElementById('kvModalidad').textContent = p.modalidad;
  document.getElementById('kvTipo').textContent = p.tipo;
  document.getElementById('kvVig').textContent = fmtRange(p.vigencia);
  document.getElementById('kvDesc').textContent = p.descripcion;
  document.getElementById('kvObs').textContent = p.observaciones;

  const hero = document.getElementById('dlgHero');
  const thumbs = document.getElementById('dlgThumbs');
  hero.src = (p.images[0] || '');
  thumbs.innerHTML = '';
  p.images.forEach(src => {
    const im = document.createElement('img');
    im.src = src; im.onclick = () => hero.src = src;
    thumbs.appendChild(im);
  });
  document.getElementById('dlg').showModal();
}
function closeDlg(){ document.getElementById('dlg').close(); }

// Inicial
toggleFechas(false);
</script>
@endsection