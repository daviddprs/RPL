<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'KopiKu Coffee Shop') - Dashboard</title>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-coffee-50 font-sans text-coffee-900 antialiased selection:bg-coffee-200 selection:text-coffee-900">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        @include('components.sidebar')

        {{-- Main Content Area --}}
        <div class="flex flex-1 flex-col lg:pl-64">
            {{-- Top Navbar --}}
            @include('components.navbar')

            {{-- Page Content --}}
            <main class="flex-1 p-6 lg:p-8">
                @if(session('success'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center justify-between rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-800 shadow-sm transition-all">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm font-medium">{{ session('success') }}</span>
                        </div>
                        <button @click="show = false" class="text-green-600 hover:text-green-800">&times;</button>
                    </div>
                @endif

                @if(session('error'))
                    <div x-data="{ show: true }" x-show="show" class="mb-6 flex items-center justify-between rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-red-800 shadow-sm transition-all">
                        <div class="flex items-center gap-3">
                            <svg class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span class="text-sm font-medium">{{ session('error') }}</span>
                        </div>
                        <button @click="show = false" class="text-red-600 hover:text-red-800">&times;</button>
                    </div>
                @endif

                @yield('content')
            </main>

            {{-- Footer --}}
            @include('components.footer')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
