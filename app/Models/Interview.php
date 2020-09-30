<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Interview extends Model
{
    use HasFactory;
    
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
