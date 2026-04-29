<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PromoImage extends Model
{
    protected $fillable = ['promo_id','path','original_name'];

    public function promo() {
        return $this->belongsTo(Promo::class);
    }

    public function getUrlAttribute(): string
    {
        return Storage::url($this->path);
    }
}
