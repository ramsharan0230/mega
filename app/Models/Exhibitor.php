<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;

class Exhibitor extends Model
{
    use Sluggable;
    protected $table = 'exhibitors';
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function exhibitor_user()
    {
        return $this->belongsTo('App\User', 'user_id')->where('role', 'exhibitor');
    }

    public function branches()
    {
        return $this->hasMany('App\Models\Branch', 'exhibitor_id');
    }

    public function scholarships()
    {
        return $this->hasMany('App\Models\Scholarship', 'exhibitor_id')->where('type', 'scholarship');
    }

    public function institutions()
    {
        return $this->hasMany('App\Models\Scholarship', 'exhibitor_id')->where('type', 'institution');
    }

    public function datetimes()
    {
        return $this->hasMany('App\Models\Datetime', 'exhibitor_id');
    }

    public function videobook()
    {
        return $this->hasMany('App\Models\Videobook', 'exhibitor_id');
    }

    public function refer()
    {
        return $this->hasMany('App\Models\Refer', 'exhibitor_id');
    }

    public function visitors()
    {
        return $this->hasMany('App\Models\Visitor', 'exhibitor_id');
    }

    /*
    * Multiple relationships
    **/

    public function countries()
    {
        return $this->belongsToMany('App\Models\Country', 'country_exhibitor', 'exhibitor_id', 'country_id')->withTimestamps();
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
