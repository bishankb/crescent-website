<?php

namespace App;

use App\BaseModel;

class Tag extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'tag_for', 'slug', 'status', 'created_by', 'updated_by'
    ];

    public function blogs()
    {
        return $this->belongsToMany(Blog::class);
    }
}
