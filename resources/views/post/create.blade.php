<x-app-layout>
    <div class="py-4">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-8">
                <form method="POST" action="{{ route('post.store') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- Title -->
                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full p-1" type="title" name="title"
                            :value="old('title')" required autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <!-- Content -->
                    <div class="mt-4">
                        <x-input-label for="content" :value="__('Content')" />
                        <x-input-textarea id="content" class="block mt-1 w-full" type="content" name="content"
                            :value="old('content')" required autofocus />
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <!-- Image -->
                    <div class="mt-4" x-data="{ previewUrl: '' }">
                        <x-input-label for="image" :value="__('Image')" />
                        
                        <!-- Image Preview -->
                        <template x-if="previewUrl">
                            <div class="mt-2 mb-4 relative w-full sm:w-1/2 md:w-1/3 aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                <img :src="previewUrl" alt="Preview" class="absolute inset-0 w-full h-full object-cover">
                            </div>
                        </template>

                        <input id="image" name="image" accept=".jpg,.png,.jpeg,.svg,.gif,.webp,.heic,.heif,.avif,.bmp"
                            x-on:change="previewUrl = URL.createObjectURL($event.target.files[0])"
                            class="cursor-pointer bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                            aria-describedby="file_input_help" type="file">
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-300" id="file_input_help">SVG, PNG, JPG,
                            WEBP, JPEG, HEIC, HEIF, AVIF, BMP, or GIF (MAX. 800x400px).</p>
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <!-- Category -->
                    <div class="mt-4">
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select id="category_id" name="category_id"
                            class="block w-full px-3 py-2.5 bg-white border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand shadow-xs placeholder:text-body">
                            <option value="">Select a category</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>
                    <x-primary-button class="mt-4">Submit</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>