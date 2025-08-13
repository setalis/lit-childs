# TinyMCE Manager - Настройка и использование

## Описание

TinyMCE Manager - это централизованное решение для управления редактором TinyMCE в Laravel приложении. Решает основные проблемы:

- ✅ Надежная загрузка TinyMCE
- ✅ Автоматическая инициализация редакторов
- ✅ Интеграция с Livewire
- ✅ Централизованное управление конфигурацией
- ✅ Автоматическая синхронизация данных

## Установка

### 1. Файлы

Убедитесь, что у вас есть следующие файлы:

- `resources/js/tinymce-manager.js` - основной менеджер
- `resources/js/app.js` - подключение менеджера
- TinyMCE библиотека в `public/js/tinymce/`

### 2. Подключение

В `resources/js/app.js`:
```javascript
import './tinymce-manager.js';
```

### 3. Компиляция

```bash
npm run build
```

## Использование

### Простая инициализация

Добавьте класс `tinymce-editor` к textarea:

```html
<textarea 
    id="my-editor" 
    class="tinymce-editor"
    rows="6">
</textarea>
```

### Кастомная конфигурация

Используйте атрибут `data-tinymce`:

```html
<textarea 
    id="custom-editor" 
    data-tinymce='{"height": 300, "plugins": ["lists", "link"]}'
    class="tinymce-editor">
</textarea>
```

### Программная инициализация

```javascript
// Инициализация конкретного редактора
TinyMCEManager.initEditor('#my-editor', {
    height: 400,
    plugins: ['lists', 'link', 'image']
});

// Инициализация всех редакторов
TinyMCEManager.initAllEditors();
```

## Конфигурация по умолчанию

```javascript
{
    height: 400,
    plugins: [
        'advlist', 'autolink', 'lists', 'link', 'image', 'charmap', 'preview',
        'anchor', 'searchreplace', 'visualblocks', 'code', 'fullscreen',
        'insertdatetime', 'media', 'table', 'help', 'wordcount', 'codesample'
    ],
    toolbar: 'undo redo | blocks | bold italic backcolor | alignleft aligncenter ' +
        'alignright alignjustify | bullist numlist outdent indent | ' +
        'image | codesample code | removeformat | help',
    content_style: 'body { font-family:Helvetica,Arial,sans-serif; font-size:16px } ' +
        'ol { list-style-type: decimal; margin-left: 20px; } ' +
        'ul { list-style-type: disc; margin-left: 20px; }',
    menubar: false,
    statusbar: true,
    branding: false,
    resize: true,
    // Настройки для изображений
    images_upload_url: '/tinymce/upload-image',
    images_upload_handler: defaultImageUploadHandler,
    image_title: true,
    automatic_uploads: true,
    file_picker_types: 'image',
    image_advtab: true,
    image_dimensions: true,
    image_class_list: [
        {title: 'Responsive', value: 'img-fluid'},
        {title: 'Thumbnail', value: 'img-thumbnail'},
        {title: 'Rounded', value: 'rounded'},
        {title: 'Circle', value: 'rounded-circle'}
    ]
}
```

## Интеграция с Livewire

### События

```javascript
// Инициализация редакторов
Livewire.on('init-tinymce', () => {
    TinyMCEManager.initAllEditors();
});

// Очистка редакторов
Livewire.on('cleanup-tinymce', () => {
    TinyMCEManager.getInstance().cleanupAllEditors();
});
```

### Автоматическая синхронизация

TinyMCE Manager автоматически синхронизирует данные с textarea при:
- Изменении содержимого
- Потере фокуса
- Livewire запросах

## Примеры использования

### 1. Создание/редактирование фигур

```html
<textarea 
    name="biography" 
    id="biography" 
    class="tinymce-editor"
    required>
</textarea>
```

### 2. Управление контентом подразделов

```html
<textarea 
    name="elementContentText" 
    id="elementContentText" 
    data-tinymce='{"height": 400, "plugins": ["image"], "images_upload_url": "/tinymce/upload-image"}'
    class="tinymce-editor">
</textarea>
```

### 3. Создание/редактирование терминов

```html
<textarea 
    name="definitions[0][definition]" 
    id="definition_0"
    class="tinymce-editor"
    required>
</textarea>
```

## Тестирование

Перейдите на `/test/tinymce` для проверки работы всех типов редакторов.

## Работа з зображеннями

### Автоматична підтримка

TinyMCE Manager автоматично налаштовує підтримку зображень для всіх редакторів. Зображення можна вставляти:

1. **Кнопка зображення** - натисніть на іконку зображення в панелі інструментів
2. **Перетягування** - перетягніть файл з комп'ютера прямо в редактор
3. **Вставка з буфера** - скопіюйте зображення (Ctrl+C) і вставте (Ctrl+V)
4. **Файловий менеджер** - використовуйте діалог вибору файлів

### Налаштування зображень

Після вставки зображення можна:
- Змінювати розмір перетягуванням за кути
- Налаштовувати вирівнювання (ліворуч, по центру, праворуч)
- Додавати опис (alt текст)
- Застосовувати CSS класи (responsive, thumbnail, rounded, circle)
- Налаштовувати відступи та рамки

### Приклад редактора з зображеннями

```html
<textarea 
    id="image-editor" 
    class="tinymce-editor"
    data-tinymce='{"height": 400, "image_advtab": true, "image_dimensions": true}'>
</textarea>
```

### Тестування зображень

Перейдіть на `/test/tinymce-images` для детального тестування роботи з зображеннями.

## Решение проблем

### TinyMCE не загружается

1. Проверьте, что файл `tinymce.min.js` находится в `public/js/tinymce/`
2. Убедитесь, что `npm run build` выполнен успешно
3. Проверьте консоль браузера на ошибки

### Редакторы не инициализируются

1. Убедитесь, что у textarea есть класс `tinymce-editor`
2. Проверьте, что TinyMCEManager доступен в консоли
3. Убедитесь, что у textarea есть уникальный `id`

### Проблемы с Livewire

1. Проверьте, что события `init-tinymce` и `cleanup-tinymce` отправляются
2. Убедитесь, что TinyMCEManager слушает события Livewire
3. Проверьте синхронизацию данных перед отправкой форм

## API Reference

### TinyMCEManager

#### Статические методы

- `TinyMCEManager.getInstance()` - получить экземпляр менеджера
- `TinyMCEManager.initEditor(selector, config)` - инициализировать редактор
- `TinyMCEManager.initAllEditors()` - инициализировать все редакторы

#### Методы экземпляра

- `initEditor(selector, config)` - инициализировать редактор
- `initAllEditors()` - инициализировать все редакторы
- `cleanupAllEditors()` - очистить все редакторы
- `syncAllEditors()` - синхронизировать все редакторы

## Обновления

### v1.0.0
- Базовая функциональность
- Интеграция с Livewire
- Автоматическая загрузка TinyMCE
- Централизованное управление конфигурацией
