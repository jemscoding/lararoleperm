<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Edit User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form action="{{ route('users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Name Field -->
                        <div class="mb-4">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" name="name" type="text" class="block w-full mt-1"
                                :value="old('name', $user->name)" required autofocus />
                            <x-input-error class="mt-2" :messages="$errors->get('name')" />
                        </div>

                        <!-- Email Field -->
                        <div class="mb-4">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" name="email" type="email" class="block w-full mt-1"
                                :value="old('email', $user->email)" required />
                            <x-input-error class="mt-2" :messages="$errors->get('email')" />
                        </div>

                        <!-- Password Field (Optional) -->
                        <div class="mb-4">
                            <x-input-label for="password" :value="__('New Password (leave blank to keep current)')" />
                            <x-text-input id="password" name="password" type="password" class="block w-full mt-1" />
                            <x-input-error class="mt-2" :messages="$errors->get('password')" />
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="mb-4">
                            <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                            <x-text-input id="password_confirmation" name="password_confirmation" type="password"
                                class="block w-full mt-1" />
                            <x-input-error class="mt-2" :messages="$errors->get('password_confirmation')" />
                        </div>

                        <!-- Role Selection (Dropdown) -->
                        <div class="mb-4">
                            <x-input-label for="role" :value="__('Role')" />
                            <select id="role" name="role"
                                    class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="" disabled selected hidden>{{ __('Select a Role') }}</option>
                                @foreach ($roles as $role)
                                <option value="{{ $role->name }}" {{ $user->hasRole($role->name) ? 'selected' : '' }}>
                                    {{ ucfirst($role->name) }}
                                </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('role')" />
                        </div>

                        <!-- Submit Button -->
                        <div class="flex items-center gap-4">
                            <x-primary-button>{{ __('Update User') }}</x-primary-button>

                            <a href="{{ route('users.index') }}"
                                class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-gray-700 uppercase transition duration-150 ease-in-out bg-white border border-gray-300 rounded-md shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25">
                                {{ __('Cancel') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
