<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Galleryimage extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function gallery()
    {
      return $this->belongsTo('App\Models\Gallery', 'gallery_id');
    }
}
