@extends('layouts.user')

@section('content')
<div class="grid lg:grid-cols-2 gap-6 items-center">
    <div class="space-y-4">
        <div class="inline-flex items-center gap-2 rounded-full border border-pink-200 bg-pink-50 px-4 py-2 text-sm font-semibold text-pink-700">
            🍱 Menu fresh tiap hari
        </div>
        <h1 class="text-3xl sm:text-4xl font-black leading-tight">
            Lapar?
            <span class="text-pink-600">Obatnya</span> di sini.
        </h1>
        <p class="text-zinc-600 max-w-xl">
            Pilih menu favorit, masukin keranjang, checkout tanpa login. Konfirmasi via WhatsApp—beres.
        </p>

        <div class="flex flex-col sm:flex-row gap-2">
            <a href="{{ route('menu.index') }}"
               class="rounded-2xl bg-pink-500 px-5 py-3 text-center text-sm font-bold text-white hover:bg-pink-600">
                Lihat Menu
            </a>
            <a href="{{ route('order.track.form') }}"
               class="rounded-2xl border border-zinc-200 bg-white px-5 py-3 text-center text-sm font-bold hover:bg-zinc-50">
                Cek Status Pesanan
            </a>
        </div>
    </div>

    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="grid grid-cols-2 gap-3">
            <div class="rounded-2xl bg-zinc-50 p-4">
                <div class="text-sm text-zinc-600">Checkout</div>
                <div class="text-lg font-black">Tanpa login</div>
            </div>
            <div class="rounded-2xl bg-zinc-50 p-4">
                <div class="text-sm text-zinc-600">Konfirmasi</div>
                <div class="text-lg font-black">WhatsApp</div>
            </div>
            <div class="rounded-2xl bg-zinc-50 p-4">
                <div class="text-sm text-zinc-600">Stok</div>
                <div class="text-lg font-black">Realtime</div>
            </div>
            <div class="rounded-2xl bg-zinc-50 p-4">
                <div class="text-sm text-zinc-600">Pilihan</div>
                <div class="text-lg font-black">Delivery/Pickup</div>
            </div>
        </div>
    </div>
</div>

<div class="mt-10">
    <div class="flex items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-black">Kategori</h2>
            <p class="text-sm text-zinc-600">Biar cepat nemu menu favoritmu.</p>
        </div>
        <a href="{{ route('menu.index') }}" class="text-sm font-bold text-pink-600 hover:text-pink-700">
            Lihat semua →
        </a>
    </div>

    <div class="mt-4 flex flex-wrap gap-2">
        @foreach($categories as $cat)
            <a href="{{ route('menu.index', ['category' => $cat->slug]) }}"
               class="rounded-full border border-zinc-200 bg-white px-4 py-2 text-sm font-semibold hover:border-pink-200 hover:bg-pink-50">
                {{ $cat->name }}
            </a>
        @endforeach
    </div>
</div>

<div class="mt-10">
    <h2 class="text-xl font-black">Menu Terbaru</h2>
    <p class="text-sm text-zinc-600">Yang lagi jadi incaran banyak orang.</p>

    <div class="mt-4 grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
        @foreach($products as $p)
            <a href="{{ route('menu.show', $p->slug) }}" class="group rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition">
                <div class="aspect-[4/3] w-full overflow-hidden rounded-2xl bg-zinc-100">
                    @if($p->photo_path)
                        <img src="{{ asset('storage/'.$p->photo_path) }}" alt="{{ $p->name }}" class="h-full w-full object-cover group-hover:scale-[1.03] transition">
                    @endif
                </div>
                <div class="mt-3 flex items-start justify-between gap-2">
                    <div>
                        <div class="font-black leading-tight">{{ $p->name }}</div>
                        <div class="text-sm text-zinc-600">Rp{{ number_format($p->price, 0, ',', '.') }}</div>
                    </div>
                    <div class="text-xs font-bold rounded-full px-2 py-1 border
                        {{ $p->stock > 0 ? 'border-pink-200 bg-pink-50 text-pink-700' : 'border-zinc-200 bg-zinc-100 text-zinc-700' }}">
                        {{ $p->stock > 0 ? 'Stok '.$p->stock : 'Habis' }}
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</div>
@endsection
