@props(['textname' => 'description'])
{{--Загрузка tinymce передать свойство :textname - название textarea для привязки--}}
{{--Add    <script src="{{ asset('js/tinymce/tinymce.js') }}"></script> with compoentn--}}
<script>
    tinymce.init({
        path_absolute: '/',
        selector: 'textarea.{{$textname}}',
        menubar: false,
        plugins: [
            'advlist autolink lists link image charmap hr pagebreak',
            'searchreplace wordcount visualblocks visualchars insertdatetime nonbreaking',
            'contextmenu directionality emoticons media paste imagetools'
        ],
        toolbar: 'undo redo |  bold italic underline | alignleft aligncenter alignright alignjustify | link unlink | image',
        relative_urls: false,
        remove_script_host: false,
        language: 'ru',
        automatic_uploads: true,
        images_upload_url: '/upload_image',
        file_picker_types: 'image',
        branding: false,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
            @this.set('{{$textname}}', editor.getContent());
            });
        },
        file_picker_callback: function (cb, value, meta) {
            var input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/*');
            input.onchange = function () {
                var file = this.files[0];

                var reader = new FileReader();
                reader.readAsDataURL(file);
                reader.onload = function () {
                    var id = 'blobid' + (new Date()).getTime();
                    var blobCache = tinymce.activeEditor.editorUpload.blobCache;
                    var base64 = reader.result.split(',')[1];
                    var blobInfo = blobCache.create(id, file, base64);
                    blobCache.add(blobInfo);
                    cb(blobInfo.blobUri(), {title: file.name});
                };
            };
            input.click();
        },
    });
</script>
