<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel - EduSearch MY</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="bg-gray-100 antialiased font-sans">

    <nav class="bg-blue-800 shadow-lg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center w-full">
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" wire:navigate class="text-white text-2xl font-bold">EduSearch Admin</a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ml-6">
                    <a href="{{ url('/dashboard') }}"
                        class="text-white hover:text-gray-200 px-3 py-2 rounded-md text-sm font-medium">Main
                        Dashboard</a>
                    <a href="{{ route('admin.panel') }}"
                        class="bg-blue-900 text-white px-3 py-2 rounded-md text-sm font-medium">Admin Panel</a>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <livewire:admin-panel />
    </main>

    @livewireScripts
</body>

</html>
