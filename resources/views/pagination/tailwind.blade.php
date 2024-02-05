@if ($paginator->hasPages())
<div class="filament-tables-pagination-container p-2 border-t dark:border-gray-700">
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="filament-tables-pagination flex items-center justify-between">
        <div class="flex justify-between items-center flex-1 lg:hidden">
            <div class="w-10">
            </div>
            <livewire:per-page-paginator />
        </div>
        <div class="hidden flex-1 items-center lg:grid grid-cols-3">
            <div class="flex items-center">
                <div class="pl-2 text-sm font-medium dark:text-white">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        {{ $paginator->firstItem() }}
                        {!! __('to') !!}
                        {{ $paginator->lastItem() }}
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                 {{ $paginator->total() }}
                    {!! __('results') !!}
                </div>
            </div>
            <div class="flex items-center justify-center">
                <livewire:per-page-paginator />
            </div>
            <div class="flex items-center justify-end">
                <div class="py-3 border rounded-lg dark:border-gray-600">
                    <ol class="flex gap-px items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600">
                        @foreach ($elements as $element)
                            {{-- "Three Dots" Separator --}}
                            @if (is_string($element))
                                <li>
                                    <button disabled="" type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none filament-tables-pagination-item-disabled cursor-not-allowed pointer-events-none opacity-70">
                                        <span>...</span>
                                    </button>
                                </li>
                            @endif

                            {{-- Array Of Links --}}
                            @if (is_array($element))
                                @if (!$paginator->onFirstPage())
                                    <li>
                                        <a href="{{ $paginator->previousPageUrl() }}" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 transition text-primary-600" rel="prev">
                                            <svg class="w-5 h-5 rtl:scale-x-[-1]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span></span>
                                        </a>
                                    </li>
                                @endif
                                @foreach ($element as $page => $url)
                                    @if ($page == $paginator->currentPage())
                                        <li>
                                            <button type="button" disabled class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 filament-tables-pagination-item-active focus:underline bg-primary-500/10 ring-2 ring-primary-500">
                                                <span>{{ $page }}</span>
                                            </button>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $url }}" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition">
                                                <span>{{ $page }}</span>
                                            </a>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        {{-- Next Page Link --}}
                        @if ($paginator->hasMorePages())
                            <li>
                                <a href="{{ $paginator->nextPageUrl() }}" type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 transition text-primary-600"  aria-label="{{ __('next') }}" rel="next">
                                    <svg class="w-5 h-5 rtl:scale-x-[-1]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span></span>
                                </a>
                            </li>
                        @endif
                    </ol>
                </div>
            </div>
        </div>
    </nav>
</div>
@endif
