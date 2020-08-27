<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Interview extends Model
{
    public function job()
    {
        //an interview belongs to an job
        return $this->belongsTo(Job::class);
    }
}
