<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name','email','password'];

    // Sembunyikan saat toArray()/JSON
    protected $hidden = ['password', 'remember_token'];

    // Cast standar; password otomatis di-hash
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function roles()
    {
        // Pivot: role_user (default Laravel) + timestamps
        return $this->belongsToMany(Role::class)->withTimestamps();
    }

    /** Cek punya salah satu role yang diberikan */
    public function hasRole(string ...$names): bool
    {
        $roles = $this->relationLoaded('roles') ? $this->roles : $this->roles()->get();
        return $roles->pluck('name')->intersect($names)->isNotEmpty();
    }

    /** Helper: khusus cek 3 pengurus */
    public function isPengurus(): bool
    {
        return $this->hasRole('admin','sekretaris','bendahara');
    }

    /** Assign role berdasarkan name tanpa duplikasi */
    public function assignRole(string ...$names): void
    {
        $ids = Role::whereIn('name', $names)->pluck('id');
        if ($ids->isNotEmpty()) {
            $this->roles()->syncWithoutDetaching($ids);
        }
    }

    /** Ganti seluruh role dengan yang baru */
    public function syncRoles(string ...$names): void
    {
        $ids = Role::whereIn('name', $names)->pluck('id');
        $this->roles()->sync($ids);
    }
}
