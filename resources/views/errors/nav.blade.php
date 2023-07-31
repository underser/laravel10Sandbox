<ul class="pt-2 flex justify-center">
    <li><a href="{{ route('dashboard') }}"  class="text-sm pr-2 hover:underline">{{ __('Dashboard') }}</a></li>
    @if(url()->previous() !== request()->url())
        <li><a href="{{ url()->previous() }}" class="text-sm hover:underline">{{ __('Go Back') }}</a></li>
    @endif
</ul>
