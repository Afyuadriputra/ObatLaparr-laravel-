@extends('layouts.user')

@section('content')
<div class="grid lg:grid-cols-2 gap-6">
    <div class="rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm">
        <div class="aspect-[4/3] overflow-hidden rounded-2xl bg-zinc-100">
            @if($product->photo_path)
                <img src="{{ asset('storage/'.$product->photo_path) }}" alt="{{ $product->name }}" class="h-full w-full object-cover">
            @endif
        </div>
    </div>

    <div class="space-y-4">
        <div>
            <a href="{{ route('menu.index') }}" class="text-sm font-bold text-pink-600 hover:text-pink-700">← Kembali</a>
            <h1 class="mt-2 text-3xl font-black">{{ $product->name }}</h1>
            <div class="mt-2 flex items-center gap-2">
                <div class="text-xl font-black text-zinc-900">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                <div class="text-xs font-bold rounded-full px-2 py-1 border
                    {{ $product->stock > 0 ? 'border-pink-200 bg-pink-50 text-pink-700' : 'border-zinc-200 bg-zinc-100 text-zinc-700' }}">
                    {{ $product->stock > 0 ? 'Stok '.$product->stock : 'Habis' }}
                </div>
            </div>
            @if($product->description)
                <p class="mt-3 text-zinc-600 leading-relaxed">{{ $product->description }}</p>
            @endif
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
            <form method="POST" action="{{ route('cart.add') }}" class="space-y-3">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div class="grid sm:grid-cols-2 gap-3">
                    <div>
                        <label class="text-sm font-bold">Qty</label>
                        <input type="number" name="qty" min="1" value="1"
                               class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
                    </div>
                    <div>
                        <label class="text-sm font-bold">Catatan item (opsional)</label>
                        <input type="text" name="note" placeholder="Contoh: tanpa pedas"
                               class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
                    </div>
                </div>

                <button {{ $product->stock <= 0 ? 'disabled' : '' }}
                        class="w-full rounded-2xl px-5 py-3 text-sm font-black text-white
                        {{ $product->stock > 0 ? 'bg-pink-500 hover:bg-pink-600' : 'bg-zinc-300 cursor-not-allowed' }}">
                    Tambah ke Keranjang
                </button>
            </form>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('cart.index') }}" class="flex-1 rounded-2xl border border-zinc-200 bg-white px-5 py-3 text-center text-sm font-bold hover:bg-zinc-50">
                Lihat Keranjang
            </a>
            <a href="{{ route('menu.index') }}" class="flex-1 rounded-2xl bg-zinc-900 px-5 py-3 text-center text-sm font-bold text-white hover:bg-black">
                Tambah Menu Lain
            </a>
        </div>
    </div>
</div>
@endsection
