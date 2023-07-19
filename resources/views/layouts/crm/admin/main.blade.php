@props([
    'contentWrapClasses' => ''
])
    <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Styles -->
    @livewireStyles
</head>
<body class="font-sans antialiased">
<x-banner />

<div class="min-h-screen bg-gray-100 {{ $contentWrapClasses }}">
    @livewire('navigation-menu')

    <!-- Page Heading -->
    @if (isset($header))
        <header class="bg-white shadow">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endif

    <!-- Page Content -->
    <x-sidebar/>
    <div class="filament-main-content flex-1 w-full px-4 mx-auto md:px-6 lg:px-8 max-w-7xl">
        <div class="filament-page filament-resources-list-records-page filament-resources-shop-customers">
            <div class="space-y-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>

@stack('modals')

@livewireScripts
</body>
</html>
