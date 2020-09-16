<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                'date' => ['required', 'date'],
                'format' => [
                    'required', 
                    Rule::in([ 'online_testing','telephone', 'video_call', 'in_person',]), 
                    'max:50'],
                'interviewer' => ['nullable', 'string', 'max:250'],
                'notes' => ['nullable', 'string','max:500'],
        ];
    }
}
