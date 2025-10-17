@extends('sekretariat.layouts.app')
@section('title','Detail Pesan')
@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Detail Pesan</h1>

@if(session('success'))<div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>@endif

<div class="rounded-xl border bg-white p-6">
  <div class="text-sm text-gray-500">Dari</div>
  <div class="font-medium">{{ $message->name }} — {{ $message->email }}</div>
  <div class="mt-3 text-sm text-gray-500">Subjek</div>
  <div class="font-medium">{{ $message->subject ?? '-' }}</div>
  <div class="mt-3 text-sm text-gray-500">Waktu</div>
  <div class="font-medium">{{ optional($message->created_at)->translatedFormat('d M Y, H:i') }}</div>
  <div class="mt-3 text-sm text-gray-500">Isi Pesan</div>
  <div class="mt-1 whitespace-pre-line">{{ $message->message ?? '-' }}</div>

  <div class="mt-6 flex items-center gap-3">
    @if(is_null($message->read_at))
      <form method="POST" action="{{ route('sekretariat.messages.read',$message) }}">@csrf @method('PATCH')
        <button class="px-4 py-2 rounded-lg bg-slate-900 text-white hover:bg-blue-600 text-sm">Tandai Dibaca</button>
      </form>
    @endif
    <a href="{{ route('sekretariat.messages.index') }}" class="px-4 py-2 rounded-lg border text-sm">Kembali</a>
  </div>
</div>
@endsection
