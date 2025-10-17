@php
  $layout = auth()->user()?->hasRole('admin') ? 'admin.layouts.app' : 'sekretariat.layouts.app';
@endphp
@extends($layout)
@section('title','Notulen Rapat')
@section('content')
<div class="mb-6 flex items-center justify-between">
  <h1 class="text-2xl md:text-3xl font-bold">Notulen Rapat</h1>
  <a href="{{ route('sekretariat.minutes.create') }}" class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600 text-sm">+ Tambah</a>
</div>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>
@endif

@if($minutes->isEmpty())
  <div class="rounded-xl border bg-white p-6 text-gray-500">Belum ada data.</div>
@else
  <div class="rounded-xl border bg-white overflow-hidden">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50"><tr>
        <th class="px-4 py-2 text-left">Tanggal</th>
        <th class="px-4 py-2 text-left">Judul</th>
        <th class="px-4 py-2 text-left">Berkas</th>
        <th class="px-4 py-2"></th>
      </tr></thead>
      <tbody>
        @foreach($minutes as $m)
          <tr class="border-t">
            <td class="px-4 py-2">{{ optional($m->meeting_date)->translatedFormat('d M Y') }}</td>
            <td class="px-4 py-2">{{ $m->title }}</td>
            <td class="px-4 py-2">
              @if($m->file_path)
                <a target="_blank" class="text-blue-600 underline" href="{{ asset('storage/'.$m->file_path) }}">Lihat</a>
              @else — @endif
            </td>
            <td class="px-4 py-2 text-right">
              <a href="{{ route('sekretariat.minutes.edit',$m) }}" class="px-3 py-1.5 rounded-lg border text-sm">Edit</a>
              <form method="POST" action="{{ route('sekretariat.minutes.destroy',$m) }}" class="inline" onsubmit="return confirm('Hapus notulen?')">
                @csrf @method('DELETE')
                <button class="px-3 py-1.5 rounded-lg border text-sm text-red-600">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $minutes->links() }}</div>
@endif
@endsection
