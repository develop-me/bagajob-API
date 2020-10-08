<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JobUpdateRequest extends FormRequest
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
            //validation rules for job updates (PATCH)
            'title' => ['string', 'max:50'],
            'company' => [ 'string', 'max:50'],
            'active' => [ 'boolean'],
            'location' => ['string', 'max:50'],
            'salary' => ['numeric'],
            'closing_date' => ['date'],
            'date_applied' => ['date'],
            'description' => ['string','max:500'],
            'stage' => [ 'integer', 'between:1,4'],
            'cv'=> ['string', 'max:255' ],
            'cover_letter'=> ['string', 'max:255' ],
        ];
    }
}
