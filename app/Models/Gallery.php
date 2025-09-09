<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Gallery extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'deskripsi',
        'gambar',
        'kategori',
        'user_id',
        'is_active',
        'urutan',
        'tanggal_foto',
        'tags'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'tanggal_foto' => 'date',
        'tags' => 'array',
        'urutan' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('judul') && empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan')->orderBy('tanggal_foto', 'desc');
    }

    public static function getKategoriOptions()
    {
        return [
            'kegiatan_sekolah' => 'Kegiatan Sekolah',
            'prestasi' => 'Prestasi',
            'fasilitas' => 'Fasilitas',
            'acara_khusus' => 'Acara Khusus',
            'lainnya' => 'Lainnya'
        ];
    }
}
