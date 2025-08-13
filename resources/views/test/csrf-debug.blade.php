<x-layouts.app title="Діагностика CSRF токена">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Детальна діагностика CSRF токена</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Інформація про токен -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Інформація про CSRF токен</h2>
                
                <div class="space-y-4">
                    <div>
                        <strong>CSRF токен (Laravel):</strong>
                        <code class="block bg-gray-100 p-2 rounded mt-1 break-all text-xs">{{ csrf_token() }}</code>
                    </div>
                    
                    <div>
                        <strong>Meta тег:</strong>
                        <code class="block bg-gray-100 p-2 rounded mt-1 text-xs">&lt;meta name="csrf-token" content="{{ csrf_token() }}"&gt;</code>
                    </div>
                    
                    <div>
                        <strong>JavaScript доступ:</strong>
                        <span id="js-token-status" class="text-gray-600">Перевіряється...</span>
                    </div>
                    
                    <div>
                        <strong>Довжина токена:</strong>
                        <span id="token-length" class="font-mono">{{ strlen(csrf_token()) }}</span> символів
                    </div>
                </div>
            </div>
            
            <!-- Тест завантаження -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Тест завантаження</h2>
                
                <form id="upload-form" class="space-y-4">
                    <div>
                        <label for="test-file" class="block text-sm font-medium text-gray-700 mb-2">
                            Виберіть зображення
                        </label>
                        <input type="file" 
                               id="test-file" 
                               name="file" 
                               accept="image/*"
                               class="w-full border border-gray-300 rounded-md px-3 py-2">
                    </div>
                    
                    <button type="submit" 
                            class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                        Тестувати
                    </button>
                </form>
                
                <div id="upload-result" class="mt-4 p-3 bg-gray-100 rounded-md hidden">
                    <h3 class="font-semibold mb-2">Результат:</h3>
                    <pre id="result-content" class="text-xs"></pre>
                </div>
            </div>
        </div>
        
        <!-- Детальна діагностика -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Детальна діагностика</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                <div>
                    <strong>Laravel версія:</strong>
                    <p class="mt-1">{{ app()->version() }}</p>
                </div>
                
                <div>
                    <strong>App environment:</strong>
                    <p class="mt-1">{{ app()->environment() }}</p>
                </div>
                
                <div>
                    <strong>App debug:</strong>
                    <p class="mt-1">{{ config('app.debug') ? 'Так' : 'Ні' }}</p>
                </div>
                
                <div>
                    <strong>Session driver:</strong>
                    <p class="mt-1">{{ config('session.driver') }}</p>
                </div>
                
                <div>
                    <strong>Session lifetime:</strong>
                    <p class="mt-1">{{ config('session.lifetime') }} хв</p>
                </div>
                
                <div>
                    <strong>CSRF protection:</strong>
                    <p class="mt-1">{{ config('session.verify_csrf_token') ? 'Увімкнено' : 'Вимкнено' }}</p>
                </div>
            </div>
        </div>
        
        <!-- Логи запитів -->
        <div class="mt-8 bg-white shadow-lg rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Логи запитів</h2>
            
            <div class="space-y-2">
                <button onclick="testCSRF()" class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700">
                    Тест CSRF токена
                </button>
                
                <button onclick="testUpload()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 ml-2">
                    Тест завантаження
                </button>
                
                <button onclick="clearLogs()" class="px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 ml-2">
                    Очистити логи
                </button>
            </div>
            
            <div id="request-logs" class="mt-4 p-4 bg-gray-100 rounded-md max-h-64 overflow-y-auto">
                <p class="text-gray-500">Логи запитів з'являться тут...</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM завантажений');
    
    // Перевіряємо CSRF токен
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    const tokenStatus = document.getElementById('js-token-status');
    const tokenLength = document.getElementById('token-length');
    
    if (token) {
        tokenStatus.textContent = 'Доступний: ' + token.substring(0, 20) + '...';
        tokenStatus.className = 'text-green-600 font-semibold';
        tokenLength.textContent = token.length;
    } else {
        tokenStatus.textContent = 'Не знайдено';
        tokenStatus.className = 'text-red-600 font-semibold';
        tokenLength.textContent = '0';
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
        
        logRequest('Спроба завантаження файлу: ' + file.name);
        
        // Створюємо FormData
        const formData = new FormData();
        formData.append('file', file);
        
        // Отримуємо CSRF токен
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        
        if (!csrfToken) {
            logRequest('❌ CSRF токен не знайдено!', 'error');
            return;
        }
        
        logRequest('✅ CSRF токен знайдено: ' + csrfToken.substring(0, 20) + '...');
        
        // Відправляємо запит
        fetch('/tinymce/upload-image', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': csrfToken
            }
        })
        .then(response => {
            logRequest(`📡 Response status: ${response.status} ${response.statusText}`);
            
            return response.json().then(data => ({
                status: response.status,
                statusText: response.statusText,
                data: data
            }));
        })
        .then(result => {
            logRequest('✅ Завантаження успішне: ' + JSON.stringify(result, null, 2));
            resultContent.textContent = JSON.stringify(result, null, 2);
            resultDiv.classList.remove('hidden');
        })
        .catch(error => {
            logRequest('❌ Помилка: ' + error.message, 'error');
            resultContent.textContent = 'Помилка: ' + error.message;
            resultDiv.classList.remove('hidden');
        });
    });
});

// Функції для логування
function logRequest(message, type = 'info') {
    const logsDiv = document.getElementById('request-logs');
    const timestamp = new Date().toLocaleTimeString();
    const logEntry = document.createElement('div');
    logEntry.className = `text-sm mb-2 ${type === 'error' ? 'text-red-600' : 'text-gray-700'}`;
    logEntry.innerHTML = `<strong>[${timestamp}]</strong> ${message}`;
    
    // Додаємо на початок
    logsDiv.insertBefore(logEntry, logsDiv.firstChild);
    
    // Обмежуємо кількість логів
    const logs = logsDiv.querySelectorAll('div');
    if (logs.length > 20) {
        logs[logs.length - 1].remove();
    }
}

function testCSRF() {
    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (token) {
        logRequest('✅ CSRF токен доступний: ' + token.substring(0, 20) + '...');
        logRequest('📏 Довжина токена: ' + token.length + ' символів');
    } else {
        logRequest('❌ CSRF токен не знайдено!', 'error');
    }
}

function testUpload() {
    const fileInput = document.getElementById('test-file');
    if (fileInput.files.length > 0) {
        fileInput.form.dispatchEvent(new Event('submit'));
    } else {
        logRequest('⚠️ Виберіть файл для тестування', 'warning');
    }
}

function clearLogs() {
    const logsDiv = document.getElementById('request-logs');
    logsDiv.innerHTML = '<p class="text-gray-500">Логи очищено...</p>';
}
</script>
</x-layouts.app>

