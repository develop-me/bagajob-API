<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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

    public function messages()
    {
        return [
            'unique' => 'A user account exists already with this :attribute',
            'required' => 'A :attribute is required to create a user account'
        ];
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // validation rules
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required','email','unique:App\Models\User,email'],
            'password' => ['required']
        ];
    }

}
