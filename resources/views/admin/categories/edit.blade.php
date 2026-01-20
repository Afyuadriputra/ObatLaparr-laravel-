@extends('admin.layout')

@section('content')
<h3>Edit Kategori</h3>

<form method="POST" action="{{ route('admin.categories.update', $category) }}">
    @csrf
    @method('PUT')

    <label>Nama Kategori</label><br>
    <input type="text" name="name" value="{{ old('name', $category->name) }}"><br>
    @error('name') <small style="color:red">{{ $message }}</small> @enderror

    <br><br>
    <button type="submit">Update</button>
</form>
@endsection
