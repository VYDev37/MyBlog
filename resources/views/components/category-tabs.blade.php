<div class="p-4 text-gray-900 dark:text-gray-100 transition-colors">
    <ul class="flex flex-wrap text-sm font-medium text-center text-body items-center justify-center">
        <li class="me-2">
            <a href="/" class="{{ !request('category') ?
    "inline-block px-3 md:px-9 py-2 text-white rounded-base bg-blue-700 dark:bg-blue-600 rounded-lg active transition-colors" :
    "inline-block px-3 md:px-9 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-heading dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"}}" aria-current="page">
                All
            </a>
        </li>
        @foreach ($categories as $category)
            <li class="me-2">
                <a href="{{ route('post.categorize', ['category' => $category]) }}" class="{{ Route::currentRouteNamed('post.categorize') &&
            request('category')->id == $category->id ?
            "inline-block px-2 md:px-9 py-2 text-white rounded-base bg-blue-700 dark:bg-blue-600 rounded-lg active transition-colors" :
            "inline-block px-2 md:px-9 py-2 rounded-lg text-gray-600 dark:text-gray-400 hover:text-heading dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors"}}">
                    {{ $category->name }}
                </a>
            </li>
        @endforeach
    </ul>
</div>