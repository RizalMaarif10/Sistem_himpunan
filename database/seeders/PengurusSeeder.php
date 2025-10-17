<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PengurusSeeder extends Seeder
{
    public function run(): void
    {
        // Pastikan roles ada (hanya 3 sesuai kebutuhan)
        foreach ([
            ['name' => Role::ADMIN,      'display_name' => 'Admin'],
            ['name' => Role::SEKRETARIS, 'display_name' => 'Sekretaris'],
            ['name' => Role::BENDAHARA,  'display_name' => 'Bendahara'],
        ] as $r) {
            Role::firstOrCreate(['name' => $r['name']], ['display_name' => $r['display_name']]);
        }

        // Data akun pengurus (silakan ganti password/email setelah login)
        $users = [
            [
                'name'     => 'Admin HIMATEKNO',
                'email'    => 'admin@himatekno.test',
                'password' => 'Admin12345', // akan di-hash
                'roles'    => [Role::ADMIN],
            ],
            [
                'name'     => 'Sekretaris HIMATEKNO',
                'email'    => 'sekretaris@himatekno.test',
                'password' => 'Sekre12345',
                'roles'    => [Role::SEKRETARIS],
            ],
            [
                'name'     => 'Bendahara HIMATEKNO',
                'email'    => 'bendahara@himatekno.test',
                'password' => 'Bendahara12345',
                'roles'    => [Role::BENDAHARA],
            ],
        ];

        foreach ($users as $u) {
            // Buat user jika belum ada
            $user = User::firstOrCreate(
                ['email' => $u['email']],
                ['name' => $u['name'], 'password' => Hash::make($u['password'])]
            );

            // Kaitkan role ke user (tanpa duplikasi)
            $roleIds = Role::whereIn('name', $u['roles'])->pluck('id');
            $user->roles()->syncWithoutDetaching($roleIds);
        }
    }
}
