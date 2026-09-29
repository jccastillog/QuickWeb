<?php

// app/Http/Requests/StoreClientRequest.php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ValidatesClientPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreClientRequest extends FormRequest
{
    use ValidatesClientPlan;

    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->normalizeCustomDomain();
    }

    public function rules()
    {
        return [
            ...$this->planRules(null),
            'store_name' => 'required|string|max:255',
            'domain' => 'required|string|max:255|unique:clients,domain',
            'primary_color' => 'nullable|string|max:7|starts_with:#',
            'secondary_color' => 'nullable|string|max:7|starts_with:#',
            'theme' => 'nullable|in:light,dark',
            'timezone' => 'nullable|string|max:255',
            'font' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'favicon' => 'nullable|image|mimes:png,ico|max:1024',
        ];
    }

    public function messages()
    {
        return [
            ...$this->planMessages(),
            'domain.unique' => 'El dominio ya está en uso por otra tienda',
            'primary_color.starts_with' => 'El color debe ser un código hexadecimal (ej: #007bff)',
            'secondary_color.starts_with' => 'El color debe ser un código hexadecimal (ej: #6c757d)'
        ];
    }
}
