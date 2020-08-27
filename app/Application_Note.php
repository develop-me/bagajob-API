<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Application_Note extends Model
{
    public function job()
    {
        // a note belongs to an job
        return $this->belongsTo(Job::class);
    }
}
