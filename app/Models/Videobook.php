<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Videobook extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function exhibitor()
    {
        return $this->belongsTo('App\Models\Exhibitor', 'exhibitor_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function datetime()
    {
        return $this->belongsTo('App\Models\Datetime', 'datetime_id');
    }
}
