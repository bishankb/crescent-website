<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    protected $table = 'contact_us';

	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'phone1', 'phone2', 'phone3', 'phone4', 'address', 'email', 'facebook', 'twitter', 'google_plus', 'map_embedded_link'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
