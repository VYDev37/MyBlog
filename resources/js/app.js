

import Alpine from 'alpinejs';
import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import CodeBlockLowlight from '@tiptap/extension-code-block-lowlight';
import Image from '@tiptap/extension-image';
import Link from '@tiptap/extension-link';
import { common, createLowlight } from 'lowlight';
import hljs from 'highlight.js';
import 'highlight.js/styles/atom-one-dark.css';

const lowlight = createLowlight(common);

window.Alpine = Alpine;

document.addEventListener('alpine:init', () => {
    Alpine.data('tipTapEditor', (initialContent) => {
        let editorInstance = null;

        return {
            content: initialContent,
            isBold: false,
            isItalic: false,
            isCodeBlock: false,
            isLink: false,
            isUploading: false,

            initEditor(element) {
                editorInstance = new Editor({
                    element: element,
                    extensions: [
                        StarterKit.configure({
                            codeBlock: false,
                        }),
                        CodeBlockLowlight.configure({
                            lowlight,
                        }),
                        Image.configure({
                            inline: true,
                            HTMLAttributes: {
                                class: 'rounded-lg max-w-full h-auto',
                            }
                        }),
                        Link.configure({
                            openOnClick: false,
                            HTMLAttributes: {
                                class: 'text-brand hover:text-brand-hover underline cursor-pointer',
                            },
                        }),
                    ],
                    content: this.content,
                    editorProps: {
                        attributes: {
                            class: 'focus:outline-none min-h-[150px] prose dark:prose-invert max-w-none text-gray-900 dark:text-gray-100 prose-p:my-0 prose-headings:my-0 leading-normal',
                        },
                    },
                    onUpdate: ({ editor }) => {
                        this.content = editor.getHTML()
                    },
                    onTransaction: ({ editor }) => {
                        this.isBold = editor.isActive('bold');
                        this.isItalic = editor.isActive('italic');
                        this.isCodeBlock = editor.isActive('codeBlock');
                        this.isLink = editor.isActive('link');
                    },
                })
            },

            toggleLink() {
                if (!editorInstance) return;

                if (this.isLink) {
                    editorInstance.chain().focus().unsetLink().run();
                    return;
                }

                const { from, to } = editorInstance.state.selection;
                const selectedText = editorInstance.state.doc.textBetween(from, to, ' ').trim();

                if (selectedText) {
                    let url = selectedText;
                    if (!url.startsWith('http://') && !url.startsWith('https://')) {
                        url = 'https://' + url;
                    }
                    editorInstance.chain().focus().setLink({ href: url }).run();
                }
            },

            editor() {
                return editorInstance
            },

            isActive(type) {
                if (!editorInstance) return false;
                return editorInstance.isActive(type);
            },

            async uploadImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                this.isUploading = true;

                const formData = new FormData();
                formData.append('image', file);

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    const response = await fetch('/upload-image', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    if (!response.ok) {
                        throw new Error('Upload failed');
                    }

                    const data = await response.json();

                    if (data.url && editorInstance) {
                        editorInstance.chain().focus().setImage({ src: data.url }).run();
                    }
                } catch (error) {
                    console.error('Error uploading image:', error);
                    alert('Gagal mengupload gambar. Pastikan format benar dan ukuran di bawah 5MB.');
                } finally {
                    this.isUploading = false;
                    event.target.value = '';
                }
            }
        }
    })
})

Alpine.start();

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('pre code').forEach((block) => {
        hljs.highlightElement(block);
    });
});
