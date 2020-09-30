<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ApplicationNote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'application_notes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'date',
        'data',
    ];

    public function job()
    {
        // a note belongs to an job
        return $this->belongsTo(Job::class);
    }
}
