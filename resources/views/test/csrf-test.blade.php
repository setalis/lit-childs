<x-layouts.app title="Тест CSRF токена">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Тест CSRF токена</h1>
        
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Інформація про CSRF токен</h2>
            
            <div class="space-y-4">
                <div>
                    <strong>CSRF токен:</strong>
                    <code class="block bg-gray-100 p-2 rounded mt-1 break-all">{{ csrf_token() }}</code>
                </div>
                
                <div>
                    <strong>Meta тег:</strong>
                    <code class="block bg-gray-100 p-2 rounded mt-1">&lt;meta name="csrf-token" content="{{ csrf_token() }}"&gt;</code>
                </div>
                
                <div>
                    <strong>JavaScript доступ:</strong>
                    <span id="js-token-status" class="text-gray-600">Перевіряється...</span>
                </div>
            </div>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Тест завантаження файлу</h2>
            
            <form id="upload-form" class="space-y-4">
                <div>
                    <label for="test-file" class="block text-sm font-medium text-gray-700 mb-2">
                        Виберіть зображення для тесту
                    </label>
                    <input type="file" 
                           id="test-file" 
                           name="file" 
                           accept="image/*"
                           class="w-full border border-gray-300 rounded-md px-3 py-2">
                </div>
                
                <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                    Тестувати завантаження
                </button>
            </form>
            
            <div id="upload-result" class="mt-4 p-4 bg-gray-100 rounded-md hidden">
                <h3 class="font-semibold mb-2">Результат:</h3>
                <pre id="result-content" class="text-sm"></pre>
            </div>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Діагностика</h2>
            
            <div class="space-y-2 text-sm">
                <p><strong>Laravel версія:</strong> {{ app()->version() }}</p>
                <p><strong>App environment:</strong> {{ app()->environment() }}</p>
                <p><strong>App debug:</strong> {{ config('app.debug') ? 'Так' : 'Ні' }}</p>
                <p><strong>Session driver:</strong> {{ config('session.driver') }}</p>
                <p><strong>CSRF protection:</strong> {{ config('session.verify_csrf_token') ? 'Увімкнено' : 'Вимкнено' }}</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Перевіряємо CSRF токен в JavaScript
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const tokenStatus = document.getElementById('js-token-status');
    
    if (token) {
        tokenStatus.textContent = 'Доступний: ' + token.substring(0, 20) + '...';
        tokenStatus.className = 'text-green-600 font-semibold';
    } else {
        tokenStatus.textContent = 'Не знайдено';
        tokenStatus.className = 'text-red-600 font-semibold';
    }
    
    // Обробка форми завантаження
    const uploadForm = document.getElementById('upload-form');
    const resultDiv = document.getElementById('upload-result');
    const resultContent = document.getElementById('result-content');
    
    uploadForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const fileInput = document.getElementById('test-file');
        const file = fileInput.files[0];
        
        if (!file) {
            alert('Виберіть файл для завантаження');
            return;
        }
        
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

