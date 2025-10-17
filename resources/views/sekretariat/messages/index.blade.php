@extends('sekretariat.layouts.app')
@section('title','Pesan Kontak')
@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Pesan Kontak</h1>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>
@endif

@if($items->isEmpty())
  <div class="rounded-xl border bg-white p-6 text-gray-500">Belum ada pesan.</div>
@else
  <div class="rounded-xl border bg-white overflow-hidden">
    <table class="min-w-full text-sm">
      <thead class="bg-gray-50"><tr>
        <th class="px-4 py-2 text-left">Tanggal</th>
        <th class="px-4 py-2 text-left">Nama</th>
        <th class="px-4 py-2 text-left">Email</th>
        <th class="px-4 py-2 text-left">Subjek</th>
        <th class="px-4 py-2"></th>
      </tr></thead>
      <tbody>
        @foreach($items as $m)
          <tr class="border-t">
            <td class="px-4 py-2">{{ optional($m->created_at)->translatedFormat('d M Y H:i') }}</td>
            <td class="px-4 py-2">{{ $m->name ?? '-' }}</td>
            <td class="px-4 py-2">{{ $m->email ?? '-' }}</td>
            <td class="px-4 py-2">{{ $m->subject ?? '-' }}</td>
            <td class="px-4 py-2 text-right">
              <a href="{{ route('sekretariat.messages.show',$m) }}" class="px-3 py-1.5 rounded-lg border text-sm">Baca</a>
              <form method="POST" action="{{ route('sekretariat.messages.destroy',$m) }}" class="inline" onsubmit="return confirm('Hapus pesan?')">
                @csrf @method('DELETE')
                <button class="px-3 py-1.5 rounded-lg border text-sm text-red-600">Hapus</button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
  <div class="mt-4">{{ $items->links() }}</div>
@endif
@endsection
