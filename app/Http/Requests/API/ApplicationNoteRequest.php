<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationNoteRequest extends FormRequest
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
            //validation rules for note creation
            'note_name' => ['required', 'string', 'max:50'],
            'date' => ['required', 'date'],
            'body' => ['nullable', 'string','max:500'],
        ];
    }
}