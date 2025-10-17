@php
  $isEdit = isset($method) && in_array($method, ['PUT','PATCH']);
  $type   = old('type', $item->type ?? 'cash');
@endphp

<div class="bg-white rounded-2xl border shadow-sm p-5 md:p-6">
  <div class="flex items-center gap-3 mb-4">
    <div class="h-9 w-9 rounded-full bg-slate-900 text-white grid place-items-center">
      {{-- icon plus/pencil --}}
      @if($isEdit)
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M3 17.25V21h3.75L18.81 8.94l-3.75-3.75L3 17.25zM20.71 7.04a1.003 1.003 0 000-1.42l-2.34-2.34a1.003 1.003 0 00-1.42 0l-1.83 1.83 3.75 3.75 1.84-1.82z"/></svg>
      @else
        <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor"><path d="M11 11V5h2v6h6v2h-6v6h-2v-6H5v-2h6z"/></svg>
      @endif
    </div>
    <div>
      <h2 class="text-xl font-semibold leading-tight">{{ $title }}</h2>
      <p class="text-xs text-gray-500">Isi data akun dengan benar untuk memudahkan pencatatan.</p>
    </div>
  </div>

  @if($errors->any())
    <div class="mb-4 rounded-lg border border-red-200 bg-red-50 text-red-700 px-4 py-3">
      Ada isian yang perlu dicek ulang.
    </div>
  @endif

  <form method="POST" action="{{ $action }}" novalidate class="grid gap-4 md:grid-cols-2">
    @csrf
    @if($isEdit) @method($method) @endif

    {{-- Nama --}}
    <div class="md:col-span-1">
      <label class="block text-sm font-medium mb-1">Nama</label>
      <input type="text" name="name"
             value="{{ old('name', $item->name ?? '') }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300" required>
      @error('name') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Kode --}}
    <div class="md:col-span-1">
      <label class="block text-sm font-medium mb-1">Kode <span class="text-gray-400">(opsional)</span></label>
      <input type="text" name="code"
             value="{{ old('code', $item->code ?? '') }}"
             class="w-full border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300">
      @error('code') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Tipe (segmented) --}}
    <div class="md:col-span-1">
      <label class="block text-sm font-medium mb-1">Tipe</label>
      <div class="flex gap-2">
        <label class="cursor-pointer">
          <input type="radio" name="type" value="cash" class="sr-only peer" {{ $type=='cash'?'checked':'' }}>
          <span class="inline-block px-3 py-2 rounded-lg border peer-checked:bg-emerald-600 peer-checked:text-white peer-checked:border-emerald-600">
            Cash
          </span>
        </label>
        <label class="cursor-pointer">
          <input type="radio" name="type" value="bank" class="sr-only peer" {{ $type=='bank'?'checked':'' }}>
          <span class="inline-block px-3 py-2 rounded-lg border peer-checked:bg-sky-600 peer-checked:text-white peer-checked:border-sky-600">
            Bank
          </span>
        </label>
        <label class="cursor-pointer">
          <input type="radio" name="type" value="other" class="sr-only peer" {{ $type=='other'?'checked':'' }}>
          <span class="inline-block px-3 py-2 rounded-lg border peer-checked:bg-slate-700 peer-checked:text-white peer-checked:border-slate-700">
            Other
          </span>
        </label>
      </div>
      @error('type') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Saldo Awal (input group Rp) --}}
    <div class="md:col-span-1">
      <label class="block text-sm font-medium mb-1">Saldo Awal</label>
      <div class="flex rounded-lg border overflow-hidden focus-within:ring-2 focus-within:ring-slate-300">
        <span class="px-3 py-2 bg-gray-50 text-gray-600 border-r">Rp</span>
        <input type="number" name="opening_balance" min="0" step="1"
               value="{{ old('opening_balance', $item->opening_balance ?? 0) }}"
               class="w-full px-3 py-2 outline-none">
      </div>
      <p class="mt-1 text-[11px] text-gray-500">Masukkan angka tanpa titik/koma.</p>
      @error('opening_balance') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
    </div>

    {{-- Actions --}}
    <div class="md:col-span-2 mt-1 flex items-center gap-2">
      <button class="px-5 py-2.5 rounded-lg bg-slate-900 text-white hover:bg-slate-800">{{ $submitLabel }}</button>
      <a href="{{ route('bendahara.accounts.index') }}" class="px-5 py-2.5 rounded-lg border hover:bg-gray-50">Batal</a>
      @if($isEdit)
        <span class="ml-auto text-xs text-gray-500">Diperbarui: {{ optional($item->updated_at)->format('d M Y H:i') }}</span>
      @endif
    </div>
  </form>
</div>
