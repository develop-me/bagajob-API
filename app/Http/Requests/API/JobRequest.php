<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class JobRequest extends FormRequest
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
            //validation rules for job entry creation
            'title' => ['required', 'string', 'max:50'],
            'company' => ['required', 'string', 'max:50'],
            'active' => ['required', 'boolean'],
            'location' => ['nullable', 'string', 'max:50'],
            'salary' => ['nullable', 'numeric'],
            'closing_date' => ['nullable', 'date'],
            'date_applied' => ['nullable', 'date'],
            'description' => ['nullable', 'string','max:500'],
            'stage' => ['required', 'integer', 'between:1,4'],
        ];
    }
}
