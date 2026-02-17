<!DOCTYPE html>
<html>
<head>
    <title>Простий тест</title>
</head>
<body>
    <h1>Тестова сторінка працює!</h1>
    <p>Час: {{ now() }}</p>
    <p>CSRF токен: {{ csrf_token() }}</p>
    
    <h2>Тест завантаження файлу</h2>
    <form action="/tinymce/upload-image" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file" accept="image/*">
        <button type="submit">Завантажити</button>
    </form>
    
    <h2>Тест через JavaScript</h2>
    <input type="file" id="test-file" accept="image/*">
    <button onclick="testUpload()">Тест JavaScript</button>
    
    <div id="result"></div>
    
    <script>
    function testUpload() {
        const fileInput = document.getElementById('test-file');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Виберіть файл');
            return;
        }
        
        const formData = new FormData();
        formData.append('file', file);
        
        // Отримуємо CSRF токен
        const token = document.querySelector('input[name="_token"]').value;
        
        fetch('/tinymce/upload-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': token
            }
        })
        .then(response => {
            console.log('Status:', response.status);
            return response.json();
        })
        .then(data => {
            document.getElementById('result').innerHTML = '<pre>' + JSON.stringify(data, null, 2) + '</pre>';
        })
        .catch(error => {
            document.getElementById('result').innerHTML = '<p style="color: red;">Помилка: ' + error.message + '</p>';
        });
    }
    </script>
</body>
</html>





























