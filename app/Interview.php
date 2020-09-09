<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'interview_date',
        'format',
        'interviewer',
        'notes'
    ];

    public function job()
    {
        //an interview belongs to an job
        return $this->belongsTo(Job::class);
    }
}
