<x-layouts.app title="TinyMCE з зображеннями">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">TinyMCE з підтримкою зображень</h1>
        
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Як використовувати вставку зображень</h2>
            
            <div class="space-y-4 text-gray-700">
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">1</div>
                    <div>
                        <strong>Кнопка зображення:</strong> Натисніть на кнопку з іконкою зображення в панелі інструментів
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">2</div>
                    <div>
                        <strong>Перетягування:</strong> Перетягніть зображення з комп'ютера прямо в редактор
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">3</div>
                    <div>
                        <strong>Вставка з буфера:</strong> Скопіюйте зображення (Ctrl+C) і вставте в редактор (Ctrl+V)
                    </div>
                </div>
                
                <div class="flex items-start space-x-3">
                    <div class="bg-blue-100 text-blue-800 rounded-full w-6 h-6 flex items-center justify-center text-sm font-bold flex-shrink-0 mt-1">4</div>
                    <div>
                        <strong>Налаштування:</strong> Клікніть на зображення для налаштування розміру, вирівнювання та стилів
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Редактор з повною підтримкою зображень -->
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Редактор з зображеннями</h2>
            <label for="image-editor" class="block text-sm font-medium text-gray-700 mb-2">
                Спробуйте вставити зображення різними способами
            </label>
            <textarea 
                id="image-editor" 
                class="tinymce-editor w-full border border-gray-300 rounded-md"
                rows="10"
                placeholder="Введіть текст та спробуйте вставити зображення..."></textarea>
        </div>
        
        <!-- Приклади різних типів редакторів -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Мінімальний редактор з зображеннями -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Мінімальний редактор</h3>
                <label for="minimal-image-editor" class="block text-sm font-medium text-gray-700 mb-2">
                    Тільки основні функції
                </label>
                <textarea 
                    id="minimal-image-editor" 
                    data-tinymce='{"height": 200, "plugins": ["lists", "link", "image"], "toolbar": "bold italic | bullist numlist | link image", "menubar": false, "statusbar": false}'
                    class="w-full border border-gray-300 rounded-md"
                    rows="6"
                    placeholder="Мінімальний редактор..."></textarea>
            </div>
            
            <!-- Розширений редактор -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4">Розширений редактор</h3>
                <label for="advanced-image-editor" class="block text-sm font-medium text-gray-700 mb-2">
                    З додатковими налаштуваннями
                </label>
                <textarea 
                    id="advanced-image-editor" 
                    data-tinymce='{"height": 200, "plugins": ["advlist", "autolink", "lists", "link", "image", "charmap", "preview", "anchor", "searchreplace", "visualblocks", "code", "fullscreen", "insertdatetime", "media", "table", "help", "wordcount"], "toolbar": "undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | image | code | removeformat | help", "image_advtab": true, "image_dimensions": true, "image_class_list": [{"title": "Responsive", "value": "img-fluid"}, {"title": "Thumbnail", "value": "img-thumbnail"}, {"title": "Rounded", "value": "rounded"}, {"title": "Circle", "value": "rounded-circle"}]}'
                    class="w-full border border-gray-300 rounded-md"
                    rows="6"
                    placeholder="Розширений редактор..."></textarea>
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
                onclick="testImageUpload()" 
                class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                Тест завантаження зображення
            </button>
            <button 
                onclick="showImageInfo()" 
                class="px-6 py-3 bg-purple-600 text-white rounded-md hover:bg-purple-700 transition-colors">
                Показати інформацію про зображення
            </button>
        </div>
        
        <!-- Інформація про завантажені зображення -->
        <div class="mt-8 bg-gray-100 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Інформація про зображення</h3>
            <div id="image-info" class="text-sm text-gray-700">
                <p>Зображення будуть показані тут після завантаження...</p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ініціалізуємо редактори
    if (typeof TinyMCEManager !== 'undefined') {
        setTimeout(() => {
            TinyMCEManager.initAllEditors();
        }, 1000);
    }
});

// Функція для тестування завантаження зображення
function testImageUpload() {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/*';
    
    input.onchange = function(e) {
        const file = e.target.files[0];
        if (file) {
            console.log('Тестове зображення:', file.name, file.size, file.type);
            alert(`Тестове зображення: ${file.name}\nРозмір: ${(file.size / 1024).toFixed(2)} KB\nТип: ${file.type}`);
        }
    };
    
    input.click();
}

// Функція для показу інформації про зображення в редакторі
function showImageInfo() {
    const editor = tinymce.get('image-editor');
    if (editor) {
        const content = editor.getContent();
        const images = content.match(/<img[^>]+>/g);
        
        const imageInfo = document.getElementById('image-info');
        if (images && images.length > 0) {
            let html = '<p><strong>Знайдені зображення:</strong></p><ul class="list-disc list-inside space-y-2">';
            images.forEach((img, index) => {
                const srcMatch = img.match(/src="([^"]+)"/);
                const altMatch = img.match(/alt="([^"]*)"/);
                const src = srcMatch ? srcMatch[1] : 'Невідомо';
                const alt = altMatch ? altMatch[1] : 'Без опису';
                
                html += `<li><strong>Зображення ${index + 1}:</strong><br>`;
                html += `URL: ${src}<br>`;
                html += `Опис: ${alt}</li>`;
            });
            html += '</ul>';
            imageInfo.innerHTML = html;
        } else {
            imageInfo.innerHTML = '<p>Зображення не знайдено в редакторі</p>';
        }
    } else {
        alert('Редактор не ініціалізований');
    }
}
</script>
</x-layouts.app>


























