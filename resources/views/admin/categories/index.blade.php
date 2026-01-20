@extends('admin.layout')

@section('content')
<h3>Data Kategori</h3>

<a href="{{ route('admin.categories.create') }}">+ Tambah Kategori</a>

<table border="1" cellpadding="5" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Nama</th>
        <th>Slug</th>
        <th>Aksi</th>
    </tr>
    @foreach($categories as $category)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $category->name }}</td>
        <td>{{ $category->slug }}</td>
        <td>
            <a href="{{ route('admin.categories.edit', $category) }}">Edit</a>
            |
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" style="display:inline">
                @csrf
                @method('DELETE')
                <button onclick="return confirm('Hapus kategori?')">Hapus</button>
            </form>
        </td>
    </tr>
    @endforeach
</table>

{{ $categories->links() }}
@endsection
