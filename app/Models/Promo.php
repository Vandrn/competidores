<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Promo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'pais', 'modalidad', 'cadena', 'tipo', 'descripcion',
        'fecha_inicio', 'fecha_fin', 'observaciones'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin'    => 'date',
    ];

    public function images() {
        return $this->hasMany(PromoImage::class);
    }

    public function getVigenciaLabelAttribute(): string
    {
        if ($this->fecha_inicio && $this->fecha_fin) {
            return $this->fecha_inicio->format('d/m/Y').' – '.$this->fecha_fin->format('d/m/Y');
        }
        return 'Sin fecha';
    }
}
