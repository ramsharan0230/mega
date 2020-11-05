<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function exhibitor()
    {
        return $this->belongsTo('App\Models\Exhibitor', 'exhibitor_id');
    }
}
