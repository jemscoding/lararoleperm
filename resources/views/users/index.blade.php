<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between mt-6">
            <h1 class="text-3xl font-bold text-gray-900">Users Management</h1>
            <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Create New User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="relative px-4 py-3 mb-4 text-green-700 bg-green-100 border border-green-400 rounded" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($users->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Email
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Roles
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <a href="{{ route('users.show', $user) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ Str::limit($user->name, 50) }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="px-6 py-4">

                                                @foreach ($user->roles as $role)
                                                    <span class="inline-block px-2 py-1 mb-1 mr-1 text-xs bg-blue-100 rounded-full text-blue-800">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                @if(auth()->id() == $user->id || auth()->user()->hasRole('admin'))
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('users.show', $user) }}" class="text-blue-500 hover:text-blue-700">
                                                            View
                                                        </a>
                                                        <a href="{{ route('users.edit', $user) }}" class="text-yellow-500 hover:text-yellow-700">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');" class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-500 hover:text-red-700">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500">No users found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
