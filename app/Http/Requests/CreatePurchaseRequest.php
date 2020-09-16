<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app' => ['required', 'in:'.implode(',', \App\Enums\Store::getValues())],
            'receipt' => ['sometimes', 'nullable'],
            'product_id' => ['sometimes', 'nullable'],
            'purchase_token' => ['sometimes', 'nullable'],
        ];
    }

    /**
     * Get the data.
     *
     * @return array
     */
    public function data()
    {
        return $this->only('app', 'receipt', 'purchase_token');
    }
}
