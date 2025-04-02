<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                {{ $post->title }}
            </h2>
            @if(auth()->id() == $post->user_id)
                <div class="flex space-x-2">
                    <a href="{{ route('posts.edit', $post) }}"
                       class="px-4 py-2 text-white bg-yellow-500 rounded-md hover:bg-yellow-600">
                        Edit
                    </a>
                    <form action="{{ route('posts.destroy', $post) }}" method="POST"
                          onsubmit="return confirm('Are you sure?');">
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
                    @if($post->ft_image)
                        <img src="{{ Storage::url($post->ft_image) }}"
                             alt="{{ $post->title }}"
                             class="object-cover w-full mb-6 rounded-lg h-96">
                    @endif

                    <div class="prose max-w-none">
                        {!! $post->content !!}
                    </div>

                    <div class="pt-4 mt-6 text-gray-600 border-t">
                        <div class="flex items-center justify-between">
                            <div>
                                <strong>Author:</strong> {{ $post->author->name }}
                                <br>
                                <strong>Published:</strong> {{ $post->published_at ? $post->published_at->format('M d, Y') : 'Not published' }}
                                <br>
                                <strong>Categories:</strong>
                                @foreach($post->categories as $category)
                                <span class="inline-block px-2 py-1 text-xs text-gray-800 bg-gray-100 rounded">
                                    {{ $category->category_name }}
                                </span>

                                @endforeach
                                <br>
                                <strong>Tags:</strong>
                                @foreach($post->tags as $tag)
                                    <span class="inline-block px-2 py-1 text-xs text-gray-800 bg-gray-100 rounded">
                                        {{ $tag->tag_name }}
                                    </span>
                                     &nbsp;
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
