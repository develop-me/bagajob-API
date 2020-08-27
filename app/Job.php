<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //setting up the one to many relationship between jobs and other tables

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

    public function notes()
    {
        //job can have many notes attached
        return $this->hasMany(Application_Note::class);
    }

    public function interviews()
    {
        //job can also have many interview stages
        return $this->hasMany(Interview::class);

    }
}
