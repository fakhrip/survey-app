<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Respond extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ip_address', 'answer_ids', 'user_id', 'survey_id',
    ];
}
