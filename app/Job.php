<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    //setting up the one to many relationship between jobs and other tables

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
