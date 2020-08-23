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
            'job_title' => ['required', 'string', 'max:50'],
            'company' => ['required', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:8'],
            'location' => ['required', 'string', 'max:50'],
            'salary' => ['nullable', 'numeric'],
            'closing date' => ['nullable', 'date'],
            'date applied' => ['nullable', 'date'],
            'description' => ['nullable', 'string','max:500'],
            'recruiter name' => ['nullable', 'string'],
            'recruiter email' => ['nullable', 'email'],
            'recruiter phone' => ['nullable', 'string', 'max:9'],
            'stage' => ['required', 'integer', 'between:,4'],
        ];
    }
}
