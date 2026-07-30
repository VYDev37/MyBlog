<div x-data="{
        isOpen: false,
        imgUrl: '',
        imgAlt: '',
        openModal(url, alt) {
            this.imgUrl = url;
            this.imgAlt = alt || 'Zoomed Image';
            this.isOpen = true;
            document.body.classList.add('overflow-y-hidden');
        },
        closeModal() {
            this.isOpen = false;
            document.body.classList.remove('overflow-y-hidden');
            setTimeout(() => {
                this.imgUrl = '';
                this.imgAlt = '';
            }, 300); // wait for animation to finish
        }
    }"
    x-on:open-image-zoom.window="openModal($event.detail.url, $event.detail.alt)"
    x-on:keydown.escape.window="closeModal()"
    class="relative z-[100]"
    aria-labelledby="modal-title" role="dialog" aria-modal="true"
    style="display: none;"
    x-show="isOpen">

    <!-- Backdrop -->
    <div x-show="isOpen"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 backdrop-blur-none"
        x-transition:enter-end="opacity-100 backdrop-blur-sm"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 backdrop-blur-sm"
        x-transition:leave-end="opacity-0 backdrop-blur-none"
        class="fixed inset-0 bg-black/80 transition-all"></div>

    <!-- Modal Panel -->
    <div class="fixed inset-0 z-10 w-screen overflow-y-auto" @click="closeModal()">
        <div class="flex min-h-full items-center justify-center p-4 sm:p-6 cursor-zoom-out">
            
            <div x-show="isOpen"
                @click.stop
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 scale-90 translate-y-4 sm:translate-y-0"
                x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                x-transition:leave-end="opacity-0 scale-90 translate-y-4 sm:translate-y-0"
                class="relative transform overflow-hidden rounded-xl bg-transparent shadow-2xl transition-all max-w-7xl max-h-[90vh]">
                
                <!-- Close button -->
                <button @click="closeModal()" class="absolute top-2 right-2 sm:top-4 sm:right-4 z-10 p-2 bg-black/50 hover:bg-black/80 text-white rounded-full backdrop-blur-sm transition-colors cursor-pointer" aria-label="Close zoom">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <img :src="imgUrl" :alt="imgAlt" class="w-auto h-auto max-w-full max-h-[90vh] object-contain rounded-xl select-none" />
                
            </div>
        </div>
    </div>
</div>
