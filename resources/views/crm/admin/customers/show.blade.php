<x-crm.admin.main-layout :contentWrapClasses="'lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]'">
    <header class="filament-header space-y-2 items-start justify-between sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4">
        <div>
            <h1 class="filament-header-heading text-2xl font-bold tracking-tight">
                {{ __('Customers') }}
            </h1>
        </div>
        <div class="filament-page-actions flex flex-wrap items-center gap-4 justify-start shrink-0">
            <a class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action" href="https://demo.filamentphp.com/shop/customers/create" dusk="filament.admin.action.create">
                <span class="">{{ __('New Customer') }}</span>
            </a>
        </div>
    </header>
    <div class="filament-tables-component">
        <div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
            <div class="filament-tables-header-container" x-show="hasHeader = (true || selectedRecords.length)">
                <div class="filament-tables-header-toolbar flex items-center justify-between p-2 h-14">
                    <div class="flex items-center gap-2">
                        <div class="filament-dropdown filament-tables-bulk-actions"
                             style="display: none;">
                            <div class="filament-dropdown-trigger cursor-pointer">
                                <button title="Open actions" type="button" class="filament-icon-button flex items-center justify-center rounded-full relative outline-none hover:bg-gray-500/5 disabled:opacity-70 disabled:cursor-not-allowed disabled:pointer-events-none text-primary-500 focus:bg-primary-500/10 dark:hover:bg-gray-300/5 w-10 h-10 filament-tables-bulk-actions-trigger">
                                                    <span class="sr-only">
                                                    Open actions
                                                    </span>
                                    <svg class="filament-icon-button-icon w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div x-ref="panel" class="filament-dropdown-panel absolute z-10 w-full divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-black/5 transition dark:divide-gray-700 dark:bg-gray-800 dark:ring-white/10 max-w-[14rem]" style="display: none;">
                                <div class="filament-dropdown-list p-1" dark-mode="dark-mode">
                                    <button type="button" class="filament-dropdown-list-item filament-dropdown-item group flex w-full items-center whitespace-nowrap rounded-md p-2 text-sm outline-none hover:text-white focus:text-white hover:bg-danger-500 focus:bg-danger-500 filament-tables-bulk-action">
                                        <svg class="filament-dropdown-list-item-icon mr-2 h-5 w-5 rtl:ml-2 rtl:mr-0 group-hover:text-white group-focus:text-white text-danger-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="filament-dropdown-list-item-label truncate w-full text-start">
                                                        Delete selected
                                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center justify-end w-full gap-2 md:max-w-md">
                        <div class="filament-tables-search-container flex items-center justify-end flex-1">
                            <div class="filament-tables-search-input">
                                <label class="relative flex items-center group">
                                                    <span class="absolute inset-y-0 left-0 flex items-center justify-center w-9 h-9 text-gray-400 pointer-events-none group-focus-within:text-primary-500">
                                                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                        </svg>
                                                    </span>
                                    <input  placeholder="Search" type="search" autocomplete="off" class="block w-full max-w-xs h-9 pl-9 placeholder-gray-400 transition duration-75 border-gray-300 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <span class="sr-only">
                                                    Search
                                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="filament-dropdown filament-tables-filters shrink-0">
                            <div class="filament-dropdown-trigger cursor-pointer">
                                <button title="Filter" type="button" class="filament-icon-button flex items-center justify-center rounded-full relative outline-none hover:bg-gray-500/5 disabled:opacity-70 disabled:cursor-not-allowed disabled:pointer-events-none text-primary-500 focus:bg-primary-500/10 dark:hover:bg-gray-300/5 w-10 h-10 filament-tables-filters-trigger">
                                                    <span class="sr-only">
                                                    Filter
                                                    </span>
                                    <svg class="filament-icon-button-icon w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                    </svg>
                                </button>
                            </div>
                            <div x-ref="panel" class="filament-dropdown-panel absolute z-10 w-full divide-y divide-gray-100 rounded-lg bg-white shadow-lg ring-1 ring-black/5 transition dark:divide-gray-700 dark:bg-gray-800 dark:ring-white/10 max-w-xs" style="display: none;">
                                <div class="filament-tables-filters-form space-y-6 p-4">
                                    <div class="grid grid-cols-1 lg:grid-cols-1 filament-forms-component-container gap-6">
                                        <div class="col-span-1">
                                            <div>
                                                <div class="grid grid-cols-1 filament-forms-component-container gap-6">
                                                    <div class="col-span-1">
                                                        <div class="filament-forms-field-wrapper">
                                                            <div class="space-y-2">
                                                                <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                                    <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="tableFilters.trashed.value">
                                                                                    <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                                                    Deleted records    </span>
                                                                    </label>
                                                                </div>
                                                                <div class="filament-forms-select-component flex items-center space-x-1 rtl:space-x-reverse group">
                                                                    <div class="flex-1 min-w-0">
                                                                        <select id="tableFilters.trashed.value" wire:model="tableFilters.trashed.value" dusk="filament.forms.tableFilters.trashed.value" class="filament-forms-input text-gray-900 block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500 border-gray-300 dark:border-gray-600">
                                                                            <option value="">Without deleted records</option>
                                                                            <option value="1">
                                                                                With deleted records
                                                                            </option>
                                                                            <option value="0">
                                                                                Only deleted records
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-danger-600 hover:text-danger-500 dark:text-danger-500 dark:hover:text-danger-400" wire:click="resetTableFiltersForm">
                                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="animate-spin filament-link-icon w-4 h-4 mr-1 rtl:ml-1" wire:loading.delay="wire:loading.delay" wire:target="resetTableFiltersForm">
                                                <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="currentColor"></path>
                                                <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                                            </svg>
                                            Reset filters
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 border-t">
                <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
                    <thead>
                    <tr class="bg-gray-500/5">
                        <td class="filament-tables-checkbox-cell w-4 px-4 whitespace-nowrap">
                            <label>
                                <input class="block border-gray-300 rounded shadow-sm text-primary-600 outline-none focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-primary-600 dark:checked:border-primary-600" type="checkbox">
                                <span class="sr-only">
                                                Select/deselect all items for bulk actions.
                                                </span>
                            </label>
                        </td>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-name">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 ">
                                                    <span class="sr-only">
                                                    Sort by
                                                    </span>
                                <span>
                                                    Name
                                                    </span>
                                <span class="sr-only">
                                                    Ascending
                                                    </span>
                                <svg class="filament-tables-header-cell-sort-icon h-3 w-3 dark:text-gray-300 opacity-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-email">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 ">
                                                    <span class="sr-only">
                                                    Sort by
                                                    </span>
                                <span>
                                                    Email
                                                    </span>
                                <span class="sr-only">
                                                    Ascending
                                                    </span>
                                <svg class="filament-tables-header-cell-sort-icon h-3 w-3 dark:text-gray-300 opacity-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-country">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 cursor-default ">
                                                <span>
                                                Country
                                                </span>
                            </button>
                        </th>
                        <th class="filament-tables-header-cell p-0 filament-table-header-cell-phone">
                            <button type="button" class="flex items-center gap-x-1 w-full px-4 py-2 whitespace-nowrap font-medium text-sm text-gray-600 dark:text-gray-300 ">
                                                    <span class="sr-only">
                                                    Sort by
                                                    </span>
                                <span>
                                                    Phone
                                                    </span>
                                <span class="sr-only">
                                                    Ascending
                                                    </span>
                                <svg class="filament-tables-header-cell-sort-icon h-3 w-3 dark:text-gray-300 opacity-25" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </th>
                        <th class="w-5"></th>
                    </tr>
                    </thead>
                    <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                    <tr class="filament-tables-row transition">
                        <td></td>
                        <td class="filament-tables-cell dark:text-white filament-table-individual-search-cell-name px-4 py-1">
                            <div class="filament-tables-search-input">
                                <label class="relative flex items-center group">
                                                        <span class="absolute inset-y-0 left-0 flex items-center justify-center w-9 h-9 text-gray-400 pointer-events-none group-focus-within:text-primary-500">
                                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                            </svg>
                                                        </span>
                                    <input placeholder="Search" type="search" autocomplete="off" class="block w-full max-w-xs h-9 pl-9 placeholder-gray-400 transition duration-75 border-gray-300 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <span class="sr-only">
                                                        Search
                                                        </span>
                                </label>
                            </div>
                        </td>
                        <td class="filament-tables-cell dark:text-white filament-table-individual-search-cell-email px-4 py-1">
                            <div class="filament-tables-search-input">
                                <label class="relative flex items-center group">
                                                        <span class="absolute inset-y-0 left-0 flex items-center justify-center w-9 h-9 text-gray-400 pointer-events-none group-focus-within:text-primary-500">
                                                            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                                            </svg>
                                                        </span>
                                    <input placeholder="Search" type="search" autocomplete="off" class="block w-full max-w-xs h-9 pl-9 placeholder-gray-400 transition duration-75 border-gray-300 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <span class="sr-only">
                                                        Search
                                                        </span>
                                </label>
                            </div>
                        </td>
                        <td class="filament-tables-cell dark:text-white filament-table-individual-search-cell-country px-4 py-1">
                        </td>
                        <td class="filament-tables-cell dark:text-white filament-table-individual-search-cell-phone px-4 py-1">
                        </td>
                        <td></td>
                    </tr>
                    <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                        <td class="filament-tables-reorder-cell w-4 px-4 whitespace-nowrap hidden">
                        </td>
                        <td class="filament-tables-checkbox-cell w-4 px-4 whitespace-nowrap">
                            <label>
                                <input class="block border-gray-300 rounded shadow-sm text-primary-600 outline-none focus:ring focus:ring-primary-200 focus:ring-opacity-50 dark:bg-gray-700 dark:border-gray-600 dark:checked:bg-primary-600 dark:checked:border-primary-600 filament-tables-record-checkbox" x-model="selectedRecords" value="10" wire:loading.attr="disabled" wire:target="previousPage,nextPage,gotoPage,sortTable,tableFilters,resetTableFiltersForm,tableSearchQuery,tableColumnSearchQueries,tableRecordsPerPage" type="checkbox">
                                <span class="sr-only">
                                                Select/deselect item 10 for bulk actions.
                                                </span>
                            </label>
                        </td>
                        <td class="filament-tables-cell dark:text-white filament-table-cell-name">
                            <div class="filament-tables-column-wrapper">
                                <a href="https://demo.filamentphp.com/shop/customers/10/edit" class="flex w-full justify-start text-start">
                                    <div class="filament-tables-text-column px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                                <span class="">
                                                                Emery Kovacek
                                                                </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </td>
                        <td class="filament-tables-cell dark:text-white filament-table-cell-email">
                            <div class="filament-tables-column-wrapper">
                                <a href="https://demo.filamentphp.com/shop/customers/10/edit" class="flex w-full justify-start text-start">
                                    <div class="filament-tables-text-column px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                                <span class="">
                                                                gkunze@example.net
                                                                </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </td>
                        <td class="filament-tables-cell dark:text-white filament-table-cell-country">
                            <div class="filament-tables-column-wrapper">
                                <a href="https://demo.filamentphp.com/shop/customers/10/edit" class="flex w-full justify-start text-start">
                                    <div class="filament-tables-text-column px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                                <span class="">
                                                                Indonesia
                                                                </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </td>
                        <td class="filament-tables-cell dark:text-white filament-table-cell-phone" >
                            <div class="filament-tables-column-wrapper">
                                <a href="https://demo.filamentphp.com/shop/customers/10/edit" class="flex w-full justify-start text-start">
                                    <div class="filament-tables-text-column px-4 py-3">
                                        <div class="inline-flex items-center space-x-1 rtl:space-x-reverse">
                                                                <span class="">
                                                                831-270-1389
                                                                </span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </td>
                        <td class="filament-tables-actions-cell px-4 py-3 whitespace-nowrap">
                            <div class="filament-tables-actions-container flex items-center gap-4 justify-end">
                                <a class="filament-link inline-flex items-center justify-center gap-0.5 font-medium outline-none hover:underline focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 filament-tables-link-action" href="https://demo.filamentphp.com/shop/customers/10/edit" dusk="filament.tables.action.edit">
                                    <svg class="filament-link-icon w-4 h-4 mr-1 rtl:ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path>
                                    </svg>
                                    Edit
                                </a>
                            </div>
                        </td>
                        <td class="w-full px-4 py-4 animate-pulse hidden" colspan="6">
                            <div class="h-4 bg-gray-300 rounded-md dark:bg-gray-600"></div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="filament-tables-pagination-container p-2 border-t dark:border-gray-700">
                <nav role="navigation" aria-label="Pagination Navigation" class="filament-tables-pagination flex items-center justify-between">
                    <div class="flex justify-between items-center flex-1 lg:hidden">
                        <div class="w-10">
                        </div>
                        <div class="flex items-center space-x-2 filament-tables-pagination-records-per-page-selector rtl:space-x-reverse">
                            <label>
                                <select wire:model="tableRecordsPerPage" class="h-8 text-sm pr-8 leading-none transition duration-75 border-gray-300 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:border-primary-500">
                                    <option value="5">5</option>
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="-1">All</option>
                                </select>
                                <span class="text-sm font-medium dark:text-white">
                                                per page
                                                </span>
                            </label>
                        </div>
                        <div class="w-10">
                            <button title="Next" type="button" class="filament-icon-button flex items-center justify-center rounded-full relative outline-none hover:bg-gray-500/5 disabled:opacity-70 disabled:cursor-not-allowed disabled:pointer-events-none text-primary-500 focus:bg-primary-500/10 dark:hover:bg-gray-300/5 w-10 h-10" wire:click="nextPage('page')" rel="next">
                                                <span class="sr-only">
                                                Next
                                                </span>
                                <svg wire:loading.remove.delay="1" wire:target="nextPage('page')" class="filament-icon-button-icon w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                </svg>
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="animate-spin filament-icon-button-icon w-5 h-5" wire:loading.delay="wire:loading.delay" wire:target="nextPage('page')">
                                    <path opacity="0.2" fill-rule="evenodd" clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill="currentColor"></path>
                                    <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="hidden flex-1 items-center lg:grid grid-cols-3">
                        <div class="flex items-center">
                            <div class="pl-2 text-sm font-medium dark:text-white">
                                Showing 1 to 10 of 1000 results
                            </div>
                        </div>
                        <div class="flex items-center justify-center">
                            <div class="flex items-center space-x-2 filament-tables-pagination-records-per-page-selector rtl:space-x-reverse">
                                <label>
                                    <select wire:model="tableRecordsPerPage" class="h-8 text-sm pr-8 leading-none transition duration-75 border-gray-300 rounded-lg shadow-sm outline-none focus:border-primary-500 focus:ring-1 focus:ring-inset focus:ring-primary-500 dark:text-white dark:bg-gray-700 dark:border-gray-600 dark:focus:border-primary-500">
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="-1">All</option>
                                    </select>
                                    <span class="text-sm font-medium dark:text-white">
                                                    per page
                                                    </span>
                                </label>
                            </div>
                        </div>
                        <div class="flex items-center justify-end">
                            <div class="py-3 border rounded-lg dark:border-gray-600">
                                <ol class="flex gap-px items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600">
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 filament-tables-pagination-item-active focus:underline bg-primary-500/10 ring-2 ring-primary-500" wire:click="gotoPage(1, 'page')" aria-label="Go to page 1" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.1">
                                            <span>1</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition" wire:click="gotoPage(2, 'page')" aria-label="Go to page 2" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.2">
                                            <span>2</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition" wire:click="gotoPage(3, 'page')" aria-label="Go to page 3" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.3">
                                            <span>3</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition" wire:click="gotoPage(4, 'page')" aria-label="Go to page 4" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.4">
                                            <span>4</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition" wire:click="gotoPage(5, 'page')" aria-label="Go to page 5" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.5">
                                            <span>5</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition" wire:click="gotoPage(6, 'page')" aria-label="Go to page 6" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.6">
                                            <span>6</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button disabled="" type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none filament-tables-pagination-item-disabled cursor-not-allowed pointer-events-none opacity-70">
                                            <span>...</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition" wire:click="gotoPage(99, 'page')" aria-label="Go to page 99" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.99">
                                            <span>99</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition" wire:click="gotoPage(100, 'page')" aria-label="Go to page 100" wire:key="p9Wj4pIzor6ei5kMOgec.table.pagination.page.100">
                                            <span>100</span>
                                        </button>
                                    </li>
                                    <li>
                                        <button type="button" class="filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 transition text-primary-600" wire:click="nextPage('page')" aria-label="Next" rel="next">
                                            <svg class="w-5 h-5 rtl:scale-x-[-1]" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span></span>
                                        </button>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
</x-crm.admin.main-layout>
