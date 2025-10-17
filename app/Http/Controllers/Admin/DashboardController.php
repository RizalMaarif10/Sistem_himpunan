<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Post;
use App\Models\Photo;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $user            = auth()->user()->loadMissing('roles');
        $eventsCount     = Event::count();
        $upcomingEvents  = Event::whereNotNull('start_at')->where('start_at', '>=', now())->count();
        $postsCount      = Post::where('status','published')->count();
        $photosCount     = Photo::count();
        $messagesCount   = Contact::count();

        return view('admin.dashboard', compact(
            'user','eventsCount','upcomingEvents','postsCount','photosCount','messagesCount'
        ));
    }
}
