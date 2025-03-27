<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl font-bold">Role Details: {{ $role->name }}</h1>
                        <div class="space-x-2">
                            <a href="{{ route('roles.edit', $role) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Edit Role
                            </a>
                            <a href="{{ route('roles.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to Roles
                            </a>
                        </div>
                    </div>

                    <div class="grid gap-6 md:grid-cols-2">
                        <div>
                            <h2 class="mb-4 text-xl font-semibold">Role Information</h2>
                            <div class="p-4 bg-gray-100 rounded-lg">
                                <p class="mb-2"><strong>Name:</strong> {{ $role->name }}</p>
                                <p><strong>Description:</strong> {{ $role->description ?? 'No description' }}</p>
                            </div>
                        </div>

                        <div>
                            <h2 class="mb-4 text-xl font-semibold">Permissions</h2>
                            <div class="p-4 bg-gray-100 rounded-lg">
                                @forelse($role->permissions as $permission)
                                    <span class="inline-block px-2 py-1 mb-1 mr-1 text-xs text-indigo-800 bg-indigo-100 rounded-full">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <p class="text-gray-500">No permissions assigned</p>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="mt-6">
                        <h2 class="mb-4 text-xl font-semibold">Users with this Role</h2>
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap">
                                <thead>
                                    <tr class="font-bold text-left bg-gray-100">
                                        <th class="px-4 py-3">Name</th>
                                        <th class="px-4 py-3">Email</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                        <tr class="border-b hover:bg-gray-100">
                                            <td class="px-4 py-3">{{ $user->name }}</td>
                                            <td class="px-4 py-3">{{ $user->email }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="2" class="px-4 py-3 text-center text-gray-500">
                                                No users with this role
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
