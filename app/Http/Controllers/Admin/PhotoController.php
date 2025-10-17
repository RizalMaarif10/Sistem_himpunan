<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoController extends Controller
{
    public function index()
    {
        $photos = Photo::query()
            ->latest('taken_at')
            ->latest()                // fallback jika taken_at null
            ->paginate(12);

        return view('admin.photos.index', compact('photos'));
    }

    public function create()
    {
        $photo = new Photo(['taken_at' => now()]);
        return view('admin.photos.create', compact('photo'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image_path')) {
            $data['image_path'] = $request->file('image_path')->store('gallery', 'public');
        }

        Photo::create($data);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Foto berhasil ditambahkan.');
    }

    public function edit(Photo $photo)
    {
        return view('admin.photos.edit', compact('photo'));
    }

    public function update(Request $request, Photo $photo)
    {
        $data = $this->validated($request, updating:true);

        if ($request->hasFile('image_path')) {
            if ($photo->image_path) Storage::disk('public')->delete($photo->image_path);
            $data['image_path'] = $request->file('image_path')->store('gallery', 'public');
        }

        $photo->update($data);

        return redirect()->route('admin.photos.index')
            ->with('success', 'Foto berhasil diperbarui.');
    }

    public function destroy(Photo $photo)
    {
        if ($photo->image_path) Storage::disk('public')->delete($photo->image_path);
        $photo->delete();

        return back()->with('success', 'Foto dihapus.');
    }

    // --- Helpers ---
    private function validated(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'title'      => ['required','string','max:255'],
            'caption'    => ['nullable','string'],
            'taken_at'   => ['nullable','date'],
            'image_path' => [$updating ? 'nullable' : 'required', 'image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);
    }
}
