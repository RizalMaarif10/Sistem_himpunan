@extends('admin.layouts.app')
@section('title','Tambah Agenda')

@section('content')
<h1 class="text-2xl md:text-3xl font-bold mb-6">Tambah Agenda</h1>

<form method="POST" action="{{ route('admin.events.store') }}" enctype="multipart/form-data" class="bg-white rounded-xl border p-6">
  @include('admin.events._form', ['event' => $event])
</form>
@endsection
