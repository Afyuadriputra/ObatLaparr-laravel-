@extends('admin.layout')

@section('content')
<h3>Edit Pesanan: {{ $order->code }}</h3>

<form method="POST" action="{{ route('admin.orders.update', $order) }}">
    @csrf
    @method('PUT')

    <label>Nama</label><br>
    <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name) }}"><br>
    @error('customer_name') <small style="color:red">{{ $message }}</small> @enderror
    <br><br>

    <label>WA</label><br>
    <input type="text" name="phone" value="{{ old('phone', $order->phone) }}"><br>
    @error('phone') <small style="color:red">{{ $message }}</small> @enderror
    <br><br>

    <label>Tipe</label><br>
    <select name="fulfillment_type">
        <option value="delivery" @selected(old('fulfillment_type', $order->fulfillment_type) === 'delivery')>delivery</option>
        <option value="pickup" @selected(old('fulfillment_type', $order->fulfillment_type) === 'pickup')>pickup</option>
    </select>
    <br><br>

    <label>Alamat (wajib jika delivery)</label><br>
    <textarea name="address" rows="3">{{ old('address', $order->address) }}</textarea><br>
    @error('address') <small style="color:red">{{ $message }}</small> @enderror
    <br><br>

    <label>Catatan</label><br>
    <textarea name="note" rows="3">{{ old('note', $order->note) }}</textarea><br>
    @error('note') <small style="color:red">{{ $message }}</small> @enderror
    <br><br>

    <label>Status</label><br>
    <input type="text" name="status" value="{{ old('status', $order->status) }}"><br>
    @error('status') <small style="color:red">{{ $message }}</small> @enderror
    <br><br>

    <button type="submit">Update</button>
</form>

<br>
<a href="{{ route('admin.orders.show', $order) }}">← Kembali</a>
@endsection
