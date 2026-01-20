@extends('layouts.user')

@section('content')
<div class="grid lg:grid-cols-2 gap-6">
    <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
        <h1 class="text-2xl font-black">Track Order</h1>
        <p class="text-sm text-zinc-600 mt-1">Masukkan kode order & nomor WA saat checkout.</p>

        <form method="POST" action="{{ route('order.track.result') }}" class="mt-5 space-y-3">
            @csrf
            <div>
                <label class="text-sm font-bold">Kode Order</label>
                <input name="code" value="{{ old('code', $order->code ?? '') }}"
                       class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300"
                       placeholder="ORD-2026-0001">
            </div>
            <div>
                <label class="text-sm font-bold">No WhatsApp</label>
                <input name="phone" value="{{ old('phone', $order->phone ?? '') }}"
                       class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300"
                       placeholder="08xxx / 62xxx">
            </div>

            <button class="w-full rounded-2xl bg-pink-500 px-5 py-3 text-sm font-black text-white hover:bg-pink-600">
                Cek Status
            </button>
        </form>
    </div>

    <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm">
        @if(isset($order))
            <div class="inline-flex rounded-full border border-pink-200 bg-pink-50 px-4 py-2 text-sm font-bold text-pink-700">
                Status: {{ $order->status }}
            </div>

            <div class="mt-4 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-zinc-600">Kode</span><span class="font-black">{{ $order->code }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-600">Nama</span><span class="font-black">{{ $order->customer_name }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-600">Tipe</span><span class="font-black">{{ $order->fulfillment_type }}</span></div>
                <div class="flex justify-between"><span class="text-zinc-600">Total</span><span class="font-black">Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
            </div>

            <div class="mt-5 border-t border-zinc-200 pt-4">
                <h2 class="font-black">Item</h2>
                <div class="mt-3 space-y-2">
                    @foreach($order->items as $it)
                        <div class="flex items-center justify-between rounded-2xl bg-zinc-50 p-3">
                            <div>
                                <div class="font-black">{{ $it->product->name }}</div>
                                <div class="text-sm text-zinc-600">x{{ $it->qty }}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @else
            <div class="rounded-2xl border border-zinc-200 bg-zinc-50 p-6 text-center">
                <div class="text-lg font-black">Belum ada data</div>
                <p class="text-sm text-zinc-600 mt-1">Isi form di kiri untuk cek pesananmu.</p>
            </div>
        @endif
    </div>
</div>
@endsection
