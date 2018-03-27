<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['name', 'location', 'contact_phone'];

    /**
     * The users that work for the agency
     */
    public function users()
    {
        return $this->belongsToMany('App\User');
    }
}
