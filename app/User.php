<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'slug', 'email', 'role_id', 'password', 'active',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    /**
     *Filter by status.
     *
     */
    public function scopeStatusFilter($query, $filter)
    {
        if ($filter) {
            return $query->where('active', $filter == 'Active' ? 1 : 0);
        }

        return $query;
    }

    /**
     *Filter by deleted items.
     *
     */
    public function scopeDeletedItemFilter($query, $filter)
    {
        if ($filter) {
            if ($filter == "Only Deleted") {
                return $query->onlyTrashed();
            } else {
                return $query->withTrashed();
            }
            
        }

        return $query;
    }

    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    public function role()
    {
        return $this->belongsTo('Spatie\Permission\Models\Role');
    }

    /**
     * Delete the relation of user
    */
    protected static function boot() {
        parent::boot();
        
        static::deleting(function($user) {
            if ($user->isForceDeleting()) {
                $user->profile()->withTrashed()->forceDelete();
            } else {
                $user->profile()->delete();
            }
        });

        static::restoring(function ($user) {
            $user->profile()->withTrashed()->restore();
        });
    } 
}
