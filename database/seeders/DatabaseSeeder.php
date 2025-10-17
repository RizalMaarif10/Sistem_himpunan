<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\Event;
use App\Models\Post;
use App\Models\Photo;

class DatabaseSeeder extends Seeder
{
    public function run(): void
{
    $this->call([
        PengurusSeeder::class,
    ]);
}
}
