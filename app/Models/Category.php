<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Category extends Model
{
    use Sluggable;
    protected $table = 'categories';
    protected $fillable = ['title', 'publish', 'slug', 'image', 'logo',];

    public function exhibitors()
    {
        return $this->hasMany('App\Models\Exhibitor', 'category_id');
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
