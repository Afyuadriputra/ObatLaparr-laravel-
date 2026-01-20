@extends('admin.layout')

@php($pageTitle = 'Dashboard')

@section('content')
<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="text-sm text-zinc-600">Order Hari Ini</div>
        <div class="mt-2 text-3xl font-black">{{ $countToday }}</div>
        <div class="mt-3 inline-flex rounded-full border border-pink-200 bg-pink-50 px-3 py-1 text-xs font-bold text-pink-700">
            Pantau performa harian
        </div>
    </div>

    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="text-sm text-zinc-600">Menunggu Konfirmasi</div>
        <div class="mt-2 text-3xl font-black">{{ $newOrders }}</div>
        <div class="mt-3 text-sm text-zinc-600">Segera chat via WA agar cepat diproses.</div>
    </div>

    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="text-sm text-zinc-600">Shortcut</div>
        <div class="mt-3 flex flex-col gap-2">
            <a href="{{ route('admin.orders.index', ['status' => \App\Models\Order::STATUS_MENUNGGU_KONFIRMASI]) }}"
               class="rounded-2xl bg-pink-500 px-4 py-2 text-center text-sm font-black text-white hover:bg-pink-600">
                Lihat Order Baru
            </a>
            <a href="{{ route('admin.products.index') }}"
               class="rounded-2xl border border-zinc-200 bg-white px-4 py-2 text-center text-sm font-bold hover:bg-zinc-50">
                Kelola Produk
            </a>
        </div>
    </div>
</div>
@endsection
