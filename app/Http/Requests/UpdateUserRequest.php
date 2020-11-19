<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use App\Exceptions\UserNotFoundException;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'email' => ['sometimes', 'required', 'unique:users,email'],
            'old_password' => ['required'],
            'password' => ['sometimes', 'required', 'confirmed'],
            'avatar' => ['sometimes', 'nullable'],
        ];
    }

    /**
     * Get the data.
     *
     * @return array
     */
    public function data()
    {
        return $this->only('email', 'password');
    }

    /**
     * Get the validator instance for the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();

        $validator->after(function($validator) {
            $user = $this->user();

            // Validate if user found.
            if(!$user){
                throw new UserNotFoundException;
            }

            // Validate user old password is correct.
            if(!Hash::check($this->old_password, $user->password)){
                $validator->errors()->add('old_password', Lang::get('passwords.password.old.match'));
            }
        });

        return $validator;
    }
}
