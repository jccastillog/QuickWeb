<?php

// app/Http/Requests/StoreProductRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => 'nullable|string|max:100',
            'barcode' => 'nullable|string|max:100',
            'featured' => 'nullable|boolean',
            'active' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'category_id.exists' => 'La categoría seleccionada no existe',
            'price.min' => 'El precio no puede ser negativo',
            'compare_price.min' => 'El precio de comparación no puede ser negativo',
            'stock.min' => 'El stock no puede ser negativo'
        ];
    }
}