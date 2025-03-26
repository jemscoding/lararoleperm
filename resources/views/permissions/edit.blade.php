<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="p-6 overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <h1 class="mb-6 text-2xl font-bold">Edit Permission: {{ $permission->name }}</h1>

                <form action="{{ route('permissions.update', $permission) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="name" :value="__('Permission Name')" />
                        <x-text-input
                            id="name"
                            name="name"
                            type="text"
                            class="block w-full mt-1"
                            :value="old('name', $permission->name)"
                            required
                        />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-700">
                            Assign to Roles
                        </label>
                        <div class="grid grid-cols-3 gap-4">
                            @foreach($roles as $role)
                                <div class="flex items-center">
                                    <input
                                        type="checkbox"
                                        name="roles[]"
                                        value="{{ $role->name }}"
                                        id="role-{{ $role->id }}"
                                        class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                        {{ $role->permissions->contains('name', $permission->name) ? 'checked' : '' }}
                                    >
                                    <label
                                        for="role-{{ $role->id }}"
                                        class="block ml-2 text-sm text-gray-900"
                                    >
                                        {{ $role->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <x-input-label for="guard_name" :value="__('Guard Name')" />
                        <select
                            id="guard_name"
                            name="guard_name"
                            class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                        >
                            <option value="web" {{ $permission->guard_name == 'web' ? 'selected' : '' }}>Web</option>
                            <option value="api" {{ $permission->guard_name == 'api' ? 'selected' : '' }}>API</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <x-primary-button class="ml-3">
                            {{ __('Update Permission') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
