@php
  $layout = auth()->user()?->hasRole('admin') ? 'admin.layouts.app' : 'sekretariat.layouts.app';
@endphp
@extends($layout)
@section('title','Tambah Notulen')
@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Tambah Notulen</h1>
<form method="POST" action="{{ route('sekretariat.minutes.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl border p-6">
  @include('sekretariat.minutes._form', ['minute'=>$minute])
</form>
@endsection
