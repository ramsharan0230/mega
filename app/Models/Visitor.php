<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $guarded = ['id'];

    public function student()
    {
        return $this->belongsTo('App\User', 'user_id')->where('role', 'customer');
    }

    public function exhibitor()
    {
        return $this->belongsTo('App\Models\Exhibitor', 'exhibitor_id');
    }
}
