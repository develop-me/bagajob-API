<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;



class UserAccountRequest extends FormRequest
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
            'name' => ['string', 'max:255'],
            'email' => ['email',Rule::unique('users')->ignore(Auth::id())], // this ingores the email duplicate if it's the user requesting to change their email to the same email
        ];
    }
}
