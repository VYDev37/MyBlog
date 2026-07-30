<div class="py-4">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-8 transition-colors duration-300">
            <form method="POST"
                action="{{ $post->exists ? route('post.update', compact('post')) : route('post.store') }}"
                enctype="multipart/form-data">
                @csrf
                @if($post->exists)
                    @method('PUT')
                @endif
                <!-- Title -->
                <div>
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" class="block mt-1 w-full p-1" type="text" name="title"
                        :value="old('title', $post->title)" required autofocus />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <!-- Content -->
                <div class="mt-4">
                    <x-input-label for="content" :value="__('Content')" />
                    <x-tiptap-text-editor :value="old('content', $post->content)" />
                    <x-input-error :messages="$errors->get('content')" class="mt-2" />
                </div>

                <!-- Image -->
                <div class="mt-4" x-data="{ previewUrl: '{{ $post->image ? $post->imageUrl() : '' }}' }">
                    <x-input-label for="image" :value="__('Cover Image')" />

                    <template x-if="previewUrl">
                        <button x-on:click.prevent="$dispatch('open-image-zoom', { url: previewUrl, alt: 'Preview' })"
                            class="mt-2 mb-4 relative w-full sm:w-1/2 md:w-1/3 aspect-video bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden border border-gray-200 dark:border-gray-600 shadow-sm transition-colors cursor-zoom-in text-left focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900 block">
                            <img :src="previewUrl" alt="Preview" class="absolute inset-0 w-full h-full object-cover">
                        </button>
                    </template>

                    <input id="image" name="image" accept=".jpg,.png,.jpeg,.svg,.gif,.webp,.heic,.heif,.avif,.bmp"
                        x-on:change="previewUrl = URL.createObjectURL($event.target.files[0])"
                        class="cursor-pointer bg-neutral-secondary-medium dark:bg-gray-900 border border-default-medium dark:border-gray-700 text-heading dark:text-gray-300 text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body transition-colors"
                        aria-describedby="file_input_help" type="file">
                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG,
                        WEBP, JPEG, HEIC, HEIF, AVIF, BMP, or GIF (MAX. 800x400px).</p>
                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                </div>

                <!-- Categories -->
                <div class="mt-4">
                    <x-input-label :value="__('Categories')" />
                    <div class="flex flex-wrap gap-2 mt-2">
                        @foreach ($categories as $cat)
                            <label class="relative cursor-pointer">
                                <input type="checkbox" name="categories[]" value="{{ $cat->id }}" 
                                    class="peer sr-only"
                                    @checked(in_array($cat->id, old('categories', $post->categories ? $post->categories->pluck('id')->toArray() : [])))>
                                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium transition-all duration-200 border select-none 
                                    peer-checked:bg-indigo-600 peer-checked:border-indigo-600 peer-checked:text-white peer-checked:shadow-md 
                                    bg-white dark:bg-gray-800 border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 
                                    peer-hover:bg-gray-50 dark:peer-hover:bg-gray-700 
                                    peer-focus-visible:ring-2 peer-focus-visible:ring-indigo-500 peer-focus-visible:ring-offset-2 dark:peer-focus-visible:ring-offset-gray-800">
                                    {{ $cat->name }}
                                </span>
                            </label>
                        @endforeach
                    </div>
                    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">Click the categories you would like to choose.</p>
                    <x-input-error :messages="$errors->get('categories')" class="mt-2" />
                </div>
                <x-primary-button class="mt-4">Submit</x-primary-button>
            </form>
        </div>
    </div>
</div>