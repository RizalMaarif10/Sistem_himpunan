@extends('sekretariat.layouts.app')
@section('title','Tambah Surat')
@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Tambah Surat</h1>
<form method="POST" action="{{ route('sekretariat.letters.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl border p-6">
  @include('sekretariat.letters._form', ['letter'=>$letter])
</form>
@endsection
