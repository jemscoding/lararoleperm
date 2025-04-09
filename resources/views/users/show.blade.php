<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $user->name }}
            </h2>
            @if(auth()->id() == $user->id || auth()->user()->role == 'admin')
                <div class="flex space-x-2">
                    <a href="{{ route('users.edit', $user->id) }}"
                       class="px-4 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                        Edit
                    </a>
                    <form action="{{ route('users.destroy', $user) }}" method="POST"
                          onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 text-white bg-red-500 rounded-md hover:bg-red-600">
                            Delete
                        </button>
                    </form>
                </div>
            @endif
        </div>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="prose max-w-none">
                        <p><strong>Email:</strong> {{ $user->email }} </p>
                        <p><strong>Joined:</strong> {{ $user->created_at->format('M d, Y') }}</p>

                        <div class="pt-4 mt-6 text-gray-600 border-t">
                            <div class="flex items-center justify-between">
                                <div>
                                    <strong>Roles:</strong>
                                    @foreach($user->roles as $role)
                                    <span class="inline-block px-2 py-1 text-xs text-gray-800 bg-gray-100 rounded">
                                        {{ $role->name }}
                                    </span>
                                    @endforeach
                                    @foreach($user->permissions as $permission)
                                    <span class="inline-block px-2 py-1 text-xs text-gray-800 bg-gray-100 rounded">
                                        {{ $permission->name }}
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
