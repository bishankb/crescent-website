<?php

namespace App;

use App\BaseModel;

class PhoneBook extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
         'phone_book_type', 'title', 'description', 'phonebook_file_id', 'created_by', 'updated_by'
    ];

    public function file()
    {
        return $this->belongsTo(Media::class, 'phonebook_file_id');
    }
}
