@extends('admin.layouts.app')
@section('title','Kelola Agenda')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
  <h1 class="text-2xl md:text-3xl font-bold tracking-tight">Kelola Agenda</h1>
  <a href="{{ route('admin.events.create') }}" class="btn btn-primary">
    <svg xmlns="http://www.w3.org/2000/svg" class="size-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Agenda Baru
  </a>
</div>

@if(session('success'))
  <div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">
    {{ session('success') }}
  </div>
@endif

@if($events->isEmpty())
  <div class="card p-8 text-center text-gray-500">
    Belum ada data.
  </div>
@else
  {{-- WRAPPER lebih lebar + 4 kolom di ≥lg --}}
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5 items-stretch">

      @foreach($events as $e)
        @php
          $status = $e->status ?? 'draft';
          $statusClass = match($status){
            'published' => 'badge badge-green',
            'finished'  => 'badge badge-blue',
            'archived'  => 'badge badge-amber',
            default     => 'badge badge-gray',
          };
          $statusLabel = [
            'draft' => 'Draft', 'published' => 'Published',
            'finished' => 'Selesai', 'archived' => 'Diarsipkan'
          ][$status] ?? ucfirst($status);
        @endphp

        {{-- CARD full width, tinggi konsisten --}}
        <article class="card p-0 w-full overflow-hidden border hover:shadow-md transition group h-full flex flex-col">

          {{-- COVER: stabil & halus saat hover --}}
          <div class="relative aspect-[4/5] bg-gray-100">
            @if($e->cover_image)
              <img src="{{ asset('storage/'.$e->cover_image) }}"
                   alt="{{ $e->title }}"
                   class="absolute inset-0 w-full h-full object-cover object-center transition-transform duration-300 group-hover:scale-[1.02]"
                   loading="lazy">
            @else
              <div class="absolute inset-0 grid place-items-center text-xs text-gray-400">Tanpa Cover</div>
            @endif
          </div>

          {{-- BODY --}}
          <div class="p-4 flex flex-col flex-1">
            <div class="mb-2 flex flex-wrap items-center gap-2 text-[11px]">
              @if(!empty($e->type))
                <span class="px-2 py-0.5 rounded-full bg-gray-100 text-gray-600 font-medium">{{ strtoupper($e->type) }}</span>
              @endif
              <span class="{{ $statusClass }}">{{ $statusLabel }}</span>
            </div>

            <h3 class="font-semibold leading-snug text-[15px] text-ink line-clamp-2 group-hover:text-accent transition-colors">
              {{ $e->title }}
            </h3>

            <div class="mt-1 text-xs text-gray-500">
              {{ optional($e->start_at)->translatedFormat('d F Y, H:i') }}
              @if($e->location) • {{ $e->location }} @endif
            </div>

            {{-- ACTIONS: nempel di bawah --}}
            <div class="mt-auto pt-4 flex items-center gap-2">
              <a href="{{ route('admin.events.edit', $e) }}" class="btn btn-outline btn-sm">Edit</a>
              <form method="POST" action="{{ route('admin.events.destroy', $e) }}"
                    onsubmit="return confirm('Hapus agenda ini?')">
                @csrf @method('DELETE')
                <button class="btn btn-outline btn-sm !text-red-600">Hapus</button>
              </form>
            </div>
          </div>
        </article>
      @endforeach

    </div>
  </div>

  <div class="mt-6">
    {{ $events->links() }}
  </div>
@endif
@endsection
