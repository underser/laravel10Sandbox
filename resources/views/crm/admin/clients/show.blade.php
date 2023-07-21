<x-crm.admin.main-layout :contentWrapClasses="'lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]'">
    <header class="filament-header space-y-2 items-start justify-between sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4">
        <div>
            <h1 class="filament-header-heading text-2xl font-bold tracking-tight">
                {{ __('Edit client :name', ['name' => $client->name]) }}
            </h1>
        </div>
        <div class="filament-page-actions flex flex-wrap items-center gap-4 justify-start shrink-0">
            <form action="{{ route('clients.destroy', $client) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-danger-600 hover:bg-danger-500 focus:bg-danger-700 focus:ring-offset-danger-700 filament-page-button-action">
                    <span class="">{{ __('Delete') }}</span>
                </button>
            </form>
        </div>
    </header>
    <div class="grid grid-cols-1 lg:grid-cols-3 filament-forms-component-container gap-6">
        <div class="col-span-full lg:col-span-2">
            @include('crm.admin.clients.elements.edit-form')
        </div>
        <div class="col-span-full lg:col-span-2">
            <div class="filament-forms-card-component p-6 bg-white rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                <div class="grid grid-cols-1      filament-forms-component-container gap-6">
                    <div class="col-span-1">
                        <div class="filament-forms-field-wrapper">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                    <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.created_at">
                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">{{ __('Created at') }}</span>
                                    </label>
                                </div>
                                <div class="filament-forms-placeholder-component">
                                    {{ $client->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-span-1">
                        <div class="filament-forms-field-wrapper">
                            <div class="space-y-2">
                                <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                    <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="data.updated_at">
                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">{{ __('Last modified et') }}</span>
                                    </label>
                                </div>
                                <div class="filament-forms-placeholder-component">
                                    {{ $client->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-crm.admin.main-layout>
