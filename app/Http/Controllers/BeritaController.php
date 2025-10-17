<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index(Request $request)
    {
        $q     = $request->string('q')->toString();   // pencarian
        $year  = $request->integer('year');          // arsip per tahun (opsional)
        $month = $request->integer('month');         // arsip per bulan (opsional)

        $posts = Post::query()
            ->where('status', 'published')
            ->when($q, function ($qr) use ($q) {
                $qr->where(function ($sub) use ($q) {
                    $sub->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('body', 'like', "%{$q}%");
                });
            })
            ->when($year, fn($qr) => $qr->whereYear('published_at', $year))
            ->when($month, fn($qr) => $qr->whereMonth('published_at', $month))
            ->latest('published_at')
            ->paginate(9)
            ->withQueryString();

        // daftar arsip (tahun-bulan) untuk sidebar/filter sederhana
        $archives = Post::query()
            ->where('status', 'published')
            ->selectRaw('YEAR(published_at) as year, MONTH(published_at) as month, COUNT(*) as total')
            ->groupBy('year', 'month')
            ->orderByRaw('MIN(published_at) DESC')
            ->get();

        return view('berita.index', compact('posts', 'q', 'year', 'month', 'archives'));
    }

    public function show(Post $post)
    {
        $related = Post::query()
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)->get();

        return view('berita.show', compact('post', 'related'));
    }
}
