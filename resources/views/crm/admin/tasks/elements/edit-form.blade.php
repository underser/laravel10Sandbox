<form method="POST" action="{{ route('tasks.update', $task) }}" class="filament-form space-y-6" >
    @csrf
    @method('PUT')
    <div class="grid grid-cols-1 filament-forms-component-container gap-6">
        <div class="col-span-full">
            <div>
                <div class="grid grid-cols-1 filament-forms-component-container gap-6">
                    <div class="col-span-full lg:col-span-3">
                        <div class="filament-forms-card-component p-6 bg-white rounded-xl border border-gray-300 dark:border-gray-600 dark:bg-gray-800">
                            <div class="grid grid-cols-1 filament-forms-component-container gap-6">
                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="title">
                                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                            {{ __('Name') }}
                                                            <span class="whitespace-nowrap">
                                                                <sup class="font-medium text-danger-700 dark:text-danger-400">*</sup>
                                                                @error('title')
                                                                    <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                                @enderror
                                                            </span>
                                                        </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <input type="text" value="{{ $task->title }}" id="title" name="title" max="50" required="" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="project_id">
                                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                    {{ __('Assigned to Project') }}
                                                    <span class="whitespace-nowrap">
                                                        @error('project_id')
                                                            <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                        @enderror
                                                    </span>
                                                </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <select name="project_id" id="project_id" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                        @foreach($projects as $project)
                                                            <option value="{{ $project->id }}" @selected($project->id === $task->project->id)>{{ $project->title }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="description">
                                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                            {{ __('Description') }}
                                                            <span class="whitespace-nowrap">
                                                                @error('description')
                                                                    <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                                @enderror
                                                            </span>
                                                        </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <textarea id="description" name="description" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                        {{ $task->description }}
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="estimation">
                                                        <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                            {{ __('Estimation') }}
                                                            <span class="whitespace-nowrap">
                                                                @error('estimation')
                                                                    <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                                @enderror
                                                            </span>
                                                        </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <input type="number" value="{{ $task->estimation }}" id="estimation" name="estimation" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="user_id">
                                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                    {{ __('Assigned To') }}
                                                    <span class="whitespace-nowrap">
                                                        @error('user_id')
                                                            <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                        @enderror
                                                    </span>
                                                </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <select name="user_id" id="user_id" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                        @foreach($users as $user)
                                                            <option value="{{ $user->id }}" @selected($user->id === $task->user->id)>{{ $user->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-span-1">
                                    <div class="filament-forms-field-wrapper">
                                        <div class="space-y-2">
                                            <div class="flex items-center justify-between space-x-2 rtl:space-x-reverse">
                                                <label class="filament-forms-field-wrapper-label inline-flex items-center space-x-3 rtl:space-x-reverse" for="status_id">
                                                <span class="text-sm font-medium leading-4 text-gray-700 dark:text-gray-300">
                                                    {{ __('Status') }}
                                                    <span class="whitespace-nowrap">
                                                        @error('status_id')
                                                            <sup class="font-medium text-danger-700 dark:text-danger-400">{{ $message }}</sup>
                                                        @enderror
                                                    </span>
                                                </span>
                                                </label>
                                            </div>
                                            <div class="filament-forms-text-input-component flex items-center space-x-2 rtl:space-x-reverse group">
                                                <div class="flex-1">
                                                    <select name="task_status_id" id="status_id" class="filament-forms-input block w-full transition duration-75 rounded-lg shadow-sm outline-none focus:ring-1 focus:ring-inset disabled:opacity-70 dark:bg-gray-700 dark:text-white border-gray-300 focus:border-primary-500 focus:ring-primary-500 dark:border-gray-600 dark:focus:border-primary-500">
                                                        @foreach($statuses as $status)
                                                            <option value="{{ $status->id }}" @selected($status->id === $task->status->id)>{{ $status->status }}</option>
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
                {{ __('Save changes') }}
            </button>
            <a href="{{ route('tasks.index') }}" class="filament-button filament-button-size-md inline-flex items-center justify-center py-1 gap-1 font-medium rounded-lg border transition-colors outline-none focus:ring-offset-2 focus:ring-2 focus:ring-inset dark:focus:ring-offset-0 min-h-[2.25rem] px-4 text-sm text-gray-800 bg-white border-gray-300 hover:bg-gray-50 focus:ring-primary-600 focus:text-primary-600 focus:bg-primary-50 focus:border-primary-600 dark:bg-gray-800 dark:hover:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:text-gray-200 dark:focus:text-primary-400 dark:focus:border-primary-400 dark:focus:bg-gray-800 filament-page-button-action">
                {{ __('Cancel') }}
            </a>
        </div>
    </div>
</form>
