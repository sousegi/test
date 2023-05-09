<style>
    .dropzone .dz-preview .dz-image {
        height: 120px;
        width: 120px;
        border-radius: 0;
    }

    .dropzone .dz-details {
        display: none!important;
    }

    .needsclick.dropzone.dz-clickable.dz-started {
        width: auto;
        height: auto;
    }

    .image-container .form-group{
        margin-bottom: 44px!important;
    }
    .dropzone .dz-preview .dz-error-message{
        top: 150px!important;

    }

    .dropzone .dz-preview:hover .dz-image img {
        filter: none!important;
        transform: none!important;
    }
</style>
<script>
    var uploadedDocumentMap = {}
    Dropzone.options.sliderDropzone = {
        url: '{{ route('amigo.dropzone.storeMedia') }}',
        maxFilesize: 4, // MB
        maxFiles: 1,
        autoQueue: true,
        dictRemoveFileConfirmation: "Do you really want to remove this?",
        uploadMultiple: false,
        acceptedFiles: '.jpg,.jpeg,.png',
        addRemoveLinks: true,
        headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
        },
        success: function (file, response) {
            $('form').append('<input type="hidden" name="{{ $input_name ?? 'image' }}" value="' + response.name + '">')
            uploadedDocumentMap[file.name] = response.name
            file.previewElement.classList.remove('dz-error');
            return file.previewElement.classList.add('dz-success');
        },
        removedfile: function (file) {

            if (file.previewElement !== undefined) {
                file.previewElement.remove()
                var name = ''
                var file_name = ''

                if (typeof file.name !== undefined) {
                    name = file.name
                } else {
                    name = uploadedDocumentMap[file.name]
                }

                if (file.file_path === undefined) {
                    file_name = uploadedDocumentMap[file.name]
                } else {
                    file_name = file.name;
                }

                $('form').find('input[name="{{ $input_name ?? 'image' }}"][value="' + name + '"]').remove()
                $.ajax({
                    url: '{{ route('amigo.dropzone.deleteFile') }}',
                    type: 'post',
                    data: {
                        file_to_be_deleted: file_name,
                        path: file.file_path,
                    },
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function (data) {

                    }
                });
            }
        },
        init: function () {
            this.on("thumbnail", function(file) {

                file.acceptDimensions();
            });

            const imagesArr = $('#imagesArr').attr('data-images')
            const imagesparsed = JSON.parse(imagesArr)

            if (imagesparsed.length > 1) {
                this.removeFile(imagesparsed[0]);
            }

            for (var i in imagesparsed) {
                var file = imagesparsed[i]
                this.options.addedfile.call(this, file)
                this.options.thumbnail.call(this, file, file.path);
                this.emit('complete', file);
                file.previewElement.classList.add('dz-complete')
                $('.dz-image>img').css('height','120px')
                $('form #slider-dropzone').append('<input type="hidden" name="{{ $input_name ?? 'image' }}" value="' + file.name + '">')
            }

            this.on('maxfilesexceeded', function (file) {
                this.removeAllFiles();
                this.addFile(file);
            });
        },
        accept: function(file, done) {
            file.acceptDimensions = done;
        }
    }
</script>
