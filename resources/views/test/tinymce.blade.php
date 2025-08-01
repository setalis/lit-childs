<!DOCTYPE html>
<html>
<head>
    <title>TinyMCE Test</title>
    <script src="{{ asset('js/tinymce/tinymce.min.js') }}" referrerpolicy="origin"></script>
</head>
<body>
    <h1>TinyMCE Test Page</h1>
    
    <textarea id="test-editor">
        <p>Это тестовый контент для TinyMCE редактора.</p>
        <p>Попробуйте отредактировать этот текст!</p>
    </textarea>

    <script>
        tinymce.init({
            selector: '#test-editor',
            height: 300,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount'
            ],
            toolbar: 'undo redo | blocks | ' +
            'bold italic backcolor | alignleft aligncenter ' +
            'alignright alignjustify | bullist numlist outdent indent | ' +
            'removeformat | help',
            content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px }'
        });
    </script>
</body>
</html> 