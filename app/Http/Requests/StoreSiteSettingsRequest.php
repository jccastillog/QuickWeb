<?php

// app/Http/Requests/StoreSiteSettingsRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'phone' => 'required|string|max:20',
            'whatsapp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'street_address' => 'required|string|max:255',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'about_text' => 'required|string',
            'business_hours' => 'required|string|max:255',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:50'
        ];
    }
}