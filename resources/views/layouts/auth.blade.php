<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') - KopiKu</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-coffee-100 via-coffee-50 to-amber-50/40 p-4 font-sans text-coffee-900 antialiased selection:bg-coffee-200">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="mb-8 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-coffee-500 to-coffee-700 shadow-lg shadow-coffee-500/20">
                    <span class="text-2xl">☕</span>
                </div>
                <div class="text-left">
                    <span class="text-2xl font-bold tracking-tight text-coffee-900">KopiKu</span>
                    <span class="block text-xs font-semibold uppercase tracking-widest text-coffee-600">System Login</span>
                </div>
            </a>
        </div>

        {{-- Card --}}
        <div class="rounded-3xl border border-coffee-200 bg-white p-8 shadow-xl shadow-coffee-900/5 sm:p-10">
            @yield('content')
        </div>

        <div class="mt-6 text-center text-xs text-coffee-600">
            &copy; {{ date('Y') }} KopiKu Coffee Shop &bull; Ryan Sheva & David Prastiansyah
        </div>
    </div>
</body>
</html>
