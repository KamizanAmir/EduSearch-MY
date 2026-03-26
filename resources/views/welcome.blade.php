<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EduSearch Malaysia</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 antialiased font-sans">

    <nav class="bg-blue-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center w-full">
                <div class="flex-shrink-0 flex items-center">
                    <h1 class="text-white text-2xl font-bold">EduSearch MY</h1>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                            class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Dashboard</a>
                        @if (auth()->user()->role === 'admin')
                            <a href="#"
                                class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Admin
                                Panel</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}"
                            class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Log in</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="bg-white text-blue-600 hover:bg-gray-100 px-4 py-2 rounded-md text-sm font-medium ml-4">Register</a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <main>
        <livewire:course-directory />
    </main>

    @livewireScripts
</body>

</html>
