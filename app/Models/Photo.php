<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_path',
        'caption',
        'taken_at',
    ];

    protected $casts = [
        'taken_at' => 'datetime',
    ];

    /**
     * URL publik ke gambar di storage (null jika kosong).
     */
    public function getImageUrlAttribute(): ?string
    {
        return $this->image_path ? asset('storage/'.$this->image_path) : null;
    }

    /**
     * Scope: pencarian judul/keterangan.
     */
    public function scopeSearch($query, ?string $q)
    {
        if (!$q) return $query;

        return $query->where(function ($sub) use ($q) {
            $sub->where('title', 'like', "%{$q}%")
                ->orWhere('caption', 'like', "%{$q}%");
        });
    }

    /**
     * Scope: filter berdasarkan tahun pengambilan.
     */
    public function scopeYear($query, ?int $year)
    {
        if (!$year) return $query;

        return $query->whereYear('taken_at', $year);
    }
}
