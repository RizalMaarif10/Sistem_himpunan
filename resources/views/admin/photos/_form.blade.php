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
      <input type="text" name="title" value="{{ old('title', $photo->title) }}" required
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Keterangan (caption)</label>
      <textarea name="caption" rows="5"
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('caption', $photo->caption) }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Gambar (JPG/PNG/WEBP, maks 2MB)</label>
      <input type="file" name="image_path" accept="image/*" class="w-full border rounded-lg px-3 py-2">
      @if($photo->image_url)
        <div class="mt-2 w-44 aspect-[4/5] overflow-hidden rounded-lg border bg-gray-50">
          <img src="{{ $photo->image_url }}" alt="Preview" class="w-full h-full object-cover object-center">
        </div>
      @endif
    </div>
  </div>

  {{-- Sidebar --}}
  <div class="md:col-span-2 space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Tanggal Diambil</label>
      <input type="datetime-local" name="taken_at"
             value="{{ old('taken_at', optional($photo->taken_at)->format('Y-m-d\TH:i')) }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
      <p class="mt-1 text-xs text-gray-500">Opsional. Jika dikosongkan akan pakai tanggal unggah.</p>
    </div>
  </div>
</div>

<div class="mt-6 flex items-center gap-3">
  <button class="btn btn-primary" type="submit">Simpan</button>
  <a href="{{ route('admin.photos.index') }}" class="btn btn-outline">Batal</a>
</div>
