<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /*
    * Multiple relationships
    **/

    public function exhibitors()
    {
        return $this->belongsToMany('App\Models\Exhibitor', 'country_exhibitor', 'country_id', 'exhibitor_id')->withTimestamps();
    }
}
