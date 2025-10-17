@csrf

@if ($errors->any())
  <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
    <ul class="list-disc pl-5 space-y-1">
      @foreach ($errors->all() as $err)
        <li>{{ $err }}</li>
      @endforeach
    </ul>
  </div>
@endif

<div class="grid md:grid-cols-5 gap-5">
  {{-- Kolom utama --}}
  <div class="md:col-span-3 space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Judul <span class="text-red-600">*</span></label>
      <input type="text" name="title" value="{{ old('title', $event->title) }}" required
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Deskripsi <span class="text-red-600">*</span></label>
      <textarea name="description" rows="8" required
                class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('description', $event->description) }}</textarea>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Cover (JPG/PNG/WEBP, maks 2MB)</label>
      <input type="file" name="cover_image" accept="image/*"
             class="w-full border rounded-lg px-3 py-2">
      @if($event->cover_image)
  <div class="mt-2 w-44 aspect-[4/5] overflow-hidden rounded-lg border bg-gray-50">
    <img src="{{ asset('storage/'.$event->cover_image) }}" alt="Cover"
         class="w-full h-full object-cover object-center">
  </div>
@endif

    </div>
  </div>

  {{-- Sidebar --}}
  <div class="md:col-span-2 space-y-4">
    <div>
      <label class="block text-sm font-medium mb-1">Tipe</label>
      <select name="type" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="event" {{ old('type', $event->type) === 'event' ? 'selected' : '' }}>Event</option>
        <option value="lomba" {{ old('type', $event->type) === 'lomba' ? 'selected' : '' }}>Lomba</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Status</label>
      <select name="status" class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
        <option value="draft" {{ old('status', $event->status) === 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="published" {{ old('status', $event->status) === 'published' ? 'selected' : '' }}>Published</option>
        <option value="finished" {{ old('status', $event->status) === 'finished' ? 'selected' : '' }}>Selesai</option>
        <option value="archived" {{ old('status', $event->status) === 'archived' ? 'selected' : '' }}>Diarsipkan</option>
      </select>
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Lokasi (opsional)</label>
      <input type="text" name="location" value="{{ old('location', $event->location) }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Mulai <span class="text-red-600">*</span></label>
      <input type="datetime-local" name="start_at" required
             value="{{ old('start_at', optional($event->start_at)->format('Y-m-d\TH:i')) }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Selesai (opsional)</label>
      <input type="datetime-local" name="end_at"
             value="{{ old('end_at', optional($event->end_at)->format('Y-m-d\TH:i')) }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>

    <div>
      <label class="block text-sm font-medium mb-1">Link Pendaftaran (opsional)</label>
      <input type="url" name="registration_link" placeholder="https://..."
             value="{{ old('registration_link', $event->registration_link) }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
    </div>
  </div>
</div>

<div class="mt-6 flex items-center gap-3">
  <button class="btn btn-primary" type="submit">Simpan</button>
  <a href="{{ route('admin.events.index') }}" class="btn btn-outline">Batal</a>
</div>
