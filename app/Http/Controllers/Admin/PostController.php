<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::query()
            ->when(request('q'), fn($q) =>
                $q->where('title','like','%'.request('q').'%')
                  ->orWhere('excerpt','like','%'.request('q').'%')
            )
            ->latest('published_at')->latest()
            ->paginate(9);

        return view('admin.posts.index', compact('posts'));
    }

    public function create()
    {
        $post = new Post([
            'status' => 'draft',
            'published_at' => now(),
        ]);
        return view('admin.posts.create', compact('post'));
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        // slug akan dibuat otomatis oleh model kamu saat creating jika kosong
        $data['user_id'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('posts', 'public');
        }

        // published_at hanya dipakai jika status published
        if (($data['status'] ?? 'draft') !== 'published') {
            $data['published_at'] = null;
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $data = $this->validated($request, updating:true);

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image) Storage::disk('public')->delete($post->cover_image);
            $data['cover_image'] = $request->file('cover_image')->store('posts', 'public');
        }

        if (($data['status'] ?? $post->status) !== 'published') {
            $data['published_at'] = null;
        }

        // Biarkan slug tetap (modelmu hanya set saat creating)
        $post->update($data);

        return redirect()->route('admin.posts.index')->with('success', 'Berita diperbarui.');
    }

    public function destroy(Post $post)
    {
        if ($post->cover_image) Storage::disk('public')->delete($post->cover_image);
        $post->delete();

        return back()->with('success', 'Berita dihapus.');
    }

    private function validated(Request $request, bool $updating = false): array
    {
        return $request->validate([
            'title'         => ['required','string','max:255'],
            'excerpt'       => ['nullable','string','max:300'],
            'content'       => ['required','string'],
            'status'        => ['required','in:draft,published,archived'],
            'published_at'  => ['nullable','date'],
            'cover_image'   => [$updating ? 'nullable' : 'nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
        ]);
    }
}
