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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'Ya existe una categoría con este nombre',
            'categoryImage.max' => 'La imagen no debe pesar más de 2MB',
            'categoryImage.image' => 'El archivo debe ser una imagen válida'
        ];
    }
}
