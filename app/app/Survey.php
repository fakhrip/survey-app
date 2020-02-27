<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug', 'title', 'description', 'content_ids', 'duration',
    ];
}
