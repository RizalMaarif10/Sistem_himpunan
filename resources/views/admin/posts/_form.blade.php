@csrf
@if ($errors->any())
  <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
    <ul class="list-disc pl-5 space-y-1">
      @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
    </ul>
  </div>
@endif

<div class="grid md:grid-cols-5 gap-5">
  {{-- Kolom utama --}}
  <div class="md:col-span-3 space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Judul <span class="text-red-600">*</span></label>
      <input type="text" name="title" value="{{ old('title', $post->title) }}" required
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Ringkasan (excerpt)</label>
      <input type="text" name="excerpt" value="{{ old('excerpt', $post->excerpt) }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Opsional, max 300 karakter">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Isi Berita <span class="text-red-600">*</span></label>
      <textarea name="content" rows="10" required
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('content', $post->content) }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Cover (JPG/PNG/WEBP, maks 2MB)</label>
      <input type="file" name="cover_image" accept="image/*" class="w-full border rounded-lg px-3 py-2">
      @if($post->cover_image)
        <div class="mt-2 w-44 aspect-[4/5] overflow-hidden rounded-lg border bg-gray-50">
          <img src="{{ asset('storage/'.$post->cover_image) }}" alt="Cover" class="w-full h-full object-cover object-center">
        </div>
      @endif
    </div>
  </div>

  {{-- Sidebar --}}
  <div class="md:col-span-2 space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Status</label>
      @php $st = old('status', $post->status); @endphp
      <select name="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="draft"     {{ $st==='draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ $st==='published' ? 'selected' : '' }}>Published</option>
        <option value="archived"  {{ $st==='archived' ? 'selected' : '' }}>Diarsipkan</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Tanggal Publikasi</label>
      <input type="datetime-local" name="published_at"
             value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      <p class="mt-1 text-xs text-gray-500">Diabaikan bila status bukan <b>Published</b>.</p>
    </div>
  </div>
</div>

<div class="mt-6 flex items-center gap-3">
  <button class="btn btn-primary" type="submit">Simpan</button>
  <a href="{{ route('admin.posts.index') }}" class="btn btn-outline">Batal</a>
</div>
