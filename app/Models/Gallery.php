<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function imagegallery()
    {
      return $this->hasMany('App\Models\Galleryimage', 'gallery_id');
    }

    public function scopePublished($query)
    {
      return $query->wherePublished(1);
    }
}
