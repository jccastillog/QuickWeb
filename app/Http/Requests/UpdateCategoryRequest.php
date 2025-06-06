<?php

// app/Http/Requests/UpdateCategoryRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $category = $this->route('category');
        
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id)
            ],
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'featured' => 'nullable|boolean',
            'image' => 'nullable|image|max:2048' // 2MB máximo para imágenes
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Ya existe una categoría con este nombre',
            'image.max' => 'La imagen no debe pesar más de 2MB',
            'image.image' => 'El archivo debe ser una imagen válida'
        ];
    }
}