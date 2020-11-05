<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Messagefile extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function message()
    {
        return $this->belongsTo('App\Models\Message', 'message_id');
    }
}
