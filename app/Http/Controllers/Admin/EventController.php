<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    public function index()
{
    $events = Event::query()
        ->orderByDesc('start_at')
        ->orderByDesc('created_at')
        ->paginate(12); // tanpa withQueryString()

    return view('admin.events.index', compact('events'));
}


    public function create()
    {
        $event = new Event(['status' => 'draft', 'type' => 'event']);
        return view('admin.events.create', compact('event'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);
        if (auth()->check()) $data['user_id'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event = Event::create($data);

        return redirect()->route('admin.events.edit', $event)
            ->with('success', 'Agenda berhasil ditambahkan.');
    }

    public function edit(Event $event)
    {
        return view('admin.events.edit', compact('event'));
    }

    public function update(Request $request, Event $event)
    {
        $data = $this->validated($request, $event->id);

        if ($event->title !== $data['title']) {
            $data['slug'] = $this->uniqueSlug($data['title'], $event->id);
        }

        if ($request->hasFile('cover_image')) {
            if ($event->cover_image && Storage::disk('public')->exists($event->cover_image)) {
                Storage::disk('public')->delete($event->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('events', 'public');
        }

        $event->update($data);

        return back()->with('success', 'Agenda berhasil diperbarui.');
    }

    public function destroy(Event $event)
    {
        if ($event->cover_image && Storage::disk('public')->exists($event->cover_image)) {
            Storage::disk('public')->delete($event->cover_image);
        }
        $event->delete();

        return redirect()->route('admin.events.index')->with('success', 'Agenda dihapus.');
    }

    /* ===== Helpers ===== */

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title'             => ['required','string','max:200'],
            'type'              => ['required','in:event,lomba'],
            'status'            => ['required','in:draft,published'],
            'description'       => ['nullable','string'],
            'location'          => ['nullable','string','max:200'],
            'start_at'          => ['nullable','date'],
            'end_at'            => ['nullable','date','after_or_equal:start_at'],
            'registration_link' => ['nullable','url','max:255'],
            'cover_image'       => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ], [], [
            'title'  => 'Judul',
            'type'   => 'Tipe',
            'status' => 'Status',
        ]);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            Event::where('slug', $slug)
                ->when($ignoreId, fn($qr) => $qr->where('id','!=',$ignoreId))
                ->exists()
        ) {
            $slug = $base.'-'.$i++;
        }
        return $slug;
    }
}
