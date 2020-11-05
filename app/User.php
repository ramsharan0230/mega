<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'image', 'publish', 'access_level', 'role', 'logo', 'type', 'activation_link', 'address', 'mobile', 'academic_qualification', 'gpa', 'passed_year', 'interested_course', 'interested_country', 'proficiency_test', 'redirect_to', 'country_code', 'know_about', 'district', 'country', 'otp',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function exhibitor()
    {
        return $this->hasOne('App\Models\Exhibitor', 'user_id');
    }

    public function scholars()
    {
        return $this->hasMany('App\Models\Scholarship', 'exhibitor_id');
    }

    public function video_books()
    {
        return $this->hasMany('App\Models\Videobook', 'user_id');
    }

    public function refer()
    {
        return $this->hasMany('App\Models\Refer', 'student_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'sender_id');
    }

    public function visitors()
    {
        return $this->hasMany('App\Models\Visitor', 'user_id');
    }
}

// public function category()
// {
//     return $this->belongsTo('App\Models\Category', 'category_id');
// }

// public function datetimes()
// {
//     return $this->hasMany('App\Models\Datetime', 'exhibitor_id');
// }