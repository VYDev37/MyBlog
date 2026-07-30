<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')


        <div class="flex items-center gap-6" x-data="{ previewUrl: null }">
            <div class="relative w-16 h-16 group">
                <img x-show="previewUrl" :src="previewUrl"
                    class="relative w-full h-full overflow-hidden bg-neutral-secondary-medium dark:bg-gray-700 rounded-full shadow-sm border border-gray-200 dark:border-gray-600 w-full h-full object-cover">
                <div x-show="!previewUrl"
                    class="relative w-full h-full overflow-hidden bg-neutral-secondary-medium dark:bg-gray-700 rounded-full shadow-sm border border-gray-200 dark:border-gray-600">
                    @if ($user->profile)
                        <img src="{{ Str::startsWith($user->profile, 'http') ? $user->profile : Storage::url($user->profile) }}"
                            alt="Profile" class="w-full h-full object-cover">
                    @else
                        <svg class="absolute w-20 h-20 text-gray-400 -left-2 top-0" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    @endif
                </div>

                <!-- Pencil overlay acting as a trigger for file input -->
                <label for="profile"
                    class="absolute inset-0 w-full h-full rounded-full cursor-pointer bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                </label>
            </div>

            <div class="flex-1 hidden">
                <x-input-label for="profile" :value="__('Profile Image')" class="sr-only" />
                <x-text-input id="profile" name="profile"
                    @change="previewUrl = URL.createObjectURL($event.target.files[0])"
                    accept=".jpg,.png,.jpeg,.svg,.gif,.webp,.heic,.heif,.avif,.bmp"
                    class="cursor-pointer bg-neutral-secondary-medium dark:bg-gray-900 border border-default-medium dark:border-gray-700 text-heading dark:text-gray-300 text-sm rounded-base focus:ring-brand focus:border-brand block w-full shadow-xs placeholder:text-body"
                    aria-describedby="profile_help" type="file" autofocus />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-300" id="profile_help">SVG, PNG, JPG,
                    WEBP, JPEG, HEIC, HEIF, AVIF, BMP, or GIF (MAX. 2MB).</p>
            </div>
        </div>
        <x-input-error :messages="$errors->get('profile')" class="mt-2" />


        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)"
                required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required autofocus autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('username')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification"
                            class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="mt-4">
            <x-input-label for="bio" :value="__('Bio')" />
            <x-input-textarea id="bio" class="block mt-1 w-full" type="bio" name="bio" :value="old('bio', $user->bio)"
                autofocus />
            <x-input-error :messages="$errors->get('bio')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>