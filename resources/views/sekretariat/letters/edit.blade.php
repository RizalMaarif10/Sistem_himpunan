@extends('sekretariat.layouts.app')
@section('title','Edit Surat')
@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Edit Surat</h1>
@if(session('success'))<div class="mb-4 rounded-lg border border-green-200 bg-green-50 text-green-700 px-4 py-3">{{ session('success') }}</div>@endif
<form method="POST" action="{{ route('sekretariat.letters.update',$letter) }}" enctype="multipart/form-data" class="bg-white rounded-xl border p-6">
  @method('PUT')
  @include('sekretariat.letters._form', ['letter'=>$letter])
</form>
@endsection
