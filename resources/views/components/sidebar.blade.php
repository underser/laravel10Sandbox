<aside class="filament-sidebar fixed inset-y-0 left-0 z-20 flex h-screen w-[var(--sidebar-width)] flex-col overflow-hidden bg-white transition-all rtl:left-auto rtl:right-0 lg:z-0 lg:border-r rtl:lg:border-l rtl:lg:border-r-0 dark:bg-gray-800 dark:border-gray-700 filament-sidebar-open translate-x-0 max-w-[20em] shadow-2xl lg:max-w-[var(--sidebar-width)]" >
    <nav class="flex-1 py-6 overflow-x-hidden overflow-y-auto filament-sidebar-nav">
        <ul class="px-6 space-y-6">
            <li class="h-16">
                <x-application-logo/>
            </li>
            <li class="filament-sidebar-group">
                <ul class="text-sm space-y-1 -mx-3 mt-2">
                    <li class="filament-sidebar-item overflow-hidden">
                        <x-crm.nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard*')">
                            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            <div class="flex flex-1"><span>{{ __('Dashboard') }}</span></div>
                        </x-crm.nav-link>
                    </li>
                    <li class="filament-sidebar-item overflow-hidden filament-sidebar-item-active">
                        <x-crm.nav-link href="{{ route('customers') }}" :active="request()->routeIs('customers*')">
                            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            <div class="flex flex-1"><span>{{ __('Customers') }}</span></div>
                        </x-crm.nav-link>
                    </li>
                    <li class="filament-sidebar-item overflow-hidden filament-sidebar-item-active">
                        <x-crm.nav-link href="{{ route('clients') }}" :active="request()->routeIs('clients*')">
                            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 4v12l-4-2-4 2V4M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            <div class="flex flex-1"><span>{{ __('Clients') }}</span></div>
                        </x-crm.nav-link>
                    </li>
                    <li class="filament-sidebar-item overflow-hidden filament-sidebar-item-active">
                        <x-crm.nav-link href="{{ route('projects') }}" :active="request()->routeIs('projects*')">
                            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            <div class="flex flex-1"><span>{{ __('Projects') }}</span></div>
                        </x-crm.nav-link>
                    </li>
                    <li class="filament-sidebar-item overflow-hidden filament-sidebar-item-active">
                        <x-crm.nav-link href="{{ route('tasks') }}" :active="request()->routeIs('tasks*')">
                            <svg class="h-5 w-5 shrink-0" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <div class="flex flex-1"><span>{{ __('Tasks') }}</span></div>
                        </x-crm.nav-link>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
</aside>

