<?php

// app/Http/Requests/StoreClientRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'store_name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:clients,domain',
            'primary_color' => 'nullable|string|max:7|starts_with:#',
            'secondary_color' => 'nullable|string|max:7|starts_with:#',
            'theme' => 'nullable|in:light,dark',
            'timezone' => 'nullable|string|max:255',
            'font' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
            'logo' => 'nullable|image|max:2048',
            'favicon' => 'nullable|image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'domain.unique' => 'El dominio ya está en uso por otra tienda',
            'primary_color.starts_with' => 'El color debe ser un código hexadecimal (ej: #007bff)',
            'secondary_color.starts_with' => 'El color debe ser un código hexadecimal (ej: #6c757d)'
        ];
    }
}