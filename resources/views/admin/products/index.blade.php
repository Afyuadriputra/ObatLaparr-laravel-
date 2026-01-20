@extends('admin.layout')

@section('content')
<h3>Data Produk</h3>

<a href="{{ route('admin.products.create') }}">+ Tambah Produk</a>

<form method="GET" action="{{ route('admin.products.index') }}" style="margin-top:10px; margin-bottom:10px;">
    <input type="text" name="q" value="{{ $q ?? '' }}" placeholder="Cari nama produk...">
    <select name="category_id">
        <option value="">-- Semua Kategori --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" @selected(($categoryId ?? '') == $cat->id)>{{ $cat->name }}</option>
        @endforeach
    </select>
    <button type="submit">Filter</button>
    <a href="{{ route('admin.products.index') }}">Reset</a>
</form>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Kategori</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Status</th>
        <th>Foto</th>
        <th>Aksi</th>
    </tr>

    @forelse($products as $product)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $product->name }}</td>
            <td>{{ $product->category->name ?? '-' }}</td>
            <td>Rp{{ number_format($product->price) }}</td>
            <td>{{ $product->stock }}</td>
            <td>{{ $product->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            <td>
                @if($product->photo_path)
                    <img src="{{ asset('storage/'.$product->photo_path) }}" width="60">
                @else
                    -
                @endif
            </td>
            <td>
                <a href="{{ route('admin.products.edit', $product) }}">Edit</a>
                |
                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" style="display:inline">
                    @csrf
                    @method('DELETE')
                    <button onclick="return confirm('Hapus produk?')">Hapus</button>
                </form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">Belum ada produk.</td>
        </tr>
    @endforelse
</table>

<div style="margin-top:10px;">
    {{ $products->links() }}
</div>
@endsection
