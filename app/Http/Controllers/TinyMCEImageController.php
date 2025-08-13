<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyMCEImageController extends Controller
{
    public function upload(Request $request)
    {
        try {
            // Логируем запрос для отладки
            \Log::info('TinyMCE upload request', [
                'has_file' => $request->hasFile('file'),
                'all_data' => $request->all(),
                'headers' => $request->headers->all(),
                'csrf_token' => $request->header('X-CSRF-TOKEN'),
                'x_csrf_token' => $request->header('X-CSRF-TOKEN'),
                'form_token' => $request->input('_token'),
                'session_token' => $request->session()->token(),
                'user_agent' => $request->header('User-Agent'),
                'referer' => $request->header('Referer')
            ]);
            
            // Логируем состояние CSRF токена для отладки
            \Log::info('CSRF token check', [
                'header_token' => $request->header('X-CSRF-TOKEN'),
                'form_token' => $request->input('_token'),
                'session_token' => $request->session()->token(),
                'has_header' => !empty($request->header('X-CSRF-TOKEN')),
                'has_form' => !empty($request->input('_token'))
            ]);
            
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                
                // Проверяем, что это изображение
                if (!$file->isValid() || !in_array($file->getMimeType(), ['image/jpeg', 'image/png', 'image/gif', 'image/webp'])) {
                    return response()->json([
                        'error' => [
                            'message' => 'Дозволені тільки зображення (JPEG, PNG, GIF, WebP)'
                        ]
                    ], 400);
                }
                
                // Проверяем размер файла (максимум 5MB)
                if ($file->getSize() > 5 * 1024 * 1024) {
                    return response()->json([
                        'error' => [
                            'message' => 'Розмір файлу не може перевищувати 5MB'
                        ]
                    ], 400);
                }
                
                // Генерируем уникальное имя файла
                $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                
                // Сохраняем файл в storage/app/public/tinymce_images
                $path = $file->storeAs('tinymce_images', $fileName, 'public');
                
                // Логируем успешную загрузку
                \Log::info('TinyMCE file uploaded successfully', [
                    'filename' => $fileName,
                    'path' => $path,
                    'size' => $file->getSize()
                ]);
                
                // Возвращаем URL для TinyMCE
                return response()->json([
                    'location' => Storage::url($path),
                    'filename' => $fileName,
                    'size' => $file->getSize()
                ]);
            }
            
            return response()->json([
                'error' => [
                    'message' => 'Файл не знайдено'
                ]
            ], 400);
            
        } catch (\Exception $e) {
            \Log::error('TinyMCE upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'error' => [
                    'message' => 'Помилка завантаження: ' . $e->getMessage()
                ]
            ], 500);
        }
    }
} 