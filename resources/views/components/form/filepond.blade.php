<div wire:ignore class="shadow-xl border-t border-l border-r rounded-lg dark:border-gray-700 dark:bg-gray-800">
    <div x-data x-init="() => {
            const pond = FilePond.create($refs.inputFilepond);
            pond.setOptions({
                allowMultiple: {{ $attributes->has('multiple') ? 'true' : 'false' }},
                labelIdle: '{!! __("Drag & Drop your files here or Browse") !!}',
                server: {
                    process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                        @this.upload('{{ $attributes->whereStartsWith('wire:model')->first() }}', file, load, error, progress)
                    },
                    revert: (filename, load) => {
                        @this.removeUpload('{{ $attributes->whereStartsWith('wire:model')->first() }}', filename, load)
                    },
                    load: (source, load, error, progress, abort, headers) => {
                        const myRequest = new Request(source);
                        fetch(myRequest).then((res) => {
                            return res.blob();
                        }).then(load);
                    },
                    allowImagePreview: {{ $attributes->has('allowImagePreview') ? 'true' : 'false' }},
                    imagePreviewMaxHeight: {{ $attributes->has('imagePreviewMaxHeight') ? $attributes->get('imagePreviewMaxHeight') : '256' }},
                    allowFileTypeValidation: {{ $attributes->has('allowFileTypeValidation') ? 'true' : 'false' }},
                    acceptedFileTypes: {!! $attributes->get('acceptedFileTypes') ?? 'null' !!},
                    allowFileSizeValidation: {{ $attributes->has('allowFileSizeValidation') ? 'true' : 'false' }},
                    maxFileSize: {!! $attributes->has('maxFileSize') ? "'" . $attributes->get('maxFileSize') . "'" : 'null' !!},
                }
            });
            this.addEventListener('pond-edit', (event) => {
                if(event.detail[0].file) {
                    pond.setOptions({
                        files: [{
                            source: '{{ public_path('storage') }}/' + event.detail[0].file,
                            options: {
                                type: 'local',
                            },
                        }],
                    });
                }
            });
            this.addEventListener('pond-reset', e => {
                pond.removeFiles();
            });

        }">
        <input type="file" x-ref="inputFilepond">
    </div>
    @pushonce('scripts')
        <script>
            window.addEventListener('livewire:navigated', () => {
                FilePond.registerPlugin(FilePondPluginFileValidateType);
                FilePond.registerPlugin(FilePondPluginFileValidateSize);
                FilePond.registerPlugin(FilePondPluginImagePreview);
            });
        </script>
    @endpushonce
</div>
