/**
 * TinyMCE Manager - Централизованное управление редактором
 * Решает проблемы с загрузкой, инициализацией и управлением TinyMCE
 */

class TinyMCEManager {
    constructor() {
        console.log('TinyMCEManager конструктор вызван');
        this.isLoaded = false;
        this.isLoading = false;
        this.initializedEditors = new Set();
        this.pendingInitializations = [];
        this.defaultConfig = {
            height: 400,
            plugins: [
                'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
                'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
                'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
            ],
            allow_unsafe_link_target: true,
            convert_urls: false,
            toolbar: 'undo redo | blocks | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'image | codesample code | removeformat | help',
            content_style: `
                body { font-family:Helvetica,Arial,sans-serif; font-size:16px; }
                ol { list-style-type: decimal; margin-left: 20px; }
                ul { list-style-type: disc; margin-left: 20px; }
                
                /* Обтекание изображений */
                img.float-left { float: left !important; margin-right: 1rem !important; margin-bottom: 0.5rem !important; }
                img.float-right { float: right !important; margin-left: 1rem !important; margin-bottom: 0.5rem !important; }
                img.d-block { display: block !important; }
                img.mx-auto { margin-left: auto !important; margin-right: auto !important; }
                
                /* Bootstrap классы */
                .img-fluid { max-width: 100% !important; height: auto !important; }
                .img-thumbnail { padding: 0.25rem !important; background-color: #fff !important; border: 1px solid #dee2e6 !important; border-radius: 0.25rem !important; max-width: 100% !important; height: auto !important; }
                .rounded { border-radius: 0.375rem !important; }
                .rounded-circle { border-radius: 50% !important; }
                
                /* Комбинированные классы */
                .float-left.me-3.mb-2 { float: left !important; margin-right: 1rem !important; margin-bottom: 0.5rem !important; }
                .float-right.ms-3.mb-2 { float: right !important; margin-left: 1rem !important; margin-bottom: 0.5rem !important; }
                .d-block.mx-auto { display: block !important; margin-left: auto !important; margin-right: auto !important; }
                
                /* Очистка обтекания */
                .clearfix::after { content: ""; display: table; clear: both; }
            `,
            menubar: false,
            statusbar: true,
            branding: false,
            resize: true,
            
            // Настройки для изображений
            images_upload_url: '/tinymce/upload-image',
            images_upload_credentials: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            paste_data_images: true,
            
            // Настройки диалога изображений  
            image_advtab: true,
            image_uploadtab: true,
            image_title: true,
            image_dimensions: true,
            image_caption: true,
            image_description: true,
            image_class_list_enabled: true,
            
            image_class_list: [
                {title: 'По умолчанию', value: ''},
                {title: 'Обтекание слева', value: 'float-left'},
                {title: 'Обтекание справа', value: 'float-right'},
                {title: 'По центру', value: 'mx-auto d-block'},
                {title: 'Слева с отступом', value: 'float-left me-3 mb-2'},
                {title: 'Справа с отступом', value: 'float-right ms-3 mb-2'},
                {title: 'Адаптивное', value: 'img-fluid'}
            ],
            setup: (editor) => {
                // Автоматическое сохранение при изменении
                editor.on('change keyup', () => {
                    editor.save();
                });
                
                // Синхронизация с Livewire
                editor.on('blur', () => {
                    editor.save();
                });
                
                // Проверяем наличие CSRF токена
                editor.on('init', function() {
                    const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (token) {
                        console.log('CSRF токен найден для TinyMCE:', token.substring(0, 10) + '...');
                    } else {
                        console.warn('CSRF токен не найден в meta теге');
                    }
                });
                
                // Обработчик для сохранения классов изображений
                editor.on('ExecCommand', function(e) {
                    if (e.command === 'mceImage') {
                        setTimeout(() => {
                            // Принудительно сохраняем содержимое после изменения изображения
                            editor.save();
                        }, 100);
                    }
                });
            }
        };
        
        // Инициализируем асинхронно, но не ждем результата
        this.init().catch(error => {
            console.error('Ошибка инициализации TinyMCE Manager:', error);
        });
    }

    async init() {
        console.log('TinyMCEManager.init() вызван');
        if (this.isLoaded || this.isLoading) {
            console.log('TinyMCE уже загружен или загружается');
            return;
        }
        
        this.isLoading = true;
        console.log('Начинаем загрузку TinyMCE');
        
        try {
            // Проверяем, загружен ли уже TinyMCE
            if (typeof tinymce !== 'undefined') {
                console.log('TinyMCE уже загружен в глобальной области');
                this.isLoaded = true;
                this.isLoading = false;
                this.processPendingInitializations();
                return;
            }

            // Загружаем TinyMCE если не загружен
            console.log('Загружаем TinyMCE...');
            await this.loadTinyMCE();
            
            this.isLoaded = true;
            this.isLoading = false;
            console.log('TinyMCE успешно загружен');
            
            // Устанавливаем обработчик изображений
            this.setupImageHandler();
            
            this.processPendingInitializations();
            
            // Слушаем события Livewire
            this.setupLivewireListeners();
            
        } catch (error) {
            console.error('Ошибка загрузки TinyMCE:', error);
            this.isLoading = false;
        }
    }

    async loadTinyMCE() {
        console.log('loadTinyMCE вызван');
        return new Promise((resolve, reject) => {
            // Проверяем, есть ли уже скрипт
            if (document.querySelector('script[src*="tinymce.min.js"]')) {
                console.log('Скрипт TinyMCE уже существует в DOM');
                // Ждем загрузки существующего скрипта
                const checkInterval = setInterval(() => {
                    if (typeof tinymce !== 'undefined') {
                        clearInterval(checkInterval);
                        console.log('TinyMCE обнаружен в глобальной области');
                        resolve();
                    }
                }, 100);
                
                // Таймаут
                setTimeout(() => {
                    clearInterval(checkInterval);
                    console.error('Таймаут ожидания загрузки TinyMCE');
                    reject(new Error('TinyMCE не загрузился'));
                }, 10000);
                return;
            }

            // Создаем и загружаем скрипт
            console.log('Создаем новый скрипт TinyMCE');
            const script = document.createElement('script');
            script.src = '/js/tinymce/tinymce.min.js';
            script.referrerPolicy = 'origin';
            
            script.onload = () => {
                console.log('Скрипт TinyMCE загружен, ждем инициализации...');
                // Ждем инициализации TinyMCE
                const checkInterval = setInterval(() => {
                    if (typeof tinymce !== 'undefined') {
                        clearInterval(checkInterval);
                        console.log('TinyMCE успешно инициализирован');
                        resolve();
                    }
                }, 100);
                
                setTimeout(() => {
                    clearInterval(checkInterval);
                    console.error('Таймаут инициализации TinyMCE');
                    reject(new Error('TinyMCE не инициализировался'));
                }, 5000);
            };
            
            script.onerror = () => {
                console.error('Ошибка загрузки скрипта TinyMCE');
                reject(new Error('Не удалось загрузить TinyMCE'));
            };
            
            console.log('Добавляем скрипт TinyMCE в DOM');
            document.head.appendChild(script);
        });
    }

    setupImageHandler() {
        console.log('setupImageHandler вызван');
        // Не используем handler, полагаемся на images_upload_url с правильными настройками
        console.log('Конфигурация изображений готова');
    }

    setupLivewireListeners() {
        if (typeof Livewire === 'undefined') return;

        // Слушаем события инициализации
        Livewire.on('init-tinymce', () => {
            setTimeout(() => this.initAllEditors(), 100);
        });

        // Слушаем события очистки
        Livewire.on('cleanup-tinymce', () => {
            this.cleanupAllEditors();
        });

        // Синхронизация перед Livewire запросами
        Livewire.hook('morph.updating', () => {
            this.syncAllEditors();
        });

        // Синхронизация при morph
        document.addEventListener('livewire:morph', () => {
            this.syncAllEditors();
        });
    }

    initEditor(selector, customConfig = {}) {
        console.log(`Попытка инициализации TinyMCE для: ${selector}`);
        console.log(`isLoaded: ${this.isLoaded}, tinymce: ${typeof tinymce}`);
        
        if (!this.isLoaded || typeof tinymce === 'undefined') {
            console.log(`TinyMCE не готов, добавляем в очередь: ${selector}`);
            this.pendingInitializations.push({ selector, customConfig });
            return;
        }

        try {
            // Удаляем существующий редактор если есть
            const existingEditor = tinymce.get(selector);
            if (existingEditor) {
                console.log(`Удаляем существующий редактор: ${selector}`);
                tinymce.remove(selector);
            }

            // Объединяем конфигурации
            const config = { ...this.defaultConfig, ...customConfig, selector };
            console.log(`Конфигурация для ${selector}:`, config);
            
            // Инициализируем редактор
            tinymce.init(config);
            
            this.initializedEditors.add(selector);
            
            console.log(`TinyMCE инициализирован для: ${selector}`);
            
        } catch (error) {
            console.error(`Ошибка инициализации TinyMCE для ${selector}:`, error);
        }
    }

    initAllEditors() {
        console.log('initAllEditors вызван');
        
        // Инициализируем все textarea с классом tinymce-editor
        const textareas = document.querySelectorAll('textarea.tinymce-editor');
        console.log(`Найдено textarea с классом tinymce-editor: ${textareas.length}`);
        textareas.forEach(textarea => {
            console.log(`Инициализируем textarea: ${textarea.id}`);
            this.initEditor(`#${textarea.id}`);
        });

        // Инициализируем все textarea с data-tinymce атрибутом
        const tinymceTextareas = document.querySelectorAll('textarea[data-tinymce]');
        console.log(`Найдено textarea с data-tinymce: ${tinymceTextareas.length}`);
        tinymceTextareas.forEach(textarea => {
            const config = this.parseDataConfig(textarea.dataset.tinymce);
            this.initEditor(`#${textarea.id}`, config);
        });
    }

    parseDataConfig(configString) {
        try {
            return JSON.parse(configString);
        } catch (e) {
            return {};
        }
    }

    processPendingInitializations() {
        while (this.pendingInitializations.length > 0) {
            const { selector, customConfig } = this.pendingInitializations.shift();
            this.initEditor(selector, customConfig);
        }
    }

    syncAllEditors() {
        if (typeof tinymce === 'undefined') return;
        
        this.initializedEditors.forEach(selector => {
            const editor = tinymce.get(selector);
            if (editor) {
                editor.save();
            }
        });
    }

    cleanupAllEditors() {
        if (typeof tinymce === 'undefined') return;
        
        this.initializedEditors.forEach(selector => {
            const editor = tinymce.get(selector);
            if (editor) {
                tinymce.remove(selector);
            }
        });
        this.initializedEditors.clear();
    }

    // Метод для обработки загрузки изображений по умолчанию
    defaultImageUploadHandler(blobInfo, progress) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.withCredentials = false;
            xhr.open('POST', '/tinymce/upload-image');
            
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (token) {
                xhr.setRequestHeader('X-CSRF-TOKEN', token);
                console.log('CSRF токен добавлен:', token.substring(0, 20) + '...');
            } else {
                console.warn('CSRF токен не найден в meta теге');
                // Попробуем получить токен из формы
                const form = document.querySelector('form');
                if (form) {
                    const formToken = form.querySelector('input[name="_token"]')?.value;
                    if (formToken) {
                        xhr.setRequestHeader('X-CSRF-TOKEN', formToken);
                        console.log('CSRF токен получен из формы:', formToken.substring(0, 20) + '...');
                    }
                }
            }
            
            // Обработка прогресса загрузки
            if (progress && typeof progress === 'function') {
                xhr.upload.onprogress = (e) => {
                    if (e.lengthComputable) {
                        progress(e.loaded / e.total * 100);
                    }
                };
            }
            
            xhr.onload = function() {
                console.log('Upload response status:', xhr.status);
                console.log('Upload response headers:', xhr.getAllResponseHeaders());
                
                if (xhr.status === 419) {
                    reject({ message: 'CSRF токен истек. Обновите страницу и попробуйте снова.', remove: true });
                    return;
                }
                
                if (xhr.status < 200 || xhr.status >= 300) {
                    reject({ message: 'HTTP Error: ' + xhr.status + ' - ' + xhr.statusText, remove: true });
                    return;
                }
                
                let json;
                try {
                    json = JSON.parse(xhr.responseText);
                } catch (e) {
                    reject({ message: 'Invalid JSON: ' + xhr.responseText, remove: true });
                    return;
                }
                
                if (!json || typeof json.location != 'string') {
                    reject({ message: 'Invalid JSON: ' + xhr.responseText, remove: true });
                    return;
                }
                
                resolve(json.location);
            };
            
            xhr.onerror = function() {
                reject({ message: 'Image upload failed due to a network error', remove: true });
            };
            
            const formData = new FormData();
            formData.append('file', blobInfo.blob(), blobInfo.filename());
            
            // Добавляем CSRF токен в FormData как дополнительную страховку
            if (token) {
                formData.append('_token', token);
            }
            
            xhr.send(formData);
        });
    }
    
    // Метод для загрузки всех изображений перед отправкой формы
    async uploadAllImages() {
        if (typeof tinymce === 'undefined') {
            console.log('TinyMCE не загружен');
            return true;
        }
        
        const editors = tinymce.editors || [];
        console.log('Найдено редакторов:', editors.length);
        
        if (editors.length === 0) {
            console.log('Нет активных редакторов');
            return true;
        }
        
        const uploadPromises = [];
        
        for (let i = 0; i < editors.length; i++) {
            const editor = editors[i];
            if (editor && !editor.isDestroyed() && typeof editor.uploadImages === 'function') {
                try {
                    console.log('Загружаем изображения для редактора:', editor.id);
                    const uploadPromise = editor.uploadImages();
                    uploadPromises.push(uploadPromise);
                } catch (error) {
                    console.error('Ошибка загрузки изображений в редакторе:', editor.id, error);
                }
            }
        }
        
        if (uploadPromises.length === 0) {
            console.log('Нет изображений для загрузки');
            return true;
        }
        
        try {
            await Promise.all(uploadPromises);
            console.log('Все изображения загружены успешно');
            return true;
        } catch (error) {
            console.error('Ошибка при загрузке изображений:', error);
            return false;
        }
    }

    // Публичные методы для внешнего использования
    static getInstance() {
        if (!TinyMCEManager.instance) {
            TinyMCEManager.instance = new TinyMCEManager();
        }
        return TinyMCEManager.instance;
    }

    static initEditor(selector, config) {
        return TinyMCEManager.getInstance().initEditor(selector, config);
    }

    static initAllEditors() {
        return TinyMCEManager.getInstance().initAllEditors();
    }
}

// Настройка CSRF токена для TinyMCE глобально
(function() {
    // Устанавливаем CSRF токен глобально для всех AJAX запросов немедленно
    const originalOpen = XMLHttpRequest.prototype.open;
    const originalSend = XMLHttpRequest.prototype.send;
    
    XMLHttpRequest.prototype.open = function(method, url, async, user, password) {
        this._url = url;
        return originalOpen.apply(this, arguments);
    };
    
    XMLHttpRequest.prototype.send = function(data) {
        if (this._url && this._url.includes('/tinymce/upload-image')) {
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            if (token) {
                this.setRequestHeader('X-CSRF-TOKEN', token);
                console.log('CSRF токен добавлен к запросу TinyMCE:', token.substring(0, 10) + '...');
                
                // Если это FormData, добавляем токен и туда
                if (data instanceof FormData) {
                    data.append('_token', token);
                }
            }
        }
        return originalSend.apply(this, arguments);
    };
    
    console.log('Глобальный перехватчик CSRF для TinyMCE установлен');
})();

// Автоматическая инициализация при загрузке DOM
document.addEventListener('DOMContentLoaded', () => {
    try {
        TinyMCEManager.getInstance();
    } catch (error) {
        console.error('Ошибка при создании TinyMCEManager:', error);
    }
});

// Экспорт для использования в других модулях
window.TinyMCEManager = TinyMCEManager;
