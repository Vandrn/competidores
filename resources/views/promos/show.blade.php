@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Detalle de Promoción</h2>
    <div class="card mb-4">
        <div class="card-header">
            <strong>{{ $promo['promos'][0]['cadena'] ?? '' }}</strong>
            <span class="badge bg-primary">{{ $promo['promos'][0]['modalidad'] ?? '' }}</span>
        </div>
        <div class="card-body">
            <p><strong>Tipo:</strong> {{ $promo['promos'][0]['tipo'] ?? '' }}</p>
            <p><strong>Descripción:</strong> {{ $promo['promos'][0]['descripcion'] ?? '' }}</p>
            <p><strong>Fechas:</strong> {{ $promo['promos'][0]['fecha_inicio'] ?? 'Sin fecha' }} a {{ $promo['promos'][0]['fecha_fin'] ?? 'Sin fecha' }}</p>
            <p><strong>Observaciones:</strong> {{ $promo['promos'][0]['observaciones'] ?? 'N/A' }}</p>
            <p><strong>País:</strong> {{ $promo['pais'] ?? '' }}</p>
            <div class="row">
                @if(isset($promo['promos'][0]['images']) && is_array($promo['promos'][0]['images']))
                    @foreach($promo['promos'][0]['images'] as $img)
                        <div class="col-md-3 mb-2">
                            <img src="{{ $img['public_url'] }}" class="img-fluid rounded" alt="Promo image">
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <a href="{{ route('promos.index') }}" class="btn btn-secondary">Volver</a>
</div>
@endsection
