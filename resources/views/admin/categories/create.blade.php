@extends('admin.layout')

@section('content')
<h3>Tambah Kategori</h3>

<form method="POST" action="{{ route('admin.categories.store') }}">
    @csrf

    <label>Nama Kategori</label><br>
    <input type="text" name="name" value="{{ old('name') }}"><br>
    @error('name') <small style="color:red">{{ $message }}</small> @enderror

    <br><br>
    <button type="submit">Simpan</button>
</form>
@endsection
