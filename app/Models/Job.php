<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'active',
        'location',
        'salary',
        'closing_date',
        'date_applied',
        'description',
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
