<?php

// app/Http/Requests/StoreCategoryRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'featured' => 'nullable|boolean'  ,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
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
