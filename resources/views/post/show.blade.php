<x-app-layout>
    <div class="py-6 sm:py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div
                class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-2xl sm:rounded-3xl border border-gray-100 dark:border-gray-700 transition-colors duration-300">
                <div class="p-6 sm:p-10 lg:p-12">
                    <!-- Title -->
                    <h1
                        class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 dark:text-gray-100 tracking-tight leading-tight mb-6 sm:mb-8">
                        {{ $post->title }}
                    </h1>

                    <!-- Profile & Meta Info -->
                    <div
                        class="flex items-center gap-4 mb-4 sm:mb-6 pb-4 sm:pb-5 border-b border-gray-100 dark:border-gray-700">
                        @if ($post->user->profile)
                            <a href="{{ route('profile.show', ['user' => $post->user->username]) }}">
                                <img src="{{ $post->user->imageUrl() }}" alt="{{ $post->user->name }}"
                                    class="w-12 h-12 sm:w-14 sm:h-14 object-cover rounded-full shadow-sm ring-2 ring-gray-50">
                            </a>
                        @else
                            <div
                                class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-indigo-50 dark:bg-gray-700 text-indigo-500 dark:text-indigo-400 flex items-center justify-center ring-2 ring-gray-50 dark:ring-gray-700 shrink-0">
                                <svg class="w-7 h-7 sm:w-8 sm:h-8" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                        clip-rule="evenodd"></path>
                                </svg>
                            </div>
                        @endif

                        <div class="flex flex-col justify-center">
                            <a href="{{ route('profile.show', ['user' => $post->user->username]) }}"
                                class="text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 leading-snug hover:text-indigo-600 dark:hover:text-indigo-400 flex items-center gap-1.5 w-fit">
                                @if ($post->user->isAdmin())
                                    <span class="text-yellow-600 dark:text-yellow-500">{{ $post->user->name }}</span>
                                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-yellow-600 dark:text-yellow-500 shrink-0" fill="currentColor" viewBox="0 0 24 24" title="Verified Admin">
                                        <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm-1 15l-5-5 1.41-1.41L11 14.17l7.59-7.59L20 8l-9 9z"/>
                                    </svg>
                                @else
                                    {{ $post->user->name }}
                                @endif
                            </a>
                            <div
                                class="flex items-center flex-wrap gap-x-2 gap-y-1 mt-0.5 text-xs sm:text-sm text-gray-500 dark:text-gray-400 font-medium">
                                <span class="flex items-center gap-1 shrink-0">
                                    <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $post->readTime() }} min read
                                </span>
                                <span class="hidden sm:inline text-gray-300">&middot;</span>
                                <span class="flex items-center gap-1 shrink-0">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    {{ $post->created_at->format('M d, Y') }}
                                </span>
                            </div>
                        </div>

                        @if (Auth::id() === $post->user_id)
                            <div class="ms-auto">
                                <x-dropdown align="right" width="48">
                                    <x-slot name="trigger">
                                        <button
                                            class="p-2 text-gray-400 hover:text-gray-600 rounded-full hover:bg-gray-100 transition-colors">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                                <path fill-rule="evenodd"
                                                    d="M12 5.25a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM12 13.5a1.5 1.5 0 100-3 1.5 1.5 0 000 3zM12 21.75a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </x-slot>

                                    <x-slot name="content">
                                        <x-dropdown-link :href="route('post.edit', $post->id)">
                                            {{ __('Edit Post') }}
                                        </x-dropdown-link>

                                        <x-dropdown-link href="#" x-data=""
                                            x-on:click.prevent="$dispatch('open-modal', 'confirm-post-deletion')"
                                            class="text-red-600 hover:bg-red-50 focus:bg-red-50 focus:text-red-700">
                                            {{ __('Delete Post') }}
                                        </x-dropdown-link>
                                    </x-slot>
                                </x-dropdown>
                            </div>
                        @endif
                    </div>

                    <!-- Cover Image -->
                    @if($post->image)
                        <button x-data
                            x-on:click.prevent="$dispatch('open-image-zoom', { url: '{{ $post->imageUrl() }}', alt: '{{ $post->title }}' })"
                            class="block w-full relative aspect-video rounded-xl sm:rounded-2xl overflow-hidden shadow-lg border border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800 group mb-8 cursor-zoom-in text-left focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                            <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                                class="m-0 absolute inset-0 w-full h-full object-cover transition-transform duration-700 hover:scale-105">
                        </button>
                    @endif

                    <!-- Content begin -->
                    <div class="prose prose-lg dark:prose-invert max-w-none">
                        <div x-data x-init="
                                $el.querySelectorAll('img').forEach(img => {
                                    img.classList.add('cursor-zoom-in');
                                    img.addEventListener('click', (e) => {
                                        e.preventDefault();
                                        $dispatch('open-image-zoom', { url: img.src, alt: img.alt });
                                    });
                                });

                                $el.querySelectorAll('pre').forEach(pre => {
                                    const wrapper = document.createElement('div');
                                    wrapper.className = 'relative group mb-6 mt-4';
                                    pre.parentNode.insertBefore(wrapper, pre);

                                    pre.style.margin = '0';
                                    wrapper.appendChild(pre);

                                    const btn = document.createElement('button');
                                    btn.className = 'absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity p-2 rounded-md bg-gray-700/80 hover:bg-gray-600 text-gray-300 hover:text-white backdrop-blur-sm text-xs font-semibold flex items-center gap-1.5 focus:opacity-100';
                                    
                                    const iconCopy = `<svg class='w-4 h-4' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z'></path></svg>`;
                                    const iconCheck = `<svg class='w-4 h-4 text-green-400' fill='none' stroke='currentColor' viewBox='0 0 24 24'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7'></path></svg>`;
                                    
                                    btn.innerHTML = iconCopy + ' Copy';
                                    
                                    btn.addEventListener('click', () => {
                                        navigator.clipboard.writeText(pre.textContent);
                                        btn.innerHTML = iconCheck + ' Copied!';
                                        setTimeout(() => {
                                            btn.innerHTML = iconCopy + ' Copy';
                                        }, 2000);
                                    });
                                    
                                    wrapper.appendChild(btn);
                                });
                            "
                            class="text-base sm:text-lg text-gray-700 dark:text-gray-300 leading-relaxed tiptap-content">
                            {!! clean($post->content) !!}
                        </div>

                        <div class="mt-6 flex flex-wrap gap-2">
                            @foreach($post->categories as $category)
                                <div
                                    class="w-fit px-3 py-1 text-center rounded-full text-sm font-semibold text-gray-700 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 transition-colors">
                                    <span>{{ $category->name }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Back Button Navigation -->
            <div class="mt-6 sm:mt-8 flex justify-center pb-8">
                <a href="{{ route('dashboard') }}"
                    class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-indigo-600 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Posts
                </a>
            </div>
        </div>
    </div>

    <x-modal name="confirm-post-deletion" focusable>
        <form method="post" action="{{ route('post.destroy', $post->id) }}" class="p-6 bg-white dark:bg-gray-800">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this post?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Once this post is deleted, all of its resources and data will be permanently deleted. This action cannot be undone.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3 text-red-600">
                    {{ __('Delete Post') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>