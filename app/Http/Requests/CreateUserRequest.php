<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
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
            'username' => ['required'],
            'email' => ['nullable'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required']
        ];
    }

    /**
     * Get the data set.
     *
     * @return bool
     */
    public function data()
    {
        return $this->only('name', 'username', 'email', 'password', 'is_valid');
    }
}
