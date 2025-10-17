<?php

namespace App\Http\Controllers;

use App\Models\Photo;

class GaleriController extends Controller
{
    public function index()
    {
        $photos = Photo::query()
            ->orderByDesc('taken_at')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('galeri.index', compact('photos'));
    }

    public function show(Photo $photo)
    {
        $more = Photo::query()
            ->where('id', '!=', $photo->id)
            ->orderByDesc('taken_at')
            ->orderByDesc('created_at')
            ->take(6)
            ->get();

        return view('galeri.show', compact('photo', 'more'));
    }
}
