<?php

namespace App\Http\Controllers;

class TentangController extends Controller
{
    public function index()
    {
        $visi = 'Menjadikan himpunan mahasiswa teknologi informasi yang bersatu, profesional, aktif dan dinamis secara internal maupun eksternal, serta menguatkan rasa kekeluargaan di lingkungan Teknologi Informasi.';

        $misi = [
            'Membangun hubungan yang harmonis dengan seluruh anggota himpunan.',
            'Memperluas relasi dengan mengoptimalkan kegiatan eksternal.',
            'Meningkatkan potensi mahasiswa teknologi informasi di bidang akademik maupun non akademik.',
            'Menjadikan Himpunan Mahasiswa Teknologi Informasi sebagai wadah bersosialisasi dan berbagi antar mahasiswa/i teknologi informasi.',
        ];

        $nilai = ['Integritas', 'Kolaborasi', 'Inovasi', 'Kontribusi'];

        $pengurusInti = [
            ['role' => 'Ketua',       'name' => 'Nama Ketua',     'photo' => 'images/avatar-default.png'],
            ['role' => 'Wakil Ketua', 'name' => 'Nama Wakil',     'photo' => 'images/avatar-default.png'],
            ['role' => 'Sekretaris',  'name' => 'Nama Sekretaris','photo' => 'images/avatar-default.png'],
            ['role' => 'Bendahara',   'name' => 'Nama Bendahara', 'photo' => 'images/avatar-default.png'],
        ];

        $socials = [
            ['label' => 'Instagram', 'url' => '#'],
            ['label' => 'YouTube',   'url' => '#'],
            ['label' => 'Email',     'url' => 'mailto:himatekno@contoh.ac.id'],
        ];

        // perhatikan: view nya "tentang" bukan "tentang.index"
        return view('tentang', compact('visi', 'misi', 'nilai', 'pengurusInti', 'socials'));
    }
}
