<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Obat Laparr' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-zinc-50 text-zinc-900">
    @include('layouts.navigation')

    <main class="mx-auto w-full max-w-6xl px-4 sm:px-6 lg:px-8 py-6">
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

        {{ $slot ?? '' }}
        @yield('content')
    </main>

    <footer class="border-t border-zinc-200 bg-white">
        <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div>
                    <div class="font-black text-lg">
                        <span class="text-pink-600">Obat</span> Laparr
                    </div>
                    <p class="text-sm text-zinc-600">Menu enak, cepat, dan bikin nagih 😋</p>
                </div>
                <div class="text-sm text-zinc-600">
                    © {{ date('Y') }} Obat Laparr. All rights reserved.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
