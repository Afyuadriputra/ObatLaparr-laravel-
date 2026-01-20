@extends('layouts.user')

@section('content')
<div class="flex flex-col gap-4">
    <div class="rounded-3xl border border-zinc-200 bg-white p-5 shadow-sm">
        <div class="flex flex-col lg:flex-row lg:items-center gap-3 lg:justify-between">
            <div>
                <h1 class="text-2xl font-black">Menu Obat Laparr</h1>
                <p class="text-sm text-zinc-600">Cari yang kamu mau, lalu gaskeun checkout.</p>
            </div>

            <form class="flex flex-col sm:flex-row gap-2 w-full lg:w-auto" method="GET" action="{{ route('menu.index') }}">
                <input type="text" name="q" value="{{ $q }}"
                       placeholder="Cari menu… (ayam, mie, pedas)"
                       class="w-full sm:w-80 rounded-2xl border border-zinc-200 bg-zinc-50 px-4 py-2.5 text-sm focus:outline-none focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
                @if($category)
                    <input type="hidden" name="category" value="{{ $category }}">
                @endif
                <button class="rounded-2xl bg-pink-500 px-4 py-2.5 text-sm font-bold text-white hover:bg-pink-600">
                    Search
                </button>
            </form>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('menu.index', ['q' => $q]) }}"
               class="rounded-full px-4 py-2 text-sm font-semibold border
               {{ !$category ? 'border-pink-200 bg-pink-50 text-pink-700' : 'border-zinc-200 bg-white hover:bg-zinc-50' }}">
                Semua
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('menu.index', ['category' => $cat->slug, 'q' => $q]) }}"
                   class="rounded-full px-4 py-2 text-sm font-semibold border
                   {{ $category === $cat->slug ? 'border-pink-200 bg-pink-50 text-pink-700' : 'border-zinc-200 bg-white hover:bg-zinc-50' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>
    </div>

    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $p)
            <div class="rounded-3xl border border-zinc-200 bg-white p-4 shadow-sm hover:shadow-md transition">
                <a href="{{ route('menu.show', $p->slug) }}" class="block group">
                    <div class="aspect-[4/3] overflow-hidden rounded-2xl bg-zinc-100">
                        @if($p->photo_path)
                            <img src="{{ asset('storage/'.$p->photo_path) }}" alt="{{ $p->name }}"
                                 class="h-full w-full object-cover group-hover:scale-[1.03] transition">
                        @endif
                    </div>
                    <div class="mt-3 flex items-start justify-between gap-3">
                        <div>
                            <div class="font-black">{{ $p->name }}</div>
                            <div class="text-sm text-zinc-600">Rp{{ number_format($p->price, 0, ',', '.') }}</div>
                        </div>
                        <div class="text-xs font-bold rounded-full px-2 py-1 border
                            {{ $p->stock > 0 ? 'border-pink-200 bg-pink-50 text-pink-700' : 'border-zinc-200 bg-zinc-100 text-zinc-700' }}">
                            {{ $p->stock > 0 ? 'Stok '.$p->stock : 'Habis' }}
                        </div>
                    </div>
                    @if($p->description)
                        <p class="mt-2 line-clamp-2 text-sm text-zinc-600">{{ $p->description }}</p>
                    @endif
                </a>

                <form class="mt-4 flex items-center gap-2" method="POST" action="{{ route('cart.add') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $p->id }}">
                    <input type="number" name="qty" min="1" value="1"
                           class="w-20 rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm focus:ring-4 focus:ring-pink-100 focus:border-pink-300">
                    <button {{ $p->stock <= 0 ? 'disabled' : '' }}
                            class="flex-1 rounded-2xl px-4 py-2 text-sm font-bold text-white
                            {{ $p->stock > 0 ? 'bg-zinc-900 hover:bg-black' : 'bg-zinc-300 cursor-not-allowed' }}">
                        Tambah
                    </button>
                </form>
            </div>
        @endforeach
    </div>

    <div class="mt-2">
        {{ $products->links() }}
    </div>
</div>
@endsection
