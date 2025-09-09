<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class KategoriBerita extends Model
{
    protected $fillable = [
        'nama_kategori',
        'slug',
        'deskripsi',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->nama_kategori);
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('nama_kategori') && empty($model->slug)) {
                $model->slug = Str::slug($model->nama_kategori);
            }
        });
    }

    public function beritas(): HasMany
    {
        return $this->hasMany(Berita::class);
    }

    public function beritasPublished(): HasMany
    {
        return $this->hasMany(Berita::class)->where('status', 'published');
    }
}
