<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl font-bold">Permission Details: {{ $permission->name }}</h1>
                        <div class="space-x-2">
                            <a href="{{ route('permissions.edit', $permission) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Edit Permission
                            </a>
                            <a href="{{ route('permissions.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to Permissions
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <h2 class="mb-4 text-xl font-semibold">Permission Information</h2>
                            <div class="p-4 bg-gray-100 rounded-lg">
                                <p class="mb-2"><strong>Name:</strong> {{ $permission->name }}</p>
                                <p class="mb-2"><strong>Guard:</strong>
                                    <span class="inline-block px-2 py-1 text-xs text-gray-800 bg-gray-200 rounded">
                                        {{ $permission->guard_name }}
                                    </span>
                                </p>
                                <p><strong>Description:</strong> {{ $permission->description ?? 'No description' }}</p>
                            </div>
                        </div>

                        <div>
                            <h2 class="mb-4 text-xl font-semibold">Roles with this Permission</h2>
                            <div class="p-4 bg-gray-100 rounded-lg">
                                @forelse($roles as $role)
                                    <span class="inline-block px-2 py-1 mb-1 mr-1 text-xs text-indigo-800 bg-indigo-100 rounded-full">
                                        {{ $role->name }}
                                    </span>
                                @empty
                                    <p class="text-gray-500">No roles assigned</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
