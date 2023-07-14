<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserProfile extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'user_id', 'position', 'phone1', 'phone2', 'address', 'city', 'country', 'user_image_id',
    ];

    protected $dates = ['created_at','updated_at', 'deleted_at'];

    public function image()
    {
        return $this->belongsTo(Media::class, 'user_image_id');
    }

    /**
     * TODO: Delete the relation of userprofile
     */
    // protected static function boot() {
    //     parent::boot();
        
    //     static::deleting(function($userProfile) {
    //         $userProfile->image()->delete();
    //     });
    // } 
}
