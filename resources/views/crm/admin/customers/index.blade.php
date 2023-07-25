<x-crm.admin.main-layout :contentWrapClasses="'lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]'">
    <header class="filament-header space-y-2 items-start justify-between sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4">
        <div>
            <h1 class="filament-header-heading text-2xl font-bold tracking-tight">
                {{ __('Customers') }}
            </h1>
        </div>
        <div class="filament-page-actions flex flex-wrap items-center gap-4 justify-start shrink-0">
            <a href="{{ route('customers.create') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                <span class="">{{ __('New Customer') }}</span>
            </a>
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
                                {{ __('Name') }}
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-email">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 ">
                                {{ __('Email') }}
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-country">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 cursor-default ">
                                {{ __('Country') }}
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-phone">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 ">
                                {{ __('Phone') }}
                            </button>
                        </th>
                        <th class="w-5"></th>
                    </tr>
                    </thead>
                    @foreach($customers as $customer)
                        <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                            <td class="filament-tables-cell dark:text-white filament-table-cell-name">
                                <div class="filament-tables-column-wrapper">
                                    <a href="{{ route('customers.show', $customer) }}" class="flex w-full justify-start text-start">
                                        <div class="filament-tables-text-column px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                {{ $customer->name }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="filament-tables-cell dark:text-white filament-table-cell-email">
                                <div class="filament-tables-column-wrapper">
                                    <a href="{{ route('customers.show', $customer) }}" class="flex w-full justify-start text-start">
                                        <div class="filament-tables-text-column px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                {{ $customer->email }}
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="filament-tables-cell dark:text-white filament-table-cell-country">
                                <div class="filament-tables-column-wrapper">
                                    <a href="{{ route('customers.show', $customer) }}" class="flex w-full justify-start text-start">
                                        <div class="filament-tables-text-column px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                Indonesia
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="filament-tables-cell dark:text-white filament-table-cell-phone" >
                                <div class="filament-tables-column-wrapper">
                                    <a href="{{ route('customers.show', $customer) }}" class="flex w-full justify-start text-start">
                                        <div class="filament-tables-text-column px-4 py-3">
                                            <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                831-270-1389
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </td>
                            <td class="filament-tables-actions-cell px-4 py-3 whitespace-nowrap">
                                <div class="filament-tables-actions-container flex items-center gap-4 justify-end">
                                    <a href="{{ route('customers.edit', $customer) }}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 filament-tables-link-action">
                                        <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                        </svg>
                                        {{ __('Edit') }}
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
            {{ $customers->links('pagination.tailwind') }}
        </div>
    </div>
</x-crm.admin.main-layout>
