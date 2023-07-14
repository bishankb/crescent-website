<?php

namespace App;

use App\BaseModel;

class Product extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'features', 'product_image_id', 'status', 'created_by', 'updated_by'
    ];

    public function image()
    {
        return $this->belongsTo(Media::class, 'product_image_id');
    }

    /**
     * Delete the relation of product
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($product) {
            if ($product->isForceDeleting()) {
                $product->image()->withTrashed()->forceDelete();
            } else {
                $product->image()->delete();
            }
        });

        static::restoring(function ($product) {
            $product->image()->withTrashed()->restore();
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
