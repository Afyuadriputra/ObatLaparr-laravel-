@extends('admin.layout')

@section('content')
<h3>Data Pesanan</h3>

<form method="GET" action="{{ route('admin.orders.index') }}" style="margin-bottom:10px;">
    <label>Filter Status:</label>
    <select name="status">
        <option value="">-- Semua --</option>
        <option value="MENUNGGU_KONFIRMASI" @selected(($status ?? '') === 'MENUNGGU_KONFIRMASI')>Menunggu Konfirmasi</option>
        <option value="DIPROSES" @selected(($status ?? '') === 'DIPROSES')>Diproses</option>
        <option value="DIKIRIM" @selected(($status ?? '') === 'DIKIRIM')>Dikirim</option>
        <option value="SIAP_DIAMBIL" @selected(($status ?? '') === 'SIAP_DIAMBIL')>Siap Diambil</option>
        <option value="SELESAI" @selected(($status ?? '') === 'SELESAI')>Selesai</option>
        <option value="DIBATALKAN" @selected(($status ?? '') === 'DIBATALKAN')>Dibatalkan</option>
    </select>
    <button type="submit">Terapkan</button>
    <a href="{{ route('admin.orders.index') }}">Reset</a>
</form>

<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>No</th>
        <th>Kode</th>
        <th>Nama</th>
        <th>WA</th>
        <th>Tipe</th>
        <th>Total</th>
        <th>Status</th>
        <th>Aksi</th>
    </tr>

    @forelse($orders as $order)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $order->code }}</td>
            <td>{{ $order->customer_name }}</td>
            <td>{{ $order->phone }}</td>
            <td>{{ $order->fulfillment_type }}</td>
            <td>Rp{{ number_format($order->subtotal) }}</td>
            <td>{{ $order->status }}</td>
            <td>
                <a href="{{ route('admin.orders.show', $order) }}">Detail</a>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="8">Belum ada pesanan.</td>
        </tr>
    @endforelse
</table>

<div style="margin-top:10px;">
    {{ $orders->links() }}
</div>
@endsection
