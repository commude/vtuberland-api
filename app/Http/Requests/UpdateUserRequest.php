<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
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
            'email' => ['sometimes', 'nullable'],
            'name' => ['sometimes', 'nullable'],
            'old_password' => ['sometimes', 'required'],
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
        return $this->only('name', 'email', 'password');
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

            if($this->has('email')){
                if($user->email != $this->email){
                    if(!is_null(User::firstWhere('email', $this->email))){
                        $validator->errors()->add('email', Lang::get('auth.exists'));
                    }
                }
            }

            // Validate user old password is correct.
            if(!Hash::check($this->old_password, $user->password)){
                $validator->errors()->add('old_password', Lang::get('passwords.password.old.match'));
            }
        });

        return $validator;
    }
}
