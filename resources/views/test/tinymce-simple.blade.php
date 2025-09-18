<x-layouts.app title="Простий тест TinyMCE">
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8">Простий тест TinyMCE</h1>
        
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Базовий редактор</h2>
            <label for="basic-editor" class="block text-sm font-medium text-gray-700 mb-2">
                Введіть текст
            </label>
            <textarea 
                id="basic-editor" 
                class="tinymce-editor w-full border border-gray-300 rounded-md"
                rows="6"
                placeholder="Введіть текст тут..."></textarea>
        </div>
        
        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <h2 class="text-xl font-semibold mb-4">Редактор з зображеннями</h2>
            <label for="image-editor" class="block text-sm font-medium text-gray-700 mb-2">
                Редактор з підтримкою зображень
            </label>
            <textarea 
                id="image-editor" 
                class="tinymce-editor w-full border border-gray-300 rounded-md"
                rows="8"
                placeholder="Введіть текст та спробуйте вставити зображення..."></textarea>
        </div>
        
        <!-- Кнопки управління -->
        <div class="text-center space-x-4">
            <button 
                onclick="initEditors()" 
                class="px-6 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                Ініціалізувати редактори
            </button>
            <button 
                onclick="checkStatus()" 
                class="px-6 py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                Перевірити статус
            </button>
        </div>
        
        <!-- Інформація про стан -->
        <div class="mt-8 bg-gray-100 rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Статус системи</h3>
            <div id="status-info" class="text-sm text-gray-700">
                <p>Статус TinyMCE: <span id="tinymce-status">Перевіряється...</span></p>
                <p>Статус TinyMCEManager: <span id="manager-status">Перевіряється...</span></p>
                <p>Кількість редакторів: <span id="editors-count">0</span></p>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('DOM завантажений');
    updateStatus();
    
    // Автоматично ініціалізуємо редактори через 2 секунди
    setTimeout(() => {
        if (typeof TinyMCEManager !== 'undefined') {
            console.log('TinyMCEManager доступний, ініціалізуємо редактори');
            TinyMCEManager.initAllEditors();
        } else {
            console.log('TinyMCEManager не доступний');
        }
    }, 2000);
});

function initEditors() {
    console.log('Спроба ініціалізації редакторів');
    
    if (typeof TinyMCEManager !== 'undefined') {
        try {
            TinyMCEManager.initAllEditors();
            console.log('Редактори ініціалізовані');
        } catch (error) {
            console.error('Помилка ініціалізації:', error);
        }
    } else {
        console.log('TinyMCEManager не доступний');
        alert('TinyMCEManager не доступний');
    }
}

function checkStatus() {
    console.log('Перевірка статусу');
    updateStatus();
}

function updateStatus() {
    const tinymceStatus = document.getElementById('tinymce-status');
    const managerStatus = document.getElementById('manager-status');
    const editorsCount = document.getElementById('editors-count');
    
    // Статус TinyMCE
    if (typeof tinymce !== 'undefined') {
        tinymceStatus.textContent = 'Завантажений';
        tinymceStatus.className = 'text-green-600 font-semibold';
        
        const editors = tinymce.editors || [];
        editorsCount.textContent = editors.length;
    } else {
        tinymceStatus.textContent = 'Не завантажений';
        tinymceStatus.className = 'text-red-600 font-semibold';
        editorsCount.textContent = '0';
    }
    
    // Статус TinyMCEManager
    if (typeof TinyMCEManager !== 'undefined') {
        managerStatus.textContent = 'Доступний';
        managerStatus.className = 'text-green-600 font-semibold';
    } else {
        managerStatus.textContent = 'Не доступний';
        managerStatus.className = 'text-red-600 font-semibold';
    }
}

// Оновлюємо статус кожні 3 секунди
setInterval(updateStatus, 3000);
</script>
</x-layouts.app>












