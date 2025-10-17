@csrf
@if ($errors->any())
  <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
    <ul class="list-disc pl-5">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
  </div>
@endif

<div class="grid md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-medium mb-1">Judul</label>
    <input type="text" name="title" value="{{ old('title',$minute->title) }}" class="w-full border rounded-lg px-3 py-2" required>
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Tanggal Rapat</label>
    <input type="date" name="meeting_date" value="{{ old('meeting_date', optional($minute->meeting_date)->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2" required>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">Catatan</label>
    <textarea name="notes" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('notes',$minute->notes) }}</textarea>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">Berkas (PDF/DOC/JPG/PNG, maks 6MB)</label>
    <input type="file" name="file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp" class="w-full border rounded-lg px-3 py-2">
    @if($minute->file_path)
      <div class="mt-2 text-sm"><a class="text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$minute->file_path) }}">Lihat berkas</a></div>
    @endif
  </div>
</div>

<div class="mt-5 flex items-center gap-3">
  <button class="px-5 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600">Simpan</button>
  <a href="{{ route('sekretariat.minutes.index') }}" class="px-5 py-2 rounded-lg border">Batal</a>
</div>
