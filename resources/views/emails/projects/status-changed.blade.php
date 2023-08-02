<x-mail::message>
    # Your project status has been changed!

    New status is {{ $status }}

    <x-mail::button :url="$url">
        View Project
    </x-mail::button>

    Thanks,<br>
    {{ config('app.name') }}
</x-mail::message>
