<?php

// app/Http/Requests/PlanRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PlanRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'allows_custom_domain' => $this->boolean('allows_custom_domain'),
            'highlighted' => $this->boolean('highlighted'),
            'active' => $this->boolean('active'),
            // Vacío = ilimitado
            'product_limit' => $this->filled('product_limit') ? $this->input('product_limit') : null,
        ]);
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'slug' => [
                'required',
                'alpha_dash',
                'max:100',
                Rule::unique('plans', 'slug')->ignore($this->route('plan')),
            ],
            'description' => 'nullable|string|max:500',
            'features' => 'nullable|string|max:2000',
            'price' => 'required|numeric|min:0',
            'product_limit' => 'nullable|integer|min:1',
            'allows_custom_domain' => 'boolean',
            'highlighted' => 'boolean',
            'active' => 'boolean',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'slug.unique' => 'Ya existe un plan con este identificador',
            'slug.alpha_dash' => 'El identificador solo puede tener letras, números y guiones',
        ];
    }
}
