@extends('sekretariat.layouts.app')
@section('title','Surat')

@section('content')
@php
  // Label untuk header cetak
  $typeLabel = $type === 'incoming' ? 'Masuk' : ($type === 'outgoing' ? 'Keluar' : 'Semua');
@endphp

{{-- ========== PRINT CSS ========== --}}
<style>
  @page{ size:A4 portrait; margin:14mm 12mm; }
  @media print{
    nav,header,footer,.screen-only{display:none!important}
    .print-only{display:block!important}
    html,body{background:#fff!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}
    table{width:100%;border-collapse:collapse}
    thead{display:table-header-group}
    tfoot{display:table-row-group}
    th,td{border:1px solid #dcdcdc;padding:6px 8px;font-size:12px}
    thead th{background:#f6f6f6}
    .metric{border:1px solid #e5e7eb;border-radius:8px;padding:8px;margin:8px 0}
    .metric-title{font-size:11px;color:#64748b;text-transform:uppercase;letter-spacing:.3px}
    .metric-value{font-weight:700;font-size:18px;color:#0f172a}
    .sig-grid{display:grid;grid-template-columns:1fr 1fr;gap:16mm;margin-top:14mm}
    .sig-box{border:1px dashed #cfd4dc;padding:10mm;min-height:48mm;display:flex;flex-direction:column;justify-content:space-between}
    .sig-line{margin-top:12mm;border-top:1px solid #222;text-align:center;padding-top:2mm}
  }
  .print-only{display:none}
</style>
@if(request('print')) <script>addEventListener('load',()=>print());</script> @endif

{{-- =======================  SCREEN  ======================= --}}
<div class="screen-only">
  <div class="mb-6 flex items-center justify-between">
    <h1 class="text-2xl md:text-3xl font-bold">Surat</h1>
    <div class="flex gap-2">
      {{-- Tab filter: Semua, Masuk, Keluar --}}
      <a href="{{ route('sekretariat.letters.index',['type'=>'all']) }}"
         class="px-3 py-2 rounded-lg border {{ $type===null?'bg-gray-100 font-medium':'' }}">Semua</a>
      <a href="{{ route('sekretariat.letters.index',['type'=>'incoming']) }}"
         class="px-3 py-2 rounded-lg border {{ $type==='incoming'?'bg-gray-100 font-medium':'' }}">Masuk</a>
      <a href="{{ route('sekretariat.letters.index',['type'=>'outgoing']) }}"
         class="px-3 py-2 rounded-lg border {{ $type==='outgoing'?'bg-gray-100 font-medium':'' }}">Keluar</a>

      {{-- Cetak PDF: bawa filter aktif (type) --}}
      <a href="{{ route('sekretariat.letters.index', array_filter(['type'=>$type ?: 'all','print'=>1])) }}"
         target="_blank"
         class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700 text-sm">
        Cetak (PDF)
      </a>

      <a href="{{ route('sekretariat.letters.create') }}"
         class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600 text-sm">
        + Tambah
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
      {{ session('success') }}
    </div>
  @endif

  @php
    $isEmpty = ($letters instanceof \Illuminate\Pagination\AbstractPaginator)
      ? $letters->count() === 0
      : (collect($letters)->count() === 0);
  @endphp

  @if($isEmpty)
    <div class="rounded-xl border bg-white p-6 text-gray-500">Belum ada data.</div>
  @else
    <div class="rounded-xl border bg-white overflow-hidden">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-50">
          <tr>
            <th class="px-4 py-2 text-left">Tanggal</th>
            <th class="px-4 py-2 text-left">Nomor</th>
            <th class="px-4 py-2 text-left">Perihal</th>
            <th class="px-4 py-2 text-left">Dari</th>
            <th class="px-4 py-2 text-left">Kepada</th>
            <th class="px-4 py-2 text-left">Tipe</th>
            <th class="px-4 py-2"></th>
          </tr>
        </thead>
        <tbody>
          @foreach(($letters instanceof \Illuminate\Pagination\AbstractPaginator ? $letters : collect($letters)) as $l)
            <tr class="border-t">
              <td class="px-4 py-2">{{ \Illuminate\Support\Carbon::parse($l->date)->translatedFormat('d M Y') }}</td>
              <td class="px-4 py-2">{{ $l->number ?? '-' }}</td>
              <td class="px-4 py-2">{{ $l->subject }}</td>
              <td class="px-4 py-2">{{ $l->from_name ?? '-' }}</td>
              <td class="px-4 py-2">{{ $l->to_name   ?? '-' }}</td>
              <td class="px-4 py-2">{{ $l->type==='incoming' ? 'Masuk' : 'Keluar' }}</td>
              <td class="px-4 py-2 text-right">
                <a href="{{ route('sekretariat.letters.edit',$l) }}"
                   class="px-3 py-1.5 rounded-lg border text-sm">Edit</a>
                <form method="POST" action="{{ route('sekretariat.letters.destroy',$l) }}"
                      class="inline" onsubmit="return confirm('Hapus surat?')">
                  @csrf @method('DELETE')
                  <button class="px-3 py-1.5 rounded-lg border text-sm text-red-600">Hapus</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($letters instanceof \Illuminate\Pagination\AbstractPaginator)
      <div class="mt-4">{{ $letters->links() }}</div>
    @endif
  @endif
</div>
{{-- /screen-only --}}

{{-- =======================  PRINT (PDF)  ======================= --}}
<div class="print-only">
  {{-- Header --}}
  <div style="margin-bottom:8px">
    <div style="font-size:16px;font-weight:700">Laporan Surat {{ $typeLabel }}</div>
    <div style="font-size:12px;color:#475569;line-height:1.6">
      <div><strong>Dicetak:</strong> {{ now()->format('d/m/Y H:i') }}</div>
      <div><strong>Tipe:</strong> {{ $typeLabel }}</div>
    </div>
    <hr style="margin:6px 0 10px;border:0;border-top:1px solid #e5e7eb">
  </div>

  {{-- Metrik ringkas --}}
  <div class="metric">
    <div class="metric-title">Jumlah Surat</div>
    <div class="metric-value">
      {{ ($letters instanceof \Illuminate\Support\Collection) ? $letters->count() : ($letters->count() ?? 0) }}
    </div>
  </div>

  {{-- Tabel Cetak --}}
  <table>
    <thead>
      <tr>
        <th style="text-align:left">Tanggal</th>
        <th style="text-align:left">Nomor</th>
        <th style="text-align:left">Perihal</th>
        <th style="text-align:left">Dari</th>
        <th style="text-align:left">Kepada</th>
        <th style="text-align:left">Tipe</th>
      </tr>
    </thead>
    <tbody>
      @forelse(($letters instanceof \Illuminate\Pagination\AbstractPaginator ? collect($letters->items()) : $letters) as $l)
        <tr>
          <td>{{ \Illuminate\Support\Carbon::parse($l->date)->translatedFormat('d M Y') }}</td>
          <td>{{ $l->number ?? '-' }}</td>
          <td>{{ $l->subject }}</td>
          <td>{{ $l->from_name ?? '-' }}</td>
          <td>{{ $l->to_name ?? '-' }}</td>
          <td>{{ $l->type==='incoming' ? 'Masuk' : 'Keluar' }}</td>
        </tr>
      @empty
        <tr><td colspan="6" style="text-align:center;color:#6b7280;padding:12px">Tidak ada data.</td></tr>
      @endforelse
    </tbody>
  </table>

  {{-- Tanda tangan --}}
  <div class="sig-grid">
    <div class="sig-box">
      <div>Mengetahui,</div>
      <div class="font-semibold">Ketua HIMATEKNO</div>
      <div class="sig-line">(....................................)</div>
    </div>
    <div class="sig-box" style="text-align:right">
      <div>Purworejo, {{ now()->translatedFormat('d F Y') }}</div>
      <div class="font-semibold">Sekretaris</div>
      <div class="sig-line">(....................................)</div>
    </div>
  </div>
</div>
@endsection
