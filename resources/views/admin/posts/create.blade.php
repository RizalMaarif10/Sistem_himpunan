@extends('admin.layouts.app')
@section('title','Buat Berita')

@section('content')
<div class="mb-6 flex items-center justify-between gap-3">
  <h1 class="text-2xl md:text-3xl font-bold">Buat Berita</h1>
  <a href="{{ route('admin.posts.index') }}" class="btn btn-outline">Kembali</a>
</div>

<form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="card p-6">
  @include('admin.posts._form', ['post' => $post])
</form>
@endsection
