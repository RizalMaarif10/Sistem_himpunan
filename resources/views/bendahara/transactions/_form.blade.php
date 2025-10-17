@csrf
@if ($errors->any())
  <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
    <ul class="list-disc pl-5">@foreach ($errors->all() as $err)<li>{{ $err }}</li>@endforeach</ul>
  </div>
@endif

<div class="grid md:grid-cols-2 gap-4">
  <div>
    <label class="block text-sm font-medium mb-1">Tanggal</label>
    <input type="date" name="date" value="{{ old('date', optional($tx->date)->format('Y-m-d')) }}" class="w-full border rounded-lg px-3 py-2" required>
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Rekening</label>
    <select name="account_id" class="w-full border rounded-lg px-3 py-2" required>
      <option value="">— Pilih Rekening —</option>
      @foreach($accounts as $a)
        <option value="{{ $a->id }}" {{ old('account_id', $tx->account_id)==$a->id?'selected':'' }}>{{ $a->name }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Kategori</label>
    <select name="category_id" class="w-full border rounded-lg px-3 py-2" required>
      <option value="">— Pilih Kategori —</option>
      @foreach($categories as $c)
        <option value="{{ $c->id }}" {{ old('category_id', $tx->category_id)==$c->id?'selected':'' }}>{{ $c->name }}</option>
      @endforeach
    </select>
  </div>
  <div>
    <label class="block text-sm font-medium mb-1">Jumlah (Rp)</label>
    <input type="number" name="amount" min="0" step="1" value="{{ old('amount', $tx->amount) }}" class="w-full border rounded-lg px-3 py-2" required>
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">No. Referensi (opsional)</label>
    <input type="text" name="ref" value="{{ old('ref', $tx->ref) }}" class="w-full border rounded-lg px-3 py-2">
  </div>
  <div class="md:col-span-2">
    <label class="block text-sm font-medium mb-1">Keterangan</label>
    <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('description', $tx->description) }}</textarea>
  </div>
</div>

<div class="mt-5 flex items-center gap-3">
  <button class="px-5 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600">Simpan</button>
  <a href="{{ url()->previous() }}" class="px-5 py-2 rounded-lg border">Batal</a>
</div>
