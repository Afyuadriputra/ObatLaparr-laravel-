@extends('admin.layout')

@section('content')
<h3>Detail Pesanan</h3>

<p><strong>Kode:</strong> {{ $order->code }}</p>
<p><strong>Nama:</strong> {{ $order->customer_name }}</p>
<p><strong>WA:</strong> {{ $order->phone }}</p>
<p><strong>Tipe:</strong> {{ $order->fulfillment_type }}</p>
@if($order->fulfillment_type === 'delivery')
    <p><strong>Alamat:</strong> {{ $order->address }}</p>
@endif
@if($order->note)
    <p><strong>Catatan:</strong> {{ $order->note }}</p>
@endif

<hr>

<h4>Item</h4>
<table border="1" cellpadding="6" cellspacing="0">
    <tr>
        <th>Produk</th>
        <th>Qty</th>
        <th>Harga</th>
        <th>Total</th>
        <th>Catatan Item</th>
    </tr>
    @foreach($order->items as $it)
        <tr>
            <td>{{ $it->product->name ?? '-' }}</td>
            <td>{{ $it->qty }}</td>
            <td>Rp{{ number_format($it->price) }}</td>
            <td>Rp{{ number_format($it->line_total) }}</td>
            <td>{{ $it->note_item ?? '-' }}</td>
        </tr>
    @endforeach
</table>

<p style="margin-top:10px;"><strong>Subtotal:</strong> Rp{{ number_format($order->subtotal) }}</p>

<hr>

<h4>Update Status</h4>
<form method="POST" action="{{ route('admin.orders.update-status', $order) }}">
    @csrf
    @method('PATCH')

    <select name="status">
        <option value="MENUNGGU_KONFIRMASI" @selected($order->status === 'MENUNGGU_KONFIRMASI')>MENUNGGU_KONFIRMASI</option>
        <option value="DIPROSES" @selected($order->status === 'DIPROSES')>DIPROSES</option>
        <option value="DIKIRIM" @selected($order->status === 'DIKIRIM')>DIKIRIM</option>
        <option value="SIAP_DIAMBIL" @selected($order->status === 'SIAP_DIAMBIL')>SIAP_DIAMBIL</option>
        <option value="SELESAI" @selected($order->status === 'SELESAI')>SELESAI</option>
        <option value="DIBATALKAN" @selected($order->status === 'DIBATALKAN')>DIBATALKAN</option>
    </select>

    <button type="submit">Simpan Status</button>
</form>

<hr>

<a href="{{ route('admin.orders.edit', $order) }}">Edit Data Pesanan</a>

<form method="POST" action="{{ route('admin.orders.destroy', $order) }}" style="display:inline">
    @csrf
    @method('DELETE')
    <button onclick="return confirm('Hapus pesanan ini?')">Hapus</button>
</form>

<br><br>
<a href="{{ route('admin.orders.index') }}">← Kembali</a>
@endsection
