
// Alpine.js удален, используется обычный JavaScript для сворачивания подразделов

// Подключаем TinyMCE Manager
import './tinymce-manager.js';

// Простой скрипт для мобильного меню
document.addEventListener('DOMContentLoaded', function () {
    const menuButton = document.querySelector('[aria-label="Toggle menu"]');
    const mobileMenu = document.getElementById('mobile-menu');
    if (menuButton && mobileMenu) {
        menuButton.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');
        });
    }
});
