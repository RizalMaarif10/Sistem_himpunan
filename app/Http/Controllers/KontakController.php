<?php

namespace App\Http\Controllers;

use App\Models\Contact; // <- ganti ke Contact
use Illuminate\Http\Request;

class KontakController extends Controller
{
    public function index()
    {
        $info = [
            'address'   => 'Jl. KHA. Dahlan No.3, Purworejo, Jawa Tengah',
            'email'     => 'himatekno@gmail.com',
            'hours'     => 'Senin–Jumat, 09.00–16.00 WIB',
            'maps'      => 'https://maps.google.com/?q=Universitas+Muhammadiyah+Purworejo',
            'instagram' => 'https://www.instagram.com/himatekno_umpwr?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==',
        ];

        return view('kontak', compact('info'));
    }

    public function store(Request $request)
    {
        // Honeypot anti-bot
        if ($request->filled('website')) {
            return back()->with('error', 'Terjadi kesalahan.');
        }

        $data = $request->validate([
            'name'    => ['required','string','max:100'],
            'email'   => ['required','email','max:150'],
            'phone'   => ['nullable','string','max:30'],
            'subject' => ['nullable','string','max:150'],
            'message' => ['required','string','min:10'],
        ]);

        // tambah IP
        $data['ip_address'] = $request->ip();

        Contact::create($data);

        return back()->with('success', 'Pesan kamu sudah terkirim. Terima kasih!');
    }
}
