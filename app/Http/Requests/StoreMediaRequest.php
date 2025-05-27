<?php

// app/Http/Requests/StoreMediaRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'file' => 'required|file|mimes:jpeg,png,gif,webp|max:5120', // 5MB
            'collection' => 'required|string|max:50',
            'custom_properties' => 'nullable|array'
        ];
    }

    public function messages()
    {
        return [
            'file.max' => 'El archivo no debe pesar más de 5MB',
            'file.mimes' => 'Solo se permiten imágenes (JPEG, PNG, GIF, WEBP)'
        ];
    }
}