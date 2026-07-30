<article
    class="flex items-start gap-4 sm:gap-6 group py-4 sm:py-6 border-b border-gray-100 dark:border-gray-800 last:border-0 transition-colors">
    <!-- Content Section -->
    <div class="flex-1 min-w-0 flex flex-col justify-center">
        <!-- Author Info -->
        <div class="flex items-center gap-2 mb-2 sm:mb-3">
        @if ($post->user->profile)
            <img src="{{ $post->user->imageUrl() }}" alt="{{ $post->user->name }}"
                class="w-5 h-5 sm:w-6 sm:h-6 rounded-full object-cover ring-1 ring-gray-100 dark:ring-gray-700">
        @else
            <div class="relative w-5 h-5 sm:w-6 sm:h-6 overflow-hidden bg-gray-100 dark:bg-gray-700 rounded-full ring-1 ring-gray-200 dark:ring-gray-600">
                <svg class="absolute w-7 h-7 sm:w-8 sm:h-8 text-gray-400 -left-1 top-0" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                        clip-rule="evenodd">
                    </path>
                </svg>
            </div>
        @endif
            <div
                class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 font-medium flex items-center gap-1.5 truncate">
                <a href="{{ route('profile.show', ['user' => $post->user->username]) }}"
                    class="truncate hover:text-gray-900 dark:hover:text-white">{{ $post->user->name }}
                </a>
                <span class="text-gray-400 dark:text-gray-500 shrink-0">&middot;</span>
                <span class="text-gray-500 dark:text-gray-400 shrink-0">{{ $post->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        <!-- Title & Excerpt -->
        <a href="{{ route('post.show', ['user' => $post->user->username, 'post' => $post->slug]) }}"
            class="block group-hover:opacity-90 transition-opacity">
            <h2
                class="text-lg sm:text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100 mb-1.5 sm:mb-2 line-clamp-2 leading-snug">
                {{ $post->title }}
            </h2>
            <p
                class="text-gray-600 dark:text-gray-400 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-3 text-sm sm:text-base leading-relaxed hidden sm:block">
                {{ Str::limit(html_entity_decode(strip_tags(str_replace(['</p>', '<br>', '</h1>', '</h2>', '</h3>', '</li>', '</div>'], ' ', $post->content))), 150) }}
            </p>
            <p class="text-gray-600 dark:text-gray-400 mb-3 line-clamp-2 text-sm leading-relaxed sm:hidden">
                {{ Str::limit(html_entity_decode(strip_tags(str_replace(['</p>', '<br>', '</h1>', '</h2>', '</h3>', '</li>', '</div>'], ' ', $post->content))), 100) }}
            </p>

        </a>

        <!-- Footer Meta -->
        <div class="flex items-center justify-between mt-auto">
            <div class="flex items-center gap-0.5 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                @if($post->categories->isNotEmpty())
                    <div class="flex flex-wrap gap-1 mr-1">
                        @foreach($post->categories as $category)
                            <span
                                class="inline-flex px-2 py-1 items-center rounded-full bg-gray-200 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-medium text-[10px] sm:text-xs">
                                {{ $category->name }}
                            </span>
                        @endforeach
                    </div>
                    <span class="text-gray-300 dark:text-gray-600 hidden sm:inline">&middot;</span>
                @endif
                <span class="shrink-0 lg:mb-0.25">{{ $post->readTime() }} min read</span>
            </div>
        </div>
    </div>

    <!-- Image Section (Fixed right side thumbnail) -->
    <div class="shrink-0 flex items-center pt-1 sm:pt-2 md:pt-0">
        @if($post->image)
            <button x-data x-on:click.prevent="$dispatch('open-image-zoom', { url: '{{ $post->imageUrl() }}', alt: '{{ $post->title }}' })"
                class="block relative w-20 h-20 sm:w-28 sm:h-28 md:w-36 md:h-36 overflow-hidden bg-gray-50 dark:bg-gray-800 rounded-lg sm:rounded-xl shrink-0 cursor-zoom-in text-left">
                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            </button>
        @else
            <a href="{{ route('post.show', ['user' => $post->user->username, 'post' => $post->slug]) }}"
                class="block relative w-20 h-20 sm:w-28 sm:h-28 md:w-36 md:h-36 overflow-hidden bg-gray-50 dark:bg-gray-800 rounded-lg sm:rounded-xl shrink-0">
                <div
                    class="absolute inset-0 bg-gradient-to-br from-gray-50 dark:from-gray-800 to-gray-200 dark:to-gray-700 flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-300 dark:text-gray-600" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            </a>
        @endif
    </div>
</article>