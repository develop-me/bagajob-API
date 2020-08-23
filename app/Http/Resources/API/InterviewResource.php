<?php

namespace App\Http\Resources\API;

use Illuminate\Http\Resources\Json\JsonResource;

class InterviewResource extends JsonResource
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
            'interview_date' => $this->interview_date,
            'format' => $this->format,
            'interviewer' => $this->interviewer,
            'notes' => $this->notes,
        ];
    }
}
