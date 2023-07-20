<form method="POST" action="{{ route('customers.update', $customer) }}" class="filament-form space-y-6" >
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 filament-forms-component-container gap-6">
        <div class="col-span-full">
            <div>
                <div class="grid grid-cols-1 lg:grid-cols-3 filament-forms-component-container gap-6">
                    <div class="col-span-full lg:col-span-3">
                        <div class="filament-forms-card-component p-6 bg-white rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                            <div class="grid grid-cols-1 lg:grid-cols-2 filament-forms-component-container gap-6">
                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="name">
                                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                            Name
                                                            <span class="whitespace-nowrap">
                                                                <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
                                                                @error('name')
                                                                    <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                                @enderror
                                                            </span>
                                                        </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <input type="text" value="{{ $customer->name }}" id="name" name="name" max="50" required="" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="email">
                                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                            Email
                                                            <span class="whitespace-nowrap">
                                                                <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
                                                                @error('email')
                                                                    <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                                @enderror
                                                            </span>
                                                        </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <input type="text" value="{{ $customer->email }}" id="email" name="email" max="50" required="" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="phone">
                                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                            Phone
                                                            <span class="whitespace-nowrap">
                                                                @error('phone')
                                                                    <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                                @enderror
                                                            </span>
                                                        </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <input type="number" value="{{ $customer->phone }}" id="phone" name="phone" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="country">
                                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                            Country
                                                            <span class="whitespace-nowrap">
                                                                @error('country')
                                                                    <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                                @enderror
                                                            </span>
                                                        </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <select name="country_code" id="country" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                        @foreach($countries as $country)
                                                            <option value="{{ $country['code'] }}" @selected($customer->country_code === $country['code'])>{{ $country['name'] }}</option>
                                                        @endforeach
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
            </div>
        </div>
    </div>
    <div>
        <div class="filament-page-actions flex flex-wrap items-center gap-4 justify-start filament-form-actions">
            <button type="submit" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-white shadow focus:ring-white border-transparent bg-primary-600 hover:bg-primary-500 focus:bg-primary-700 focus:ring-offset-primary-700 filament-page-button-action">
                Save changes
            </button>
            <a class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-page-button-action" href="">
                Cancel
            </a>
        </div>
    </div>
</form>
