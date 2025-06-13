<?php

// app/Http/Requests/UpdateProductRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $product = $this->route('product');

        return [
            'category_id' => 'required|exists:categories,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id)
            ],
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'compare_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'sku' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products')->ignore($product->id)
            ],
            'barcode' => [
                'nullable',
                'string',
                'max:100',
                Rule::unique('products')->ignore($product->id)
            ],
            'featured' => 'required|boolean',
            'active' => 'required|boolean',
            'image' => 'nullable|image|max:2048' // Para múltiples imágenes
        ];
    }

    public function messages()
    {
        return [
            'category_id.exists' => 'La categoría seleccionada no existe',
            'name.unique' => 'Ya existe un producto con este nombre',
            'sku.unique' => 'Este SKU ya está en uso',
            'barcode.unique' => 'Este código de barras ya está en uso',
            'price.min' => 'El precio no puede ser negativo',
            'compare_price.min' => 'El precio de comparación no puede ser negativo',
            'stock.min' => 'El stock no puede ser negativo',
            'image.*.max' => 'Cada imagen no debe pesar más de 2MB',
            'image.*.image' => 'Todos los archivos deben ser imágenes válidas'
        ];
    }

    public function attributes()
    {
        return [
            'image.*' => 'imagen'
        ];
    }
}
