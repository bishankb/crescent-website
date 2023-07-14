<?php

namespace App;

use App\BaseModel;

class Category extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'category_for', 'slug', 'status', 'created_by', 'updated_by'
    ];

    public function blogs()
    {
    	return $this->hasMany(Blog::class, 'category_id');
    }
}
