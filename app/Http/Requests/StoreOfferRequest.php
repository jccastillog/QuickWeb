<?php

// app/Http/Requests/StoreOfferRequest.php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOfferRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'product_id' => 'nullable|exists:products,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'discount' => 'nullable|numeric|min:0|max:100',
            'discount_amount' => 'nullable|numeric|min:0',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'active' => 'nullable|boolean'
        ];
    }

    public function messages()
    {
        return [
            'end_date.after' => 'La fecha de finalización debe ser posterior a la fecha de inicio',
            'product_id.exists' => 'El producto seleccionado no existe'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->discount && !$this->discount_amount) {
                $validator->errors()->add('discount', 'Debe especificar al menos un descuento (porcentaje o monto fijo)');
            }
        });
    }
}