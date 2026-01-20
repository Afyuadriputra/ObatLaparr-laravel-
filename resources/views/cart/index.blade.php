@extends('layouts.user')

@section('content')
<div class="flex flex-col lg:flex-row gap-6">
    <div class="flex-1 rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <h1 class="text-2xl font-black">Keranjang</h1>
            @if(!empty($cart))
                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    <button class="text-sm font-bold text-zinc-600 hover:text-zinc-900">Kosongkan</button>
                </form>
            @endif
        </div>

        @if(empty($cart))
            <div class="mt-6 rounded-2xl border border-zinc-200 bg-zinc-50 p-6 text-center">
                <div class="text-lg font-black">Keranjang masih kosong</div>
                <p class="text-sm text-zinc-600 mt-1">Yuk pilih menu dulu.</p>
                <a href="{{ route('menu.index') }}" class="mt-4 inline-block rounded-2xl bg-pink-500 px-5 py-3 text-sm font-black text-white hover:bg-pink-600">
                    Lihat Menu
                </a>
            </div>
        @else
            <div class="mt-4 space-y-3">
                @foreach($cart as $item)
                    <div class="rounded-2xl border border-zinc-200 p-4">
                        <div class="flex items-start gap-4">
                            <div class="h-16 w-20 rounded-xl bg-zinc-100 overflow-hidden flex-shrink-0">
                                @if($item['photo_path'])
                                    <img src="{{ asset('storage/'.$item['photo_path']) }}" class="h-full w-full object-cover" alt="">
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="flex items-start justify-between gap-3">
                                    <div>
                                        <div class="font-black">{{ $item['name'] }}</div>
                                        <div class="text-sm text-zinc-600">Rp{{ number_format($item['price'], 0, ',', '.') }}</div>
                                        @if(!empty($item['note']))
                                            <div class="mt-1 inline-flex rounded-full border border-pink-200 bg-pink-50 px-3 py-1 text-xs font-bold text-pink-700">
                                                Catatan: {{ $item['note'] }}
                                            </div>
                                        @endif
                                    </div>
                                    <form method="POST" action="{{ route('cart.remove') }}">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <button class="text-sm font-bold text-zinc-600 hover:text-zinc-900">Hapus</button>
                                    </form>
                                </div>

                                <div class="mt-3 flex items-center justify-between gap-3">
                                    <form method="POST" action="{{ route('cart.update') }}" class="flex items-center gap-2">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['product_id'] }}">
                                        <input type="number" name="qty" min="1" value="{{ $item['qty'] }}"
                                               class="w-20 rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
                                        <button class="rounded-xl bg-zinc-900 px-3 py-2 text-sm font-bold text-white hover:bg-black">
                                            Update
                                        </button>
                                    </form>

                                    <div class="text-sm font-black">
                                        Total: Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="w-full lg:w-[360px]">
        <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm sticky top-24">
            <h2 class="text-lg font-black">Ringkasan</h2>
            <div class="mt-3 flex items-center justify-between text-sm">
                <span class="text-zinc-600">Subtotal</span>
                <span class="font-black">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>

            <a href="{{ route('checkout.index') }}"
               class="mt-5 block rounded-2xl bg-pink-500 px-5 py-3 text-center text-sm font-black text-white hover:bg-pink-600">
                Checkout
            </a>

            <a href="{{ route('menu.index') }}"
               class="mt-2 block rounded-2xl border border-zinc-200 bg-white px-5 py-3 text-center text-sm font-bold hover:bg-zinc-50">
                Tambah Menu
            </a>
        </div>
    </div>
</div>
@endsection
