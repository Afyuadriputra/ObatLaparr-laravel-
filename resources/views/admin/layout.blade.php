<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin - Obat Laparr' }}</title>
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>

<body class="min-h-screen bg-zinc-50 text-zinc-900">
@php
    // sidebar link config biar gampang maintenance
    $navItems = [
        ['label' => 'Dashboard', 'route' => 'admin.dashboard', 'active' => 'admin.dashboard'],
        ['label' => 'Produk',    'route' => 'admin.products.index', 'active' => 'admin.products.*'],
        ['label' => 'Kategori',  'route' => 'admin.categories.index', 'active' => 'admin.categories.*'],
        ['label' => 'Pesanan',   'route' => 'admin.orders.index', 'active' => 'admin.orders.*'],
        ['label' => 'Setting',   'route' => 'admin.settings.edit', 'active' => 'admin.settings.*'],
    ];

    $linkBase = 'block rounded-2xl px-4 py-2.5 font-bold transition';
    $linkIdle = 'text-zinc-900 hover:bg-zinc-50';
    $linkActive = 'bg-pink-500 text-white shadow-sm';
@endphp

<div class="flex min-h-screen">
    {{-- Sidebar --}}
    <aside class="hidden lg:flex w-72 flex-col border-r border-zinc-200 bg-white sticky top-0 h-screen">
        {{-- Brand --}}
        <div class="p-5 border-b border-zinc-200">
            <div class="font-black text-lg">
                <span class="text-pink-600">Obat</span> Laparr
            </div>
            <div class="text-xs text-zinc-600">Admin Panel</div>
        </div>

        {{-- Nav --}}
        <nav class="p-4 space-y-2">
            @foreach ($navItems as $item)
                <a href="{{ route($item['route']) }}"
                   class="{{ $linkBase }} {{ request()->routeIs($item['active']) ? $linkActive : $linkIdle }}">
                    {{ $item['label'] }}
                </a>
            @endforeach

            <div class="pt-3 mt-3 border-t border-zinc-200">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit"
                        class="w-full text-left {{ $linkBase }} bg-zinc-900 text-white hover:bg-black">
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        {{-- Tip --}}
        <div class="mt-auto p-4">
            <div class="rounded-2xl border border-pink-200 bg-pink-50 p-4 text-sm text-pink-800">
                Tip: cek “Menunggu Konfirmasi” tiap pagi biar order nggak kelewat.
            </div>
        </div>
    </aside>

    {{-- Main --}}
    <main class="flex-1">
        {{-- Header --}}
        <header class="border-b border-zinc-200 bg-white">
            <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
                <div>
                    <div class="text-sm text-zinc-600">Admin</div>
                    <div class="font-black">{{ $pageTitle ?? 'Dashboard' }}</div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}"
                       class="rounded-2xl bg-zinc-900 px-4 py-2 text-sm font-bold text-white hover:bg-black">
                        Lihat Toko
                    </a>
                </div>
            </div>
        </header>

        {{-- Content --}}
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
            @if (session('success'))
                <div class="mb-5 rounded-2xl border border-pink-200 bg-pink-50 px-4 py-3 text-pink-800">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-5 rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-zinc-800">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Validation errors (opsional tapi enak untuk admin form) --}}
            @if ($errors->any())
                <div class="mb-5 rounded-2xl border border-zinc-200 bg-white px-4 py-3">
                    <div class="font-bold">Ada input yang perlu diperbaiki:</div>
                    <ul class="mt-2 list-disc pl-5 text-sm text-zinc-700 space-y-1">
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
