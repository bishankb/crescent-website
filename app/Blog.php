<?php

namespace App;

use App\BaseModel;

class Blog extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'category_id', 'blog_image_id', 'status', 'created_by', 'updated_by'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'blog_tag', 'blog_id', 'tag_id');
    }

    public function tagsIds()
    {
        $tagsIds = [];
        foreach ($this->tags as $tag) {
            array_push($tagsIds, $tag->id);
        }

        return $tagsIds;
    }

    public function tagsTitles()
    {
        $tagsTitles = [];
        foreach ($this->tags as $tag) {
            array_push($tagsTitles, $tag->title);
        }

        return $tagsTitles;
    }

    public function image()
    {
        return $this->belongsTo(Media::class, 'blog_image_id');
    }

    /**
     * Delete the relation of blog
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($blog) {
            if ($blog->isForceDeleting()) {
                $blog->image()->withTrashed()->forceDelete();
            } else {
                $blog->image()->delete();
            }
        });

        static::restoring(function ($blog) {
            $blog->image()->withTrashed()->restore();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function scopeBlogSearch($query, $search)
    {
        return $query->where('title', 'like', '%' . $search . '%')
                    ->OrWhereHas('category', function ($r) use ($search) {
                        $r->where('title', 'like', '%' . $search . '%');
                    })
                    ->OrWhereHas('tags', function ($r) use ($search) {
                        $r->where('title', 'like', '%' . $search . '%');
                    });
    }
}