<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $fillable = ['name','display_name'];

    // Konstanta untuk nama role, biar konsisten
    public const ADMIN      = 'admin';
    public const BENDAHARA  = 'bendahara';
    public const SEKRETARIS = 'sekretaris';
    public const ANGGOTA    = 'anggota'; // opsional, bisa tambah kalau dipakai

    /**
     * Relasi ke User (many-to-many).
     */
    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
