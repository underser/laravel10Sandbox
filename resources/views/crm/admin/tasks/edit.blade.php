<x-crm.admin.main-layout :contentWrapClasses="'lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]'">
    <header class="filament-header space-y-2 items-start justify-between sm:flex sm:space-y-0 sm:space-x-4  sm:rtl:space-x-reverse sm:py-4">
        <div>
            <h1 class="filament-header-heading text-2xl font-bold tracking-tight">
                {{ __('Edit task :name', ['name' => $task->name]) }}
            </h1>
        </div>
    </header>
    <div class="filament-main-content flex-1 w-full px-4 mx-auto md:px-6 lg:px-8 max-w-7xl">
        @include('crm.admin.tasks.elements.edit-form')
    </div>
</x-crm.admin.main-layout>
