<?php

namespace App\Http\Requests;

use App\Enums\Locale;
use App\Enums\OperatingSystem;
use Illuminate\Foundation\Http\FormRequest;

class CreateUserRequest extends FormRequest
{
    use \App\Http\Requests\Traits\ValidationErrorResponseCustomizer;

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
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'confirmed'],
            'password_confirmation' => ['required'],
            'avatar' => ['sometimes', 'nullable'],
            'manufacturer' => ['required'],
            'os' => ['required', 'in:' . implode(',', OperatingSystem::getValues())],
            'version' => ['nullable'],
            'language' => ['sometimes', 'nullable', 'in:' . implode(',', Locale::getValues())],
        ];
    }

    /**
     * Get the data set.
     *
     * @return bool
     */
    public function data()
    {
        return $this->only('name', 'email', 'password', 'manufacturer', 'os', 'version', 'language');
    }
}
