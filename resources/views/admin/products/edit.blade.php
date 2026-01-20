@extends('admin.layout')

@section('content')
<h3>Edit Produk</h3>

<form method="POST" action="{{ route('admin.products.update', $product) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <label>Kategori</label><br>
    <select name="category_id">
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected($cat->id == $product->category_id)>
                {{ $cat->name }}
            </option>
        @endforeach
    </select><br><br>

    <label>Nama</label><br>
    <input type="text" name="name" value="{{ $product->name }}"><br><br>

    <label>Harga</label><br>
    <input type="number" name="price" value="{{ $product->price }}"><br><br>

    <label>Stok</label><br>
    <input type="number" name="stock" value="{{ $product->stock }}"><br><br>

    <label>Status</label><br>
    <select name="is_active">
        <option value="1" @selected($product->is_active)>Aktif</option>
        <option value="0" @selected(!$product->is_active)>Nonaktif</option>
    </select><br><br>

    <label>Foto Baru (opsional)</label><br>
    <input type="file" name="photo"><br><br>

    <button type="submit">Update</button>
</form>
@endsection
