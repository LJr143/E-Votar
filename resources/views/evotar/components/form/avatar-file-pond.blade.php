<div class="w-full">
    <x-form-components::files.file-pond
        :max-files="1"
        {{ $attributes }}
    >
        <x-slot:config>
            oninit() {
                instance.__pond.setOptions({
                    labelIdle: 'Drag & Drop your picture or <span class=\'filepond--label-action\'>Browse</span>',
                    imagePreviewHeight: 170,
                    imageCropAspectRatio: '1:1',
                    imageResizeTargetWidth: 200,
                    imageResizeTargetHeight: 200,
                    stylePanelLayout: 'compact circle',
                    styleLoadIndicatorPosition: 'center bottom',
                    styleButtonRemoveItemPosition: 'center bottom',
                    acceptedFileTypes: ['image/*'],
                    fileValidateTypeDetectType: (source, type) =>
                        new Promise((resolve, reject) => {
                        // Do custom type detection here and return with promise
                        resolve(type);
                    }),
                });
            }
        </x-slot:config>
    </x-form-components::files.file-pond>
</div>
