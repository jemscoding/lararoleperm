<x-app-layout>
    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="mb-6 text-3xl font-bold">Create New Tags</h1>

                    <form action="{{ route('tags.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Tag Name')" />
                            <x-text-input
                                id="name"
                                name="tag_name"
                                type="text"
                                class="block w-full mt-1"
                                :value="old('tag_name')"
                                required
                                autofocus
                            />
                            <x-input-error :messages="$errors->get('tag_name')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-3">
                                {{ __('Create Tag') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
