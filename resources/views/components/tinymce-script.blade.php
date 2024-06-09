@props(['name' => 'description'])
<script src="{{ asset('js/tinymce/tinymce.min.js') }}"></script>
<script>
    tinymce.init({
        path_absolute: '/',
        selector: 'textarea.{{$name}}',
        menubar: false,
        plugins: [
            'advlist autolink lists link charmap hr pagebreak',
            'searchreplace wordcount visualblocks visualchars insertdatetime nonbreaking',
            'contextmenu directionality emoticons paste'
        ],
        toolbar: 'undo redo |  bold italic underline | alignleft aligncenter alignright alignjustify | link unlink |',
        relative_urls: false,
        remove_script_host: false,
        language: 'ru',
        branding: false,
        setup: function (editor) {
            editor.on('init change', function () {
                editor.save();
            });
            editor.on('change', function (e) {
            @this.set('{{$name}}', editor.getContent());
            });
        },
    });
</script>
