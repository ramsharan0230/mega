<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function student()
    {
        return $this->belongsTo('App\User', 'sender_id')->where('role', 'customer');
    }

    public function receiver()
    {
        return $this->belongsTo('App\User', 'receiver_id')->where('role', 'exhibitor');
    }
}
