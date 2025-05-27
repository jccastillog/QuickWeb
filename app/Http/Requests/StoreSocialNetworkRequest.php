<?php

// app/Http/Requests/StoreSocialNetworkRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSocialNetworkRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'platform' => 'required|in:facebook,instagram,twitter,youtube,linkedin,tiktok,whatsapp',
            'url' => 'required|url|max:255',
            'icon_class' => 'nullable|string|max:50',
            'order' => 'nullable|integer|min:0',
            'active' => 'nullable|boolean'
        ];
    }
}