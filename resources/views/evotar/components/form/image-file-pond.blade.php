<div class="w-full">
    <x-form-components::files.file-pond
        :max-files="1"
        {{ $attributes }}
    >
        <x-slot:config>
            oninit() {
            instance.__pond.setOptions({
            labelIdle: 'Drag & Drop your picture or <span class=\'filepond--label-action\'>Browse</span>',
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
