@extends('admin.layout')

@section('content')
    <h3>Settings Admin</h3>

    <p>Di halaman ini admin bisa mengubah nomor WhatsApp yang dipakai untuk tombol “Chat WhatsApp” di halaman sukses order.</p>

    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf

        <label>Nomor WhatsApp Admin</label><br>
        <small>Gunakan format Indonesia: <b>62xxxxxxxxxxx</b> (tanpa +, tanpa spasi)</small><br><br>

        <input
            type="text"
            name="admin_phone"
            value="{{ old('admin_phone', $adminPhone ?? '') }}"
            placeholder="contoh: 6281234567890"
            style="width:320px;"
        >
        <br>

        @error('admin_phone')
            <small style="color:red">{{ $message }}</small>
        @enderror

        <br><br>
        <button type="submit">Simpan</button>
    </form>

    <hr>

    <h4>Nomor Saat Ini</h4>
    @if(!empty($adminPhone))
        <p><b>{{ $adminPhone }}</b></p>
    @else
        <p style="color:gray;">Belum diset.</p>
    @endif
@endsection
