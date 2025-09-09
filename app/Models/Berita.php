<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Berita extends Model
{
    protected $fillable = [
        'judul',
        'slug',
        'konten',
        'excerpt',
        'gambar_utama',
        'kategori_berita_id',
        'user_id',
        'status',
        'published_at',
        'views',
        'is_featured',
        'tags'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_featured' => 'boolean',
        'tags' => 'array',
        'views' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
            if (empty($model->excerpt) && !empty($model->konten)) {
                $model->excerpt = Str::limit(strip_tags($model->konten), 150);
            }
        });
        
        static::updating(function ($model) {
            if ($model->isDirty('judul') && empty($model->slug)) {
                $model->slug = Str::slug($model->judul);
            }
            if ($model->isDirty('konten') && empty($model->excerpt)) {
                $model->excerpt = Str::limit(strip_tags($model->konten), 150);
            }
        });
    }

    public function kategoriBerita(): BelongsTo
    {
        return $this->belongsTo(KategoriBerita::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the tags attribute.
     *
     * @param  string|array  $value
     * @return void
     */
    public function setTagsAttribute($value)
    {
        if (is_string($value)) {
            // Convert comma-separated string to array
            $this->attributes['tags'] = json_encode(array_map('trim', explode(',', $value)));
        } elseif (is_array($value)) {
            // If it's already an array, just encode it
            $this->attributes['tags'] = json_encode($value);
        }
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
                    ->whereNotNull('published_at')
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function incrementViews()
    {
        $this->increment('views');
    }
}
