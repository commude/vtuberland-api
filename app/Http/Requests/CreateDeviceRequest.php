<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDeviceRequest extends FormRequest
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
            'name' => ['required'],
            'manufacturer' => ['required'],
            'os' => ['required'],
            'version' => ['nullable'],
            'language' => ['nullable'],
            'key' => ['required'],
        ];
    }

    /**
     * Get the data set.
     *
     * @return bool
     */
    public function data()
    {
        return $this->only('username', 'password');
    }
}
