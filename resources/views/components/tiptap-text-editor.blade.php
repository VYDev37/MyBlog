@props(['value' => ''])

<div x-data="tipTapEditor(@js($value))" x-init="initEditor($refs.editorElement)">
    <div
        class="mt-1 border border-default-medium dark:border-gray-700 rounded-md overflow-hidden bg-white dark:bg-gray-900 shadow-sm transition-colors">

        <!-- Toolbar -->
        <div
            class="flex flex-wrap gap-1 p-2 border-b border-default-medium dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
            <!-- Bold -->
            <button type="button" @click="editor().chain().focus().toggleBold().run()"
                :class="isBold ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="p-1.5 rounded-md transition-colors text-sm font-bold w-8 h-8 flex items-center justify-center">
                B
            </button>

            <!-- Italic -->
            <button type="button" @click="editor().chain().focus().toggleItalic().run()"
                :class="isItalic ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="p-1.5 rounded-md transition-colors text-sm italic font-serif w-8 h-8 flex items-center justify-center">
                I
            </button>
            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 my-auto mx-1"></div>
            <!-- Link -->
            <button type="button" @click="toggleLink()"
                :class="isLink ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                title="Insert/Edit Link"
                class="p-1.5 rounded-md transition-colors text-sm w-8 h-8 flex items-center justify-center">
                🔗
            </button>

            <!-- Code Block -->
            <button type="button" @click="editor().chain().focus().toggleCodeBlock().run()"
                :class="isCodeBlock ? 'bg-indigo-100 text-indigo-700 dark:bg-indigo-900 dark:text-indigo-300' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                class="p-1.5 rounded-md transition-colors text-sm font-mono w-auto px-2 h-8 flex items-center justify-center">
                &lt;/&gt;
            </button>

            <div class="w-px h-6 bg-gray-300 dark:bg-gray-600 my-auto mx-1"></div>

            <!-- Image Upload -->
            <button type="button" @click="$refs.fileInput.click()" :disabled="isUploading"
                :class="isUploading ? 'opacity-50 cursor-not-allowed text-gray-400' : 'text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700'"
                title="Insert Image"
                class="p-1.5 rounded-md transition-colors text-sm w-auto px-2 h-8 flex items-center justify-center">
                <span x-show="!isUploading">🖼️</span>
                <span x-show="isUploading" style="display: none;"
                    class="animate-spin inline-block w-4 h-4 border-[2px] border-current border-t-transparent rounded-full"
                    role="status" aria-label="loading"></span>
            </button>
            <input type="file" x-ref="fileInput" class="hidden"
                accept="image/jpeg, image/png, image/jpg, image/gif, image/webp" @change="uploadImage">
        </div>
        <!-- Area Mengetik -->
        <div x-ref="editorElement" class="p-3">
        </div>
    </div>
    <input type="hidden" name="content" :value="content">
</div>