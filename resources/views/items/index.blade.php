<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    @vite('resources/js/app.js')
</head>
<body class="antialiased">
<ul role="list" class="divide-y divide-gray-100">
    @foreach($items as $item)
    <li class="flex justify-between gap-x-6 py-5">
        <div class="flex gap-x-4">
            <div class="min-w-0 flex-auto">
                <p class="text-sm font-semibold leading-6 text-gray-900">{{ $item->name }}</p>
            </div>
        </div>
    </li>
    @endforeach
    {{ $items->links() }}
</ul>
</body>
</html>
