<article class="flex items-start gap-4 sm:gap-6 group py-4 sm:py-6 border-b border-gray-100 last:border-0">
    <!-- Content Section -->
    <div class="flex-1 min-w-0 flex flex-col justify-center">
        <!-- Author Info -->
        <div class="flex items-center gap-2 mb-2 sm:mb-3">
            <img src="{{ $post->user->imageUrl() }}" alt="{{ $post->user->name }}"
                class="w-5 h-5 sm:w-6 sm:h-6 rounded-full object-cover ring-1 ring-gray-100">
            <div class="text-xs sm:text-sm text-gray-700 font-medium flex items-center gap-1.5 truncate">
                <a href="{{ route('profile.show', ['user' => $post->user->username]) }}"
                    class="truncate hover:text-gray-900">{{ $post->user->name }}
                </a>
                <span class="text-gray-400 shrink-0">&middot;</span>
                <span class="text-gray-500 shrink-0">{{ $post->created_at->format('M d, Y') }}</span>
            </div>
        </div>

        <!-- Title & Excerpt -->
        <a href="{{ route('post.show', ['user' => $post->user->username, 'post' => $post->slug]) }}"
            class="block group-hover:opacity-90 transition-opacity">
            <h2
                class="text-lg sm:text-xl md:text-2xl font-bold tracking-tight text-gray-900 mb-1.5 sm:mb-2 line-clamp-2 leading-snug">
                {{ $post->title }}
            </h2>
            <p
                class="text-gray-600 mb-3 sm:mb-4 line-clamp-2 sm:line-clamp-3 text-sm sm:text-base leading-relaxed hidden sm:block">
                {{ Str::limit(strip_tags($post->content), 200) }}
            </p>
            <p class="text-gray-600 mb-3 line-clamp-2 text-sm leading-relaxed sm:hidden">
                {{ Str::limit(strip_tags($post->content), 100) }}
            </p>
        </a>

        <!-- Footer Meta -->
        <div class="flex items-center justify-between mt-auto">
            <div class="flex items-center gap-0.5 text-xs sm:text-sm text-gray-500">
                @if($post->category)
                    <span
                        class="inline-flex px-2 py-1 items-center rounded-full bg-gray-200 text-gray-600 font-medium text-[10px] sm:text-xs">
                        {{ $post->category->name }}
                    </span>
                    <span class="text-gray-300 hidden sm:inline">&middot;</span>
                @endif
                <span class="shrink-0 lg:mb-0.25">{{ $post->readTime() }} min read</span>
            </div>
        </div>
    </div>

    <!-- Image Section (Fixed right side thumbnail) -->
    <div class="shrink-0 flex items-center pt-1 sm:pt-2 md:pt-0">
        <a href="{{ route('post.show', ['user' => $post->user->username, 'post' => $post->slug]) }}"
            class="block relative w-20 h-20 sm:w-28 sm:h-28 md:w-36 md:h-36 overflow-hidden bg-gray-50 rounded-lg sm:rounded-xl shrink-0">
            @if($post->image)
                <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"
                    class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
            @else
                <div class="absolute inset-0 bg-gradient-to-br from-gray-50 to-gray-200 flex items-center justify-center">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                </div>
            @endif
        </a>
    </div>
</article>