<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AgendaController extends Controller
{
    public function index(Request $request)
    {
        $tab  = $request->get('tab', 'all'); // upcoming | past | all
        $type = $request->get('type');            // event | lomba (opsional)

        $events = Event::query()
            ->where('status', 'published')
            // hanya filter 'type' kalau kolomnya MEMANG ada & ada valuenya
            ->when($type && Schema::hasColumn('events', 'type'), fn($q) => $q->where('type', $type));

        if ($tab === 'past') {
            $events->whereNotNull('start_at')
                   ->where('start_at', '<', now())
                   ->orderByDesc('start_at');
        } elseif ($tab === 'all') {
            // NULL di akhir, terbaru dulu
            $events->orderByRaw('start_at IS NULL, start_at DESC');
        } else {
            // upcoming (default): yang belum lewat, NULL dianggap “TBA”
            $events->where(fn($q) => $q->whereNull('start_at')->orWhere('start_at', '>=', now()))
                   ->orderByRaw('start_at IS NULL, start_at ASC');
        }

        $events = $events->paginate(9)->withQueryString();

        // 'q' diset null untuk kompatibilitas view lama (kalau masih dipanggil)
        return view('agenda.index', ['events' => $events, 'tab' => $tab, 'type' => $type, 'q' => null]);
    }

    public function show(Event $event)
    {
        // Related: aman bila kolom 'type' tidak ada
        $related = Event::query()
            ->where('status', 'published')
            ->where('id', '!=', $event->id)
            ->when(Schema::hasColumn('events', 'type') && !empty($event->type),
                   fn($q) => $q->where('type', $event->type))
            ->where(fn($q) => $q->whereNull('start_at')->orWhere('start_at', '>=', now()))
            ->orderBy('start_at')
            ->limit(3)
            ->get();

        return view('agenda.show', compact('event', 'related'));
    }
}
