<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Scholarship extends Model
{
    use Sluggable;
    protected $table = 'scholarships';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function exhibitor()
    {
        return $this->belongsTo('App\Models\Exhibitor', 'exhibitor_id');
    }

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title',
                'onUpdate' => true
            ]
        ];
    }
}
