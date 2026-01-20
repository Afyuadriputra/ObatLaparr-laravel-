@php
    $cartCount = collect(session('cart', []))->sum('qty');
    $userName = auth()->check() ? auth()->user()->name : null;
@endphp

<header class="sticky top-0 z-40 border-b border-zinc-200 bg-white/80 backdrop-blur">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-3">
        <div class="flex items-center justify-between gap-3">
            <a href="{{ route('home') }}" class="group flex items-center gap-2">
                <div class="h-10 w-10 rounded-2xl bg-pink-500 text-white grid place-items-center font-black">
                    OL
                </div>
                <div class="leading-tight">
                    <div class="font-black text-lg">
                        <span class="text-pink-600">Obat</span> Laparr
                    </div>
                    <div class="text-xs text-zinc-600">
                        {{ $userName ? "Hai, {$userName} 👋" : 'Lapar? Gaskeun.' }}
                    </div>
                </div>
            </a>

            <div class="hidden md:flex items-center gap-2">
                <a href="{{ route('menu.index') }}"
                   class="rounded-xl px-3 py-2 text-sm font-semibold hover:bg-zinc-100">
                    Menu
                </a>
                <a href="{{ route('order.track.form') }}"
                   class="rounded-xl px-3 py-2 text-sm font-semibold hover:bg-zinc-100">
                    Track Order
                </a>
            </div>

            <div class="flex items-center gap-2">
                <a href="{{ route('cart.index') }}"
                   class="relative rounded-xl bg-zinc-900 px-3 py-2 text-sm font-semibold text-white hover:bg-black">
                    Keranjang
                    @if($cartCount > 0)
                        <span class="absolute -top-2 -right-2 rounded-full bg-pink-500 px-2 py-0.5 text-xs font-black text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('menu.index') }}"
                   class="rounded-xl bg-pink-500 px-3 py-2 text-sm font-semibold text-white hover:bg-pink-600">
                    Pesan Sekarang
                </a>

                @auth
                    <a href="{{ route('dashboard') }}"
                       class="hidden sm:inline-flex rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold hover:bg-zinc-50">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       class="hidden sm:inline-flex rounded-xl border border-zinc-200 bg-white px-3 py-2 text-sm font-semibold hover:bg-zinc-50">
                        Admin Login
                    </a>
                @endauth
            </div>
        </div>

        <div class="md:hidden mt-3 flex gap-2">
            <a href="{{ route('menu.index') }}"
               class="flex-1 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-center text-sm font-semibold">
                Menu
            </a>
            <a href="{{ route('order.track.form') }}"
               class="flex-1 rounded-xl border border-zinc-200 bg-white px-3 py-2 text-center text-sm font-semibold">
                Track
            </a>
        </div>
    </div>
</header>
