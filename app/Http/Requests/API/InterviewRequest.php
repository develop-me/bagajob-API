<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;

class InterviewRequest extends FormRequest
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
                //validation rules for interview creation
                'interview_date' => ['required', 'date'],
                'format' => ['required', 'string', 'max:50'],
                'interviewer' => ['nullable', 'string', 'max:250'],
                'notes' => ['nullable', 'string','max:500'],
        ];
    }
}
