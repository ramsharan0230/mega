<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Datetime extends Model
{
    protected $table = 'datetimes';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function exhibitor()
    {
        return $this->belongsTo('App\Models\Exhibitor', 'exhibitor_id');
    }

    public function video_book()
    {
        return $this->hasMany('App\Models\Videobook', 'datetime_id');
    }
}
