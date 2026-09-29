<?php

// app/Http/Requests/UpdateClientRequest.php

namespace App\Http\Requests;

use App\Http\Requests\Concerns\ValidatesClientPlan;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
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
            ...$this->planRules($this->route('client')),
            'store_name' => 'sometimes|string|max:255',
            'domain' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('clients', 'domain')->ignore($this->route('client'))
            ],
            'primary_color' => 'nullable|string|max:7|starts_with:#',
            'secondary_color' => 'nullable|string|max:7|starts_with:#',
            'theme' => 'nullable|in:light,dark',
            'font' => 'nullable|string|max:255',
            'timezone' => 'nullable|string|max:255',
            'active' => 'nullable|boolean',
            'expires_at' => 'nullable|date',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'favicon' => 'nullable|image|mimes:png,ico|max:1024',
            'remove_logo' => 'nullable|boolean',
            'remove_favicon' => 'nullable|boolean',
        ];
    }

    public function messages()
    {
        return $this->planMessages();
    }
}
