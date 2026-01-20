@extends('layouts.user')

@section('content')
<div class="grid lg:grid-cols-2 gap-6">
    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <h1 class="text-2xl font-black">Checkout</h1>
        <p class="text-sm text-zinc-600 mt-1">Isi data singkat, lalu konfirmasi via WhatsApp.</p>

        <form method="POST" action="{{ route('checkout.store') }}" class="mt-5 space-y-3">
            @csrf

            <div>
                <label class="text-sm font-bold">Nama</label>
                <input name="customer_name" value="{{ old('customer_name') }}"
                       class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
            </div>

            <div>
                <label class="text-sm font-bold">No WhatsApp</label>
                <input name="phone" value="{{ old('phone') }}" placeholder="contoh: 08xxxx / 62xxxx"
                       class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
            </div>

            <div>
                <label class="text-sm font-bold">Pengambilan</label>
                <select name="fulfillment_type"
                        class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
                    <option value="delivery" {{ old('fulfillment_type')==='delivery'?'selected':'' }}>Diantar</option>
                    <option value="pickup" {{ old('fulfillment_type')==='pickup'?'selected':'' }}>Ambil di tempat</option>
                </select>
                <p class="text-xs text-zinc-500 mt-1">Alamat wajib diisi kalau pilih “Diantar”.</p>
            </div>

            <div>
                <label class="text-sm font-bold">Alamat (opsional jika pickup)</label>
                <textarea name="address" rows="3"
                          class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">{{ old('address') }}</textarea>
            </div>

            <div>
                <label class="text-sm font-bold">Catatan pesanan (opsional)</label>
                <textarea name="note" rows="2"
                          class="mt-1 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">{{ old('note') }}</textarea>
            </div>

            <button class="w-full rounded-2xl bg-pink-500 px-5 py-3 text-sm font-black text-white hover:bg-pink-600">
                Buat Order
            </button>
        </form>
    </div>

    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <h2 class="text-lg font-black">Ringkasan Pesanan</h2>
        <div class="mt-4 space-y-2">
            @foreach($cart as $item)
                <div class="flex items-start justify-between gap-3 rounded-2xl bg-zinc-50 p-3">
                    <div>
                        <div class="font-black">{{ $item['name'] }}</div>
                        <div class="text-sm text-zinc-600">
                            Rp{{ number_format($item['price'], 0, ',', '.') }} × {{ $item['qty'] }}
                        </div>
                        @if(!empty($item['note']))
                            <div class="mt-1 text-xs font-bold text-pink-700">Catatan: {{ $item['note'] }}</div>
                        @endif
                    </div>
                    <div class="text-sm font-black">
                        Rp{{ number_format($item['price'] * $item['qty'], 0, ',', '.') }}
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4 border-t border-zinc-200 pt-4 flex items-center justify-between">
            <span class="text-sm text-zinc-600">Subtotal</span>
            <span class="text-lg font-black">Rp{{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="mt-3 rounded-2xl border border-pink-200 bg-pink-50 p-4 text-sm text-pink-800">
            Setelah order dibuat, kamu akan diarahkan ke halaman sukses untuk chat WhatsApp admin.
        </div>
    </div>
</div>
@endsection
