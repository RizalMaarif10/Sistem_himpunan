<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ([
            ['name' => Role::ADMIN,      'display_name' => 'Admin'],
            ['name' => Role::SEKRETARIS, 'display_name' => 'Sekretaris'],
            ['name' => Role::BENDAHARA,  'display_name' => 'Bendahara'],
        ] as $r) {
            Role::firstOrCreate(['name' => $r['name']], ['display_name' => $r['display_name']]);
        }
    }
}
