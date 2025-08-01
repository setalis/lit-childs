<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TinyMCEImageController extends Controller
{
    public function upload(Request $request)
    {
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
            
            // Генерируем уникальное имя файла
            $fileName = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
            
            // Сохраняем файл в storage/app/public/tinymce_images
            $path = $file->storeAs('tinymce_images', $fileName, 'public');
            
            // Возвращаем URL для TinyMCE
            return response()->json([
                'location' => Storage::url($path)
            ]);
        }
        
        return response()->json([
            'error' => [
                'message' => 'Файл не знайдено'
            ]
        ], 400);
    }
} 