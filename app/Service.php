<?php

namespace App;

use App\BaseModel;

class Service extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'slug', 'description', 'service_image_id', 'status', 'created_by', 'updated_by'
    ];

    public function image()
    {
        return $this->belongsTo(Media::class, 'service_image_id');
    }

    /**
     * Delete the relation of service
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($service) {
            if ($service->isForceDeleting()) {
                $service->image()->withTrashed()->forceDelete();
            } else {
                $service->image()->delete();
            }
        });

        static::restoring(function ($service) {
            $service->image()->withTrashed()->restore();
        });
    }
}
