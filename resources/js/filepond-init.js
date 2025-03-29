// resources/js/filepond-global.js
import * as FilePond from 'filepond';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview';
import FilePondPluginImageEdit from 'filepond-plugin-image-edit';
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type';

FilePond.registerPlugin(
    FilePondPluginImagePreview,
    FilePondPluginImageEdit,
    FilePondPluginFileValidateType
);

window.initFilePond = function(inputId, componentId, fieldName) {
    const inputElement = document.getElementById(inputId);
    if (!inputElement) return null;

    // Destroy existing instance if exists
    const existingPond = FilePond.find(inputElement);
    if (existingPond) existingPond.destroy();

    const pond = FilePond.create(inputElement, {
        allowMultiple: false,
        acceptedFileTypes: ['image/*'],
        maxFileSize: '2MB',
        imagePreviewHeight: 150,
        stylePanelAspectRatio: 0.5,
        allowImageEdit: true,
        imageEditEditor: {
            cropRatio: 1,
            cropMinImageWidth: 100,
            cropMinImageHeight: 100
        },
        server: {
            process: (fieldName, file, metadata, load, error, progress, abort) => {
                const component = Livewire.find(componentId);
                if (!component) {
                    error('Livewire component not found');
                    return;
                }

                component.upload(fieldName, file, load, error, progress);

                return {
                    abort: () => {
                        abort();
                        component.reset(fieldName);
                        if (typeof component.set === 'function') {
                            component.set('temporaryImageUrl', null, true);
                        }
                    }
                };
            },
            revert: (uniqueFileId, load, error) => {
                const component = Livewire.find(componentId);
                if (component) {
                    component.removeUpload(fieldName, uniqueFileId);
                }
                load();
            },
            load: (source, load, error, progress, abort, headers) => {
                const component = Livewire.find(componentId);
                if (component && typeof component.get === 'function' && component.get('temporaryImageUrl')) {
                    fetch(component.get('temporaryImageUrl'))
                        .then(res => res.blob())
                        .then(load)
                        .catch(error);
                }
            }
        }
    });

    return pond;
};
