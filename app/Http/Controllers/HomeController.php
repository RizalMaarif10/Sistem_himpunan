<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Event;
use App\Models\Photo;

class HomeController extends Controller
{
    public function index()
    {
        $events = Event::where('status', 'published')
            ->orderBy('start_at', 'asc')
            ->take(4)
            ->get(['id','title','slug','start_at','location','cover_image','description','registration_link']);

        $posts = Post::where('status', 'published')
            ->orderByDesc('published_at')
            ->take(4)
            ->get(['id','title','slug','excerpt','cover_image','published_at']);

        $photos = Photo::orderByDesc('created_at')
            ->take(3)
            ->get(['id','title','image_path']);

        return view('home.index', compact('events','posts','photos'));
    }
}
