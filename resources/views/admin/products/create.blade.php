@extends('admin.layout')

@section('content')
<h3>Tambah Produk</h3>

<form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data">
    @csrf

    <label>Kategori</label><br>
    <select name="category_id">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select><br><br>

    <label>Nama</label><br>
    <input type="text" name="name"><br><br>

    <label>Harga</label><br>
    <input type="number" name="price"><br><br>

    <label>Stok</label><br>
    <input type="number" name="stock"><br><br>

    <label>Status</label><br>
    <select name="is_active">
        <option value="1">Aktif</option>
        <option value="0">Nonaktif</option>
    </select><br><br>

    <label>Foto</label><br>
    <input type="file" name="photo"><br><br>

    <button type="submit">Simpan</button>
</form>
@endsection
