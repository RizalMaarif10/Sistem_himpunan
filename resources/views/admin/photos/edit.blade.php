@extends('admin.layouts.app')
@section('title','Edit Foto')

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
  <h1 class="text-2xl md:text-3xl font-bold">Edit Foto</h1>
  <a href="{{ route('admin.photos.index') }}" class="btn btn-outline">Kembali</a>
</div>

<form method="POST" action="{{ route('admin.photos.update', $photo) }}" enctype="multipart/form-data" class="card p-6">
  @method('PUT')
  @include('admin.photos._form', ['photo' => $photo])
</form>
@endsection
