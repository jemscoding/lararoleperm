<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ __('Blog Posts') }}
            </h2>
            @can('create posts')
            <a href="{{ route('posts.create') }}" class="px-4 py-2 text-white bg-blue-500 rounded-md hover:bg-blue-600">
                {{ __('Create New Post') }}
            </a>
            @endcan
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
                    @if($posts->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Title
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Author
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Categories
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Tags
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Published Date
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-left text-gray-500 uppercase">
                                            Status
                                        </th>
                                        <th scope="col" class="px-6 py-3 text-xs font-medium tracking-wider text-right text-gray-500 uppercase">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($posts as $post)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($post->ft_image)
                                                        <div class="flex-shrink-0 w-10 h-10 mr-4">
                                                            <img class="object-cover w-10 h-10 rounded-lg"
                                                                 src="{{ Storage::url($post->ft_image) }}"
                                                                 alt="{{ $post->title }}">
                                                        </div>
                                                    @endif
                                                    <a href="{{ route('posts.show', $post) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">
                                                        {{ Str::limit($post->title, 50) }}
                                                    </a>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-900">{{ $post->author->name }}</div>
                                            </td>
                                            <td class="px-6 py-4">
                                                @foreach ($post->categories as $category)
                                                    <span class="inline-block px-2 py-1 mb-1 mr-1 text-xs bg-blue-100 rounded-full text-blue-800">
                                                        {{ $category->category_name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td class="px-6 py-4">
                                            @if ($post->tags->count() > 0)
                                                @foreach ($post->tags as $tag)
                                                    <span class="inline-block px-2 py-1 mb-1 mr-1 text-xs bg-indigo-100 rounded-full text-neutral-800">
                                                        {{ $tag->tag_name }}
                                                    </span>
                                                @endforeach
                                            @else
                                                <span><strong>Tags:</strong> No tags assigned</span>
                                            @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm text-gray-500">
                                                    {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not Published' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                            {{ $post->is_published ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                                    {{ $post->is_published ? 'Published' : 'Draft' }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 text-sm font-medium text-right whitespace-nowrap">
                                                    <div class="flex justify-end space-x-2">
                                                        @can('view posts')
                                                        <a href="{{ route('posts.show', $post->slug) }}"
                                                           class="text-blue-500 hover:text-blue-700">
                                                            View
                                                        </a>
                                                        @endcan
                                                        @can('update posts')
                                                        <a href="{{ route('posts.edit', $post->slug) }}"
                                                           class="text-yellow-500 hover:text-yellow-700">
                                                            Edit
                                                        </a>
                                                        @endcan
                                                        @can('delete posts')
                                                        <form action="{{ route('posts.destroy', $post->slug) }}"
                                                              method="POST"
                                                              onsubmit="return confirm('Are you sure you want to delete this post?');"
                                                              class="inline">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit"
                                                                    class="text-red-500 hover:text-red-700">
                                                                Delete
                                                            </button>
                                                        </form>
                                                        @endcan
                                                    </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-6">
                            {{ $posts->links() }}
                        </div>
                    @else
                        <p class="text-center text-gray-500">No posts found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
