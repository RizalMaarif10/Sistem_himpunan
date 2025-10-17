@php
  $layout       = auth()->user()?->hasRole('admin') ? 'admin.layouts.app' : 'bendahara.layouts.app';

  $scope        = $scope        ?? 'monthly';   // 'monthly' | 'yearly'
  $categories   = $categories   ?? collect();
  $category_id  = $category_id  ?? null;
  $q            = $q            ?? '';
  $perMonth     = $perMonth     ?? collect();

  // query string untuk mempertahankan filter saat pindah scope
  $qs = [
    'month' => $month ?? now()->month,
    'year'  => $year  ?? now()->year,
    'category_id' => $category_id,
    'q' => $q,
  ];

  $kategoriAktif = $category_id
      ? optional($categories->firstWhere('id',(int)$category_id))->name
      : 'Semua';
@endphp
@extends($layout)

@section('title','Laporan')

@section('content')
<section class="max-w-6xl mx-auto px-4">

  {{-- ===================== PRINT CSS ===================== --}}
  <style>
    .metric-value,.num{font-variant-numeric:tabular-nums;letter-spacing:.3px}
    @page{ size:A4 portrait; margin:14mm 12mm; }

    @media print{
      nav,header,footer,.screen-only{display:none!important}
      .print-only{display:block!important}
      html,body{background:#fff!important;-webkit-print-color-adjust:exact;print-color-adjust:exact}

      /* Kartu metrik ringkas */
      .metric-card{border:1px solid #e5e7eb;border-radius:8px;padding:10px;background:#fff}
      .metric-title{font-size:10px;letter-spacing:.3px;text-transform:uppercase;color:#64748b}
      .metric-value{font-size:18px;line-height:22px;font-weight:700;color:#0f172a}

      /* Grid 2 kolom pada cetak */
      .print-metrics{display:grid;grid-template-columns:1fr 1fr;gap:8px;margin:8px 0 12px}

      /* Tabel rapi + header mengulang */
      table{width:100%;border-collapse:collapse}
      thead{display:table-header-group}
      tfoot{display:table-row-group}
      tr{break-inside:avoid;page-break-inside:avoid}
      th,td{border:1px solid #dcdcdc;padding:6px 8px;font-size:12px}
      thead th{background:#f6f6f6}

      /* Anti putus */
      .avoid-break{break-inside:avoid;page-break-inside:avoid}

      /* Tanda tangan */
      .sig-grid{display:grid;grid-template-columns:1fr 1fr;gap:14mm;margin-top:12mm}
      .sig-box{border:1px dashed #cfd4dc;padding:10mm;min-height:48mm;display:flex;flex-direction:column;justify-content:space-between}
      .sig-line{margin-top:12mm;border-top:1px solid #222;text-align:center;padding-top:2mm}
      .sig-title{font-size:12px;color:#475569;margin-bottom:4px}
    }

    .print-only{display:none}
  </style>

  {{-- ===================== SCREEN (UI biasa) ===================== --}}
  <div class="screen-only">
    <header class="mb-4">
      <h1 class="text-3xl font-extrabold tracking-tight">Laporan</h1>
      <p class="text-sm text-gray-500">Rekap pemasukan & pengeluaran berdasarkan periode dan kategori.</p>
    </header>

    {{-- Filter bar --}}
    <div class="mb-8">
      <div class="rounded-2xl border bg-white p-4 md:p-5 shadow-sm">
        <div class="flex flex-wrap items-center justify-between gap-3 mb-3">
          <div class="inline-flex rounded-xl border overflow-hidden">
            <a href="{{ route('bendahara.reports.index', array_merge($qs,['scope'=>'monthly'])) }}"
               class="px-3 py-2 {{ $scope==='monthly' ? 'bg-slate-900 text-white' : 'bg-white hover:bg-gray-50' }}">
              Bulanan
            </a>
            <a href="{{ route('bendahara.reports.index', array_merge($qs,['scope'=>'yearly'])) }}"
               class="px-3 py-2 border-l {{ $scope==='yearly' ? 'bg-slate-900 text-white' : 'bg-white hover:bg-gray-50' }}">
              Rekap 12 Bulan
            </a>
          </div>

          <a href="{{ route('bendahara.reports.index', array_merge($qs,['scope'=>$scope,'print'=>1])) }}"
             target="_blank"
             class="px-4 py-2 rounded-lg bg-blue-600 text-white hover:bg-blue-700">
            Cetak (PDF)
          </a>
        </div>

        <form method="GET" class="grid md:grid-cols-12 gap-3 items-end">
          <input type="hidden" name="scope" value="{{ $scope }}">
          <div class="md:col-span-3 {{ $scope==='yearly' ? 'hidden' : '' }}">
            <label class="block text-xs font-medium text-gray-600 mb-1">Bulan</label>
            <select name="month" class="w-full border rounded-lg px-3 py-2">
              @for($m=1;$m<=12;$m++)
                <option value="{{ $m }}" {{ $m==$month?'selected':'' }}>
                  {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                </option>
              @endfor
            </select>
          </div>

          <div class="md:col-span-2">
            <label class="block text-xs font-medium text-gray-600 mb-1">Tahun</label>
            <input type="number" name="year" value="{{ $year }}" class="w-full border rounded-lg px-3 py-2">
          </div>

          <div class="md:col-span-3">
            <label class="block text-xs font-medium text-gray-600 mb-1">Kategori</label>
            <select name="category_id" class="w-full border rounded-lg px-3 py-2">
              <option value="">Semua</option>
              @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ (string)$category_id===(string)$c->id?'selected':'' }}>{{ $c->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="md:col-span-3 {{ $scope==='yearly' ? 'hidden' : '' }}">
            <label class="block text-xs font-medium text-gray-600 mb-1">Cari (deskripsi / kategori / rekening)</label>
            <input type="text" name="q" value="{{ $q }}" placeholder="kata kunci…" class="w-full border rounded-lg px-3 py-2">
          </div>

          <div class="md:col-span-1">
            <button class="px-4 py-2 rounded-lg border w-full bg-white hover:bg-gray-50">Terapkan</button>
          </div>
        </form>
      </div>
    </div>

    {{-- ===== SCREEN: BULANAN ===== --}}
    @if($scope==='monthly')
      @isset($saldo_awal_bulan)
        <div class="grid md:grid-cols-4 gap-4 mb-6">
          <div class="rounded-2xl border bg-white p-5 shadow-sm">
            <div class="text-[11px] uppercase tracking-wide text-gray-500">Saldo Awal Bulan</div>
            <div class="mt-1 text-2xl font-bold metric-value">Rp {{ number_format($saldo_awal_bulan,0,',','.') }}</div>
          </div>
          <div class="rounded-2xl border bg-white p-5 shadow-sm">
            <div class="text-[11px] uppercase tracking-wide text-gray-500">Total Pemasukan</div>
            <div class="mt-1 text-2xl font-bold metric-value">Rp {{ number_format($income,0,',','.') }}</div>
          </div>
          <div class="rounded-2xl border bg-white p-5 shadow-sm">
            <div class="text-[11px] uppercase tracking-wide text-gray-500">Total Pengeluaran</div>
            <div class="mt-1 text-2xl font-bold metric-value">Rp {{ number_format($expense,0,',','.') }}</div>
          </div>
          <div class="rounded-2xl border bg-white p-5 shadow-sm">
            <div class="text-[11px] uppercase tracking-wide text-gray-500">Saldo Akhir Bulan</div>
            <div class="mt-1 text-2xl font-extrabold metric-value">
              Rp {{ number_format(($saldo_awal_bulan ?? 0) + $income - $expense,0,',','.') }}
            </div>
          </div>
        </div>
      @endisset

      @php
        $screenList   = ($txList ?? collect());
        $screenInc    = (int) $screenList->where('type','income')->sum('amount');
        $screenExp    = (int) $screenList->where('type','expense')->sum('amount');
        $screenNetto  = $screenInc - $screenExp;
      @endphp

      <div class="rounded-2xl border bg-white overflow-hidden shadow-sm">
        <div class="px-4 pt-4 pb-2 text-sm text-gray-600">
          Rincian transaksi bulan ini
          <span class="text-xs text-gray-500"> (total di bawah dihitung dari daftar ini)</span>
        </div>
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left">Tanggal</th>
              <th class="px-4 py-2 text-left">Kategori</th>
              <th class="px-4 py-2 text-left">Rekening</th>
              <th class="px-4 py-2 text-left">Keterangan</th>
              <th class="px-4 py-2 text-right">Pemasukan</th>
              <th class="px-4 py-2 text-right">Pengeluaran</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($screenList as $t)
              <tr class="hover:bg-gray-50/60">
                <td class="px-4 py-2">{{ \Carbon\Carbon::parse($t->date)->translatedFormat('d M Y') }}</td>
                <td class="px-4 py-2">{{ $t->category->name ?? '-' }}</td>
                <td class="px-4 py-2">{{ $t->account->name ?? '-' }}</td>
                <td class="px-4 py-2">
                  <div class="text-gray-700">{{ $t->description ?: '-' }}</div>
                  @if($t->ref)<div class="text-xs text-gray-500">Ref: {{ $t->ref }}</div>@endif
                </td>
                <td class="px-4 py-2 text-right">
                  {{ $t->type==='income' ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}
                </td>
                <td class="px-4 py-2 text-right">
                  {{ $t->type==='expense' ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}
                </td>
              </tr>
            @empty
              <tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">Tidak ada transaksi.</td></tr>
            @endforelse
          </tbody>
          @if($screenList->count())
            <tfoot class="bg-gray-50 font-semibold">
              <tr>
                <td class="px-4 py-2 text-left" colspan="4">Total</td>
                <td class="px-4 py-2 text-right num">Rp {{ number_format($screenInc,0,',','.') }}</td>
                <td class="px-4 py-2 text-right num">Rp {{ number_format($screenExp,0,',','.') }}</td>
              </tr>
              <tr>
                <td class="px-4 py-2 text-left" colspan="4">Netto Bulan Ini</td>
                <td class="px-4 py-2 text-right num" colspan="2">Rp {{ number_format($screenNetto,0,',','.') }}</td>
              </tr>
            </tfoot>
          @endif
        </table>
      </div>

    {{-- ===== SCREEN: TAHUNAN ===== --}}
    @elseif($scope==='yearly')
      @php $totI=0; $totE=0; @endphp
      <div class="rounded-2xl border bg-white overflow-hidden shadow-sm">
        <table class="min-w-full text-sm">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-4 py-2 text-left">Bulan</th>
              <th class="px-4 py-2 text-right">Pemasukan</th>
              <th class="px-4 py-2 text-right">Pengeluaran</th>
              <th class="px-4 py-2 text-right">Saldo</th>
              <th class="px-4 py-2 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @for($m=1;$m<=12;$m++)
              @php
                $row = $perMonth->firstWhere('m',$m);
                $inc = (int)($row->income  ?? 0);
                $exp = (int)($row->expense ?? 0);
                $sal = $inc - $exp;
                $totI += $inc; $totE += $exp;
              @endphp
              <tr class="hover:bg-gray-50/60">
                <td class="px-4 py-2">{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</td>
                <td class="px-4 py-2 text-right num">Rp {{ number_format($inc,0,',','.') }}</td>
                <td class="px-4 py-2 text-right num">Rp {{ number_format($exp,0,',','.') }}</td>
                <td class="px-4 py-2 text-right font-medium num">Rp {{ number_format($sal,0,',','.') }}</td>
                <td class="px-4 py-2 text-right">
                  <a class="px-3 py-1.5 rounded-lg border hover:bg-gray-50"
                     href="{{ route('bendahara.reports.index', array_merge($qs, ['scope'=>'monthly','month'=>$m])) }}">
                    Lihat
                  </a>
                </td>
              </tr>
            @endfor
          </tbody>
          <tfoot class="bg-gray-50 font-semibold">
            <tr>
              <td class="px-4 py-2 text-left">Total Tahun</td>
              <td class="px-4 py-2 text-right num">Rp {{ number_format($totI,0,',','.') }}</td>
              <td class="px-4 py-2 text-right num">Rp {{ number_format($totE,0,',','.') }}</td>
              <td class="px-4 py-2 text-right num">Rp {{ number_format($totI-$totE,0,',','.') }}</td>
              <td></td>
            </tr>
          </tfoot>
        </table>
      </div>
    @endif
  </div> {{-- /screen-only --}}

  {{-- ===================== PRINT-ONLY (PDF) ===================== --}}
  <div class="print-only">
    {{-- Header cetak --}}
    <div class="avoid-break">
      <div style="font-size:16px;font-weight:700;margin-bottom:2px">Laporan {{ $scope==='yearly' ? 'Rekap 12 Bulan' : 'Bulanan' }} Bendahara</div>
      <div style="font-size:12px;line-height:1.6;color:#475569">
        @if($scope==='yearly')
          <div><strong>Tahun:</strong> {{ $year }}</div>
        @else
          <div><strong>Periode:</strong> {{ \Carbon\Carbon::create()->month($month)->translatedFormat('F') }} {{ $year }}</div>
        @endif
        <div><strong>Kategori:</strong> {{ $kategoriAktif }}</div>
        @if($q)<div><strong>Kata kunci:</strong> “{{ $q }}”</div>@endif
        <div><strong>Dicetak:</strong> {{ now()->format('d/m/Y H:i') }}</div>
      </div>
      <hr style="margin:6px 0 10px;border:0;border-top:1px solid #e5e7eb">
    </div>

    @if($scope==='monthly')
      {{-- Metrik cetak --}}
      <div class="print-metrics">
        @isset($saldo_awal_bulan)
          <div class="metric-card">
            <div class="metric-title">Saldo Awal Bulan</div>
            <div class="metric-value">Rp {{ number_format($saldo_awal_bulan,0,',','.') }}</div>
          </div>
        @endisset
        <div class="metric-card">
          <div class="metric-title">Total Pemasukan</div>
          <div class="metric-value">Rp {{ number_format($income,0,',','.') }}</div>
        </div>
        <div class="metric-card">
          <div class="metric-title">Total Pengeluaran</div>
          <div class="metric-value">Rp {{ number_format($expense,0,',','.') }}</div>
        </div>
        <div class="metric-card">
          <div class="metric-title">Saldo Akhir Bulan</div>
          <div class="metric-value">Rp {{ number_format(($saldo_awal_bulan ?? 0) + $income - $expense,0,',','.') }}</div>
        </div>
      </div>

      {{-- Tabel cetak --}}
      @php
        $list       = ($txList ?? collect());
        $totIncome  = (int) $list->where('type','income')->sum('amount');
        $totExpense = (int) $list->where('type','expense')->sum('amount');
        $totNetto   = $totIncome - $totExpense;
      @endphp
      <div class="avoid-break">
        <table>
          <thead>
            <tr>
              <th style="text-align:left">Tanggal</th>
              <th style="text-align:left">Kategori</th>
              <th style="text-align:left">Rekening</th>
              <th style="text-align:left">Keterangan</th>
              <th style="text-align:right">Pemasukan</th>
              <th style="text-align:right">Pengeluaran</th>
            </tr>
          </thead>
          <tbody>
            @forelse($list as $t)
              <tr>
                <td>{{ \Carbon\Carbon::parse($t->date)->translatedFormat('d M Y') }}</td>
                <td>{{ $t->category->name ?? '-' }}</td>
                <td>{{ $t->account->name ?? '-' }}</td>
                <td>
                  <div>{{ $t->description ?: '-' }}</div>
                  @if($t->ref)<div style="color:#6b7280;font-size:11px">Ref: {{ $t->ref }}</div>@endif
                </td>
                <td style="text-align:right">{{ $t->type==='income'  ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}</td>
                <td style="text-align:right">{{ $t->type==='expense' ? 'Rp '.number_format($t->amount,0,',','.') : '-' }}</td>
              </tr>
            @empty
              <tr><td colspan="6" style="text-align:center;color:#6b7280;padding:12px">Tidak ada transaksi.</td></tr>
            @endforelse
          </tbody>
          @if($list->count())
            <tfoot>
              <tr style="font-weight:600;background:#f7f7f7">
                <td colspan="4" style="text-align:left">Total</td>
                <td style="text-align:right">Rp {{ number_format($totIncome,0,',','.') }}</td>
                <td style="text-align:right">Rp {{ number_format($totExpense,0,',','.') }}</td>
              </tr>
              <tr style="font-weight:600;background:#f7f7f7">
                <td colspan="4" style="text-align:left">Netto Bulan Ini</td>
                <td colspan="2" style="text-align:right">Rp {{ number_format($totNetto,0,',','.') }}</td>
              </tr>
            </tfoot>
          @endif
        </table>
      </div>

      {{-- Catatan --}}
      <div class="avoid-break" style="margin-top:10px;font-size:12px;line-height:1.6;color:#475569">
        <strong>Catatan:</strong>
        <ul style="margin:6px 0 0 16px;padding:0">
          <li>Saldo akhir = saldo awal + total pemasukan − total pengeluaran.</li>
          <li>Filter aktif: Kategori = {{ $kategoriAktif }}@if($q); Kata kunci = “{{ $q }}”@endif.</li>
        </ul>
      </div>

    @else
      {{-- CETAK: REKAP 12 BULAN --}}
      @php $totI=0; $totE=0; @endphp
      <div class="avoid-break">
        <table>
          <thead>
            <tr>
              <th style="text-align:left">Bulan</th>
              <th style="text-align:right">Pemasukan</th>
              <th style="text-align:right">Pengeluaran</th>
              <th style="text-align:right">Saldo</th>
            </tr>
          </thead>
          <tbody>
            @for($m=1;$m<=12;$m++)
              @php
                $row = $perMonth->firstWhere('m',$m);
                $inc = (int)($row->income  ?? 0);
                $exp = (int)($row->expense ?? 0);
                $sal = $inc - $exp; $totI += $inc; $totE += $exp;
              @endphp
              <tr>
                <td>{{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}</td>
                <td style="text-align:right">Rp {{ number_format($inc,0,',','.') }}</td>
                <td style="text-align:right">Rp {{ number_format($exp,0,',','.') }}</td>
                <td style="text-align:right;font-weight:600">Rp {{ number_format($sal,0,',','.') }}</td>
              </tr>
            @endfor
          </tbody>
          <tfoot>
            <tr style="font-weight:700;background:#f7f7f7">
              <td style="text-align:left">Total Tahun</td>
              <td style="text-align:right">Rp {{ number_format($totI,0,',','.') }}</td>
              <td style="text-align:right">Rp {{ number_format($totE,0,',','.') }}</td>
              <td style="text-align:right">Rp {{ number_format($totI-$totE,0,',','.') }}</td>
            </tr>
          </tfoot>
        </table>
      </div>
    @endif

    {{-- Tanda Tangan --}}
    <div class="sig-grid">
      <div class="sig-box">
        <div class="sig-title">Mengetahui,</div>
        <div class="font-semibold">Ketua HIMATEKNO</div>
        <div class="sig-line">(....................................)</div>
      </div>
      <div class="sig-box" style="text-align:right">
        <div>Purworejo, {{ now()->translatedFormat('d F Y') }}</div>
        <div class="font-semibold">Bendahara</div>
        <div class="sig-line">(....................................)</div>
      </div>
    </div>
  </div>{{-- /print-only --}}

  @if(request('print')) <script>addEventListener('load',()=>print());</script> @endif
</section>
@endsection
