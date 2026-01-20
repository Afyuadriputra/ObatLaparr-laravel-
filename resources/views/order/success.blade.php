@extends('layouts.user')

@section('content')
<div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
        <div>
            <div class="inline-flex items-center gap-2 rounded-full border border-pink-200 bg-pink-50 px-4 py-2 text-sm font-bold text-pink-700">
                ✅ Order berhasil dibuat
            </div>
            <h1 class="mt-3 text-2xl font-black">Kode: <span class="text-pink-600">{{ $order->code }}</span></h1>
            <p class="mt-1 text-sm text-zinc-600">
                Status awal: <span class="font-bold">{{ $order->status }}</span>
            </p>
        </div>

        <a href="{{ $waLink }}"
           class="rounded-2xl bg-pink-500 px-5 py-3 text-center text-sm font-black text-white hover:bg-pink-600">
            Chat WhatsApp Admin
        </a>
    </div>

    <div class="mt-6 grid lg:grid-cols-2 gap-6">
        <div class="rounded-3xl border border-zinc-200 bg-zinc-50 p-5">
            <h2 class="font-black">Ringkasan</h2>
            <div class="mt-3 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-zinc-600">Nama</span><span class="font-bold">{{ $order->customer_name }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-600">WA</span><span class="font-bold">{{ $order->phone }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-600">Tipe</span><span class="font-bold">{{ $order->fulfillment_type }}</span></div>
                @if($order->fulfillment_type === 'delivery')
                    <div class="pt-2 text-zinc-600">Alamat</div>
                    <div class="font-bold">{{ $order->address }}</div>
                @endif
                <div class="flex justify-between pt-3 border-t border-zinc-200">
                    <span class="text-zinc-600">Total</span>
                    <span class="text-lg font-black">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="rounded-3xl border border-zinc-200 bg-white p-5">
            <h2 class="font-black">Item</h2>
            <div class="mt-3 space-y-2">
                @foreach($order->items as $it)
                    <div class="flex items-center justify-between rounded-2xl bg-zinc-50 p-3">
                        <div>
                            <div class="font-black">{{ $it->product->name }}</div>
                            <div class="text-sm text-zinc-600">x{{ $it->qty }}</div>
                            @if($it->note_item)
                                <div class="text-xs font-bold text-pink-700">Catatan: {{ $it->note_item }}</div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-5 flex gap-2">
                <a href="{{ route('order.track.form') }}"
                   class="flex-1 rounded-2xl border border-zinc-200 bg-white px-5 py-3 text-center text-sm font-bold hover:bg-zinc-50">
                    Cek Status Pesanan
                </a>
                <a href="{{ route('menu.index') }}"
                   class="flex-1 rounded-2xl bg-zinc-900 px-5 py-3 text-center text-sm font-bold text-white hover:bg-black">
                    Pesan Lagi
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
