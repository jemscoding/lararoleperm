<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Blog Tags') }}
            </h2>
            <a href="{{ route('tags.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                {{ __('Create New Tags') }}
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
                    @if($tags->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Slug
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($tags as $tag)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <a href="{{ route('tags.show', $tag) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ Str::limit($tag->tag_name, 50) }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="inline-block px-2 py-1 mb-1 mr-1 text-xs bg-indigo-100 rounded-full text-neutral-800">
                                                    {{ $tag->tag_slug }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <div class="flex justify-end space-x-2">
                                                        <a href="{{ route('tags.show', $tag) }}"
                                                           class="text-blue-500 hover:text-blue-700">
                                                            View
                                                        </a>
                                                        <a href="{{ route('tags.edit', $tag) }}"
                                                           class="text-yellow-500 hover:text-yellow-700">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('tags.destroy', $tag) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this tag?');"
                                                              class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="text-red-500 hover:text-red-700">
                                                                Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-gray-500">No tag found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
