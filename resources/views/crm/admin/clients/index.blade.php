<x-crm.admin.main-layout :contentWrapClasses="'lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]'">
    <header class="filament-header space-y-2 items-start justify-between sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4">
        <div>
            <h1 class="filament-header-heading text-2xl font-bold tracking-tight">
                {{ __('Clients') }}
            </h1>
        </div>
    </header>
    <div class="filament-tables-component">
        <div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
            <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 border-t">
                <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
                    <thead>
                    <tr class="bg-gray-500/5">
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-name">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 ">
                                <span>{{ __('Name') }}</span>
                                <svg class="filament-tables-header-cell-sort-icon h-3 w-3 dark:text-gray-300 opacity-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-email">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 ">
                                <span>{{ __('VAT') }}</span>
                                <svg class="filament-tables-header-cell-sort-icon h-3 w-3 dark:text-gray-300 opacity-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-country">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 cursor-default ">
                                <span>{{ __('Address') }}</span>
                            </button>
                        </th>
                        <th class="w-5"></th>
                    </tr>
                    </thead>
                    @foreach($clients as $client)
                        <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                            <td class="filament-tables-cell dark:text-white filament-table-cell-name">
                                <div class="filament-tables-column-wrapper">
                                    <a href="{{ route('clients.show', $client) }}" class="flex w-full justify-start text-start">
                                        <div class="filament-tables-text-column px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                {{ $client->name }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="filament-tables-cell dark:text-white filament-table-cell-email">
                                <div class="filament-tables-column-wrapper">
                                    <a href="{{ route('clients.show', $client) }}" class="flex w-full justify-start text-start">
                                        <div class="filament-tables-text-column px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                {{ $client->vat }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="filament-tables-cell dark:text-white filament-table-cell-country">
                                <div class="filament-tables-column-wrapper">
                                    <a href="{{ route('clients.show', $client) }}" class="flex w-full justify-start text-start">
                                        <div class="filament-tables-text-column px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                {{ $client->address }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="filament-tables-actions-cell px-4 py-3 whitespace-nowrap">
                                <div class="filament-tables-actions-container flex items-center gap-4 justify-end">
                                    <a href="{{ route('clients.show', $client) }}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 filament-tables-link-action">
                                        {{ __('Show') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $clients->links('pagination.tailwind') }}
        </div>
    </div>
</x-crm.admin.main-layout>
