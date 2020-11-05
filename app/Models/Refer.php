<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Refer extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function exhibitor()
    {
        return $this->belongsTo('App\Models\Exhibitor', 'exhibitor_id');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id')->where('role', 'customer');
    }
}
