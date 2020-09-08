<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['sometimes', 'required'],
            'username' => ['sometimes', 'required'],
            'email' => ['sometimes', 'nullable'],
            'password' => ['sometimes', 'required', 'confirmed'],
            'password_confirmation' => ['sometimes', 'required']
        ];
    }

    /**
     * Get the data set.
     *
     * @return bool
     */
    public function data()
    {
        return $this->only('name', 'email', 'username', 'password');
    }
}
