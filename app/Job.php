<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'job_title',
        'active',
        'location',
        'salary',
        'closing date',
        'date applied',
        'description',
        'recruiter name',
        'recruiter email',
        'recruiter phone',
        'stage',
        'company'
    ];

    // User Relationship
    public function user()
    {
        // a job belongs to a user
        return $this->belongsTo(User::class);
    }

    public function notes()
    {
        //job can have many notes attached
        return $this->hasMany(ApplicationNote::class);
    }

    public function interviews()
    {
        //job can also have many interview stages
        return $this->hasMany(Interview::class);

    }
}
