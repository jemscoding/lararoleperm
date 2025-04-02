<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex items-center justify-between mb-6">
                        <h1 class="text-3xl font-bold">Category Details: {{ $category->category_name }}</h1>
                        <div class="space-x-2">
                            <a href="{{ route('categories.edit', $category) }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-indigo-600 border border-transparent rounded-md hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                Edit Categories
                            </a>
                            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                                Back to Categories
                            </a>
                        </div>
                    </div>

                    <div class="">
                        <div>
                            <h2 class="mb-4 text-xl font-semibold">Category Information</h2>
                            <div class="p-4 bg-gray-100 rounded-lg">
                                <p class="mb-2"><strong>Name:</strong> {{ $category->category_name }}</p>
                                <p class="mb-2"><strong>Slug:</strong>
                                    <span class="inline-block px-2 py-1 text-xs text-gray-800 bg-gray-200 rounded">
                                        {{ $category->category_slug ?? 'No slug' }}
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
