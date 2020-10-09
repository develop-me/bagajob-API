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
            'title' => $this->title,
            'company' => $this->company,
            'active' => $this->active,
            'location' => $this->location,
            'salary' => $this->salary,
            'closing_date' => $this->closing_date,
            'date_applied' => $this->date_applied,
            'description' => $this->description,
            'stage' => $this->stage,
            'interviews' => $this->interviews,
            'application_notes' => $this->notes,
            'cv' => $this->cv,
            'cover_letter' => $this->cover_letter
        ];
    }
}
