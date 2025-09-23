<x-layouts.app title="Тест TinyMCE">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Тест TinyMCE Manager</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <!-- Простой редактор -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Простий редактор</h2>
                <label for="simple-editor" class="block text-sm font-medium text-gray-700 mb-2">
                    Введіть текст
                </label>
                <textarea 
                    id="simple-editor" 
                    class="tinymce-editor w-full border border-gray-300 rounded-md"
                    rows="6"
                    placeholder="Введіть текст тут..."></textarea>
            </div>
            
            <!-- Редактор з завантаженням зображень -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Редактор з зображеннями</h2>
                <label for="image-editor" class="block text-sm font-medium text-gray-700 mb-2">
                    Редактор з підтримкою зображень
                </label>
                <textarea 
                    id="image-editor" 
                    data-tinymce='{"height": 300, "plugins": ["advlist", "autolink", "lists", "link", "image", "charmap", "preview", "anchor", "searchreplace", "visualblocks", "code", "fullscreen", "insertdatetime", "media", "table", "help", "wordcount"], "toolbar": "undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | code | removeformat | help", "images_upload_url": "{{ route("tinymce.upload-image") }}", "images_upload_handler": function (blobInfo, success, failure) { var xhr, formData; xhr = new XMLHttpRequest(); xhr.withCredentials = false; xhr.open("POST", "{{ route("tinymce.upload-image") }}"); xhr.setRequestHeader("X-CSRF-TOKEN", "{{ csrf_token() }}"); xhr.onload = function() { var json; if (xhr.status != 200) { failure("HTTP Error: " + xhr.status); return; } json = JSON.parse(xhr.responseText); if (!json || typeof json.location != "string") { failure("Invalid JSON: " + xhr.responseText); return; } success(json.location); }; formData = new FormData(); formData.append("file", blobInfo.blob(), blobInfo.filename()); xhr.send(formData); }}'
                    class="w-full border border-gray-300 rounded-md"
                    rows="6"
                    placeholder="Введіть текст з зображеннями..."></textarea>
            </div>
            
            <!-- Редактор з мінімальними налаштуваннями -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Мінімальний редактор</h2>
                <label for="minimal-editor" class="block text-sm font-medium text-gray-700 mb-2">
                    Простий редактор
                </label>
                <textarea 
                    id="minimal-editor" 
                    data-tinymce='{"height": 200, "plugins": ["lists", "link"], "toolbar": "bold italic | bullist numlist | link", "menubar": false, "statusbar": false}'
                    class="w-full border border-gray-300 rounded-md"
                    rows="4"
                    placeholder="Мінімальний редактор..."></textarea>
            </div>
            
            <!-- Редактор з повними налаштуваннями -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-xl font-semibold mb-4">Повний редактор</h2>
                <label for="full-editor" class="block text-sm font-medium text-gray-700 mb-2">
                    Повнофункціональний редактор
                </label>
                <textarea 
                    id="full-editor" 
                    data-tinymce='{"height": 400, "plugins": ["advlist", "autolink", "lists", "link", "image", "charmap", "preview", "anchor", "searchreplace", "visualblocks", "code", "fullscreen", "insertdatetime", "media", "table", "help", "wordcount", "codesample"], "toolbar": "undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | codesample code | removeformat | help", "content_style": "body { font-family:Helvetica,Arial,sans-serif; font-size:16px } ol { list-style-type: decimal; margin-left: 20px; } ul { list-style-type: disc; margin-left: 20px; }"}'
                    class="w-full border border-gray-300 rounded-md"
                    rows="8"
                    placeholder="Повнофункціональний редактор..."></textarea>
            </div>
        </div>
        
        <!-- Кнопки управління -->
        <div class="mt-8 text-center space-x-4">
            <button 
                onclick="TinyMCEManager.initAllEditors()" 
                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Ініціалізувати всі редактори
            </button>
            <button 
                onclick="TinyMCEManager.getInstance().cleanupAllEditors()" 
                class="px-6 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                Очистити всі редактори
            </button>
            <button 
                onclick="console.log('TinyMCE статус:', typeof tinymce !== 'undefined' ? 'Завантажений' : 'Не завантажений')" 
                class="px-6 py-3 bg-gray-600 text-white rounded-md hover:bg-gray-700 transition-colors">
                Перевірити статус
            </button>
        </div>
        
        <!-- Інформація про стан -->
        <div class="mt-8 bg-gray-100 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Інформація про стан</h3>
            <div id="status-info" class="text-sm text-gray-700">
                <p>Статус TinyMCE: <span id="tinymce-status">Перевіряється...</span></p>
                <p>Кількість ініціалізованих редакторів: <span id="editors-count">0</span></p>
                <p>Час завантаження: <span id="load-time">-</span></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Оновлюємо інформацію про стан
    function updateStatus() {
        const tinymceStatus = document.getElementById('tinymce-status');
        const editorsCount = document.getElementById('editors-count');
        const loadTime = document.getElementById('load-time');
        
        if (typeof tinymce !== 'undefined') {
            tinymceStatus.textContent = 'Завантажений';
            tinymceStatus.className = 'text-green-600 font-semibold';
            
            const editors = tinymce.editors;
            editorsCount.textContent = editors.length;
            
            if (window.tinymceLoadTime) {
                const loadDuration = Date.now() - window.tinymceLoadTime;
                loadTime.textContent = loadDuration + 'мс';
            }
        } else {
            tinymceStatus.textContent = 'Не завантажений';
            tinymceStatus.className = 'text-red-600 font-semibold';
            editorsCount.textContent = '0';
        }
    }
    
    // Оновлюємо статус кожні 2 секунди
    setInterval(updateStatus, 2000);
    updateStatus();
    
    // Записуємо час початку завантаження
    window.tinymceLoadTime = Date.now();
    
    // Перевіряємо, чи завантажений TinyMCEManager
    if (typeof TinyMCEManager !== 'undefined') {
        console.log('TinyMCEManager доступний');
        // Автоматично ініціалізуємо редактори
        setTimeout(() => {
            TinyMCEManager.initAllEditors();
        }, 1000);
    } else {
        console.log('TinyMCEManager не доступний');
    }
});
</script>
</x-layouts.app>














