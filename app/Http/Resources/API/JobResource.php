<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'job_title' => $this->job_title,
            'company' => $this->company,
            'status' => $this->status,
            'location' => $this->location,
            'salary' => $this->salary,
            'closing_date' => $this->closing_date,
            'application_date' => $this->application_date,
            'description' => $this->description,
            'recruiter_name' => $this->recruiter_name,
            'recruiter_email' => $this->recuiter_email,
            'recruiter_phone' => $this->recruiter_phone,
            'stage' => $this->stage,
            'interviews' => $this->interviews,
            'application_notes' => $this->notes
        ];
    }
}
