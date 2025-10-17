@csrf
@if ($errors->any())
  <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
    <ul class="list-disc pl-5">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
  </div>
@endif

<div class="grid md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-medium mb-1">Tipe Surat</label>
    <select name="type" class="w-full border rounded-lg px-3 py-2">
      <option value="incoming" {{ old('type',$letter->type)=='incoming'?'selected':'' }}>Masuk</option>
      <option value="outgoing" {{ old('type',$letter->type)=='outgoing'?'selected':'' }}>Keluar</option>
    </select>
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Tanggal</label>
    <input type="date" name="date" value="{{ old('date', optional($letter->date)->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2" required>
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Nomor (opsional)</label>
    <input type="text" name="number" value="{{ old('number',$letter->number) }}" class="w-full border rounded-lg px-3 py-2">
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Perihal</label>
    <input type="text" name="subject" value="{{ old('subject',$letter->subject) }}" class="w-full border rounded-lg px-3 py-2" required>
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Dari (untuk Surat Masuk)</label>
    <input type="text" name="from_name" value="{{ old('from_name',$letter->from_name) }}" class="w-full border rounded-lg px-3 py-2">
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Kepada (untuk Surat Keluar)</label>
    <input type="text" name="to_name" value="{{ old('to_name',$letter->to_name) }}" class="w-full border rounded-lg px-3 py-2">
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">Catatan</label>
    <textarea name="notes" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('notes',$letter->notes) }}</textarea>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">Berkas (PDF/JPG/PNG, maks 4MB)</label>
    <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png,.webp" class="w-full border rounded-lg px-3 py-2">
    @if($letter->file_path)
      <div class="mt-2 text-sm"><a class="text-blue-600 underline" target="_blank" href="{{ asset('storage/'.$letter->file_path) }}">Lihat berkas</a></div>
    @endif
  </div>
</div>

<div class="mt-5 flex items-center gap-3">
  <button class="px-5 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600">Simpan</button>
  <a href="{{ route('sekretariat.letters.index') }}" class="px-5 py-2 rounded-lg border">Batal</a>
</div>
