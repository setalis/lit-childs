<x-layouts.app title="Тест завантаження зображень">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Тест завантаження зображень</h1>
        
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Простий тест завантаження</h2>
            
            <form id="simple-upload" class="space-y-4">
                <div>
                    <label for="image-file" class="block text-sm font-medium text-gray-700 mb-2">
                        Виберіть зображення
                    </label>
                    <input type="file" 
                           id="image-file" 
                           name="file" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Завантажити
                </button>
            </form>
            
            <div id="upload-result" class="mt-4 p-4 bg-gray-100 rounded-md hidden">
                <h3 class="font-semibold mb-2">Результат:</h3>
                <pre id="result-content" class="text-sm"></pre>
            </div>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">TinyMCE редактор</h2>
            
            <textarea 
                id="tinymce-test" 
                class="tinymce-editor w-full border border-gray-300 rounded-md"
                rows="8"
                placeholder="Спробуйте вставити зображення тут..."></textarea>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Діагностика</h2>
            
            <div class="space-y-2 text-sm">
                <p><strong>CSRF токен:</strong> <span id="csrf-display">Перевіряється...</span></p>
                <p><strong>TinyMCE статус:</strong> <span id="tinymce-status">Перевіряється...</span></p>
                <p><strong>TinyMCEManager статус:</strong> <span id="manager-status">Перевіряється...</span></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM завантажений');
    
    // Перевіряємо CSRF токен
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const csrfDisplay = document.getElementById('csrf-display');
    
    if (token) {
        csrfDisplay.textContent = 'Доступний: ' + token.substring(0, 20) + '...';
        csrfDisplay.className = 'text-green-600 font-semibold';
    } else {
        csrfDisplay.textContent = 'Не знайдено';
        csrfDisplay.className = 'text-red-600 font-semibold';
    }
    
    // Перевіряємо TinyMCE
    const tinymceStatus = document.getElementById('tinymce-status');
    if (typeof tinymce !== 'undefined') {
        tinymceStatus.textContent = 'Завантажений';
        tinymceStatus.className = 'text-green-600 font-semibold';
    } else {
        tinymceStatus.textContent = 'Не завантажений';
        tinymceStatus.className = 'text-red-600 font-semibold';
    }
    
    // Перевіряємо TinyMCEManager
    const managerStatus = document.getElementById('manager-status');
    if (typeof TinyMCEManager !== 'undefined') {
        managerStatus.textContent = 'Доступний';
        managerStatus.className = 'text-green-600 font-semibold';
        
        // Ініціалізуємо редактор
        setTimeout(() => {
            TinyMCEManager.initAllEditors();
        }, 1000);
    } else {
        managerStatus.textContent = 'Не доступний';
        managerStatus.className = 'text-red-600 font-semibold';
    }
    
    // Обробка простої форми завантаження
    const simpleUpload = document.getElementById('simple-upload');
    const resultDiv = document.getElementById('upload-result');
    const resultContent = document.getElementById('result-content');
    
    simpleUpload.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fileInput = document.getElementById('image-file');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Виберіть файл для завантаження');
            return;
        }
        
        console.log('Спроба завантаження файлу:', file.name);
        
        // Створюємо FormData
        const formData = new FormData();
        formData.append('file', file);
        
        // Отримуємо CSRF токен
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        // Відправляємо запит
                    fetch('/tinymce/upload-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            console.log('Response status:', response.status);
            console.log('Response headers:', response.headers);
            
            return response.json().then(data => ({
                status: response.status,
                statusText: response.statusText,
                data: data
            }));
        })
        .then(result => {
            console.log('Upload result:', result);
            resultContent.textContent = JSON.stringify(result, null, 2);
            resultDiv.classList.remove('hidden');
        })
        .catch(error => {
            console.error('Upload error:', error);
            resultContent.textContent = 'Помилка: ' + error.message;
            resultDiv.classList.remove('hidden');
        });
    });
});
</script>
</x-layouts.app>
