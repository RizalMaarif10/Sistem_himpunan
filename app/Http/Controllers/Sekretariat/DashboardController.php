<?php

namespace App\Http\Controllers\Sekretariat;

use App\Http\Controllers\Controller;
use App\Models\Letter;
use App\Models\Minute;
use App\Models\Contact;

class DashboardController extends Controller
{
    public function index()
    {
        $unreadIncoming   = Letter::where('type','incoming')->whereNull('read_at')->count();
        $outgoingThisMonth= Letter::where('type','outgoing')
                                  ->whereMonth('date', now()->month)
                                  ->whereYear('date', now()->year)->count();
        $unreadMessages   = class_exists(Contact::class) ? Contact::whereNull('read_at')->count() : 0;

        return view('sekretariat.dashboard', compact('unreadIncoming','outgoingThisMonth','unreadMessages'));
    }
}
