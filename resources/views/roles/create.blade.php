<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-6 text-3xl font-bold">Create New Role</h1>

                    <form action="{{ route('roles.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Role Name')" />
                            <x-text-input
                                id="name"
                                name="name"
                                type="text"
                                class="block w-full mt-1"
                                :value="old('name')"
                                required
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>



                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-700">
                                Assign Permissions
                            </label>
                            <div class="grid gap-4 md:grid-cols-3">
                                @foreach($permissions as $permission)
                                    <div class="flex items-center">
                                        <input
                                            type="checkbox"
                                            name="permissions[]"
                                            value="{{ $permission->name }}"
                                            id="permission-{{ $permission->id }}"
                                            class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"
                                        >
                                        <label
                                            for="permission-{{ $permission->id }}"
                                            class="block ml-2 text-sm text-gray-900"
                                        >
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('Create Role') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
