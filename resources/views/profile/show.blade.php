<x-app-layout>
    <div class="py-0 sm:py-8 lg:py-12" x-data="{ tab: 'posts' }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Unified Profile Card -->
            <div
                class="bg-white overflow-hidden sm:shadow-sm sm:rounded-2xl lg:rounded-3xl border-b sm:border border-gray-100 min-h-screen sm:min-h-0">
                <!-- Cover Image (Matched to Laravel Breeze light colors) -->
                <div class="h-32 sm:h-48 bg-gray-100 border-b border-gray-200 w-full object-cover">
                </div>

                <div class="px-4 sm:px-10 pb-0">
                    <!-- Profile Picture & Action Buttons -->
                    <div class="flex justify-between items-end -mt-12 sm:-mt-16 mb-4 sm:mb-6">
                        <div class="relative">
                            @if ($user->profile)
                                <img src="{{ $user->imageUrl() }}" alt="{{ $user->name }}"
                                    class="w-24 h-24 sm:w-32 sm:h-32 object-cover rounded-full shadow-md ring-4 ring-white bg-white">
                            @else
                                <div
                                    class="w-24 h-24 sm:w-32 sm:h-32 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center ring-4 ring-white shadow-md shrink-0 bg-white">
                                    <svg class="w-12 h-12 sm:w-16 sm:h-16" fill="currentColor" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="flex gap-2 sm:gap-3 mb-1 sm:mb-2">
                            @if (Auth::check() && Auth::id() === $user->id)
                                <a href="{{ route('profile.edit') }}"
                                    class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-semibold rounded-full hover:bg-gray-50 transition-colors shadow-sm">
                                    Edit Profile
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- User Info -->
                    <div>
                        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 tracking-tight">{{ $user->name }}</h1>
                        <p class="text-gray-500 font-medium text-sm sm:text-base mt-0.5">
                            {{ '@' . $user->username }}
                        </p>
                    </div>

                    <!-- Meta Details (simplified for the header) -->
                    <div class="flex items-center gap-x-4 gap-y-2 mt-4 text-sm text-gray-500 flex-wrap">
                        <span class="flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            Joined {{ $user->created_at->format('F Y') }}
                        </span>
                        <span class="flex items-center gap-1.5">
                            <span class="font-semibold text-gray-900">{{ $user->posts()->count() }}</span> Posts
                        </span>
                    </div>

                    <!-- Mini Navbar -->
                    <div class="mt-6 border-t border-gray-100">
                        <nav class="flex gap-6 sm:gap-8">
                            <button @click="tab = 'posts'"
                                :class="tab === 'posts' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 text-sm font-semibold border-b-2 transition-colors focus:outline-none">
                                Posts
                            </button>
                            <button @click="tab = 'about'"
                                :class="tab === 'about' ? 'border-gray-900 text-gray-900' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'"
                                class="py-4 text-sm font-semibold border-b-2 transition-colors focus:outline-none">
                                About
                            </button>
                        </nav>
                    </div>
                </div>

                <!-- Content Area (Integrated within the profile card) -->
                <div class="bg-gray-50 border-t border-gray-100 min-h-[400px]">
                    <!-- Posts Tab -->
                    <div x-show="tab === 'posts'" class="p-4 sm:p-8 lg:p-10"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        @if ($user->posts()->count() > 0)
                            <div class="space-y-4 sm:space-y-6">
                                @foreach ($user->posts()->latest()->get() as $post)
                                    <x-post-item :post="$post" />
                                @endforeach
                            </div>
                        @else
                            <div class="bg-white rounded-2xl border border-gray-100 p-8 sm:p-12 text-center shadow-sm">
                                <div
                                    class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 rounded-full bg-gray-50 text-gray-400 mb-4">
                                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                                        </path>
                                    </svg>
                                </div>
                                <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-1">No posts yet</h3>
                                <p class="text-sm sm:text-base text-gray-500">When {{ $user->name }} posts something, it
                                    will appear here.</p>
                            </div>
                        @endif
                    </div>

                    <!-- About Tab -->
                    <div x-show="tab === 'about'" style="display: none;" class="p-4 sm:p-8 lg:p-10"
                        x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 translate-y-2"
                        x-transition:enter-end="opacity-100 translate-y-0">
                        <div class="max-w-3xl">
                            <h2 class="text-lg font-bold text-gray-900 mb-4">About {{ $user->name }}</h2>

                            @if ($user->bio)
                                <div class="text-gray-700 leading-relaxed text-sm sm:text-base whitespace-pre-line mb-8">
                                    {{ $user->bio }}
                                </div>
                            @else
                                <div class="text-gray-500 text-sm sm:text-base italic mb-8">
                                    This user hasn't written a bio yet.
                                </div>
                            @endif

                            <div class="border-t border-gray-200 pt-6">
                                <h3 class="text-xs font-semibold text-gray-500 uppercase tracking-wider mb-4">Profile
                                    Details</h3>
                                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4 sm:gap-y-6 text-sm">
                                    <div>
                                        <dt class="text-gray-500 mb-1">Joined</dt>
                                        <dd class="font-medium text-gray-900">{{ $user->created_at->format('F d, Y') }}
                                        </dd>
                                    </div>
                                    <div>
                                        <dt class="text-gray-500 mb-1">Email</dt>
                                        <dd class="font-medium text-gray-900 break-all">
                                            @if(Auth::check() && Auth::id() === $user->id)
                                                {{ $user->email }}
                                            @else
                                                <span class="text-gray-400 italic">Hidden</span>
                                            @endif
                                        </dd>
                                    </div>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>