<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    protected $fillable = [
        'text',
        'finished',
    ];

    protected $casts = [
        'finished' => 'boolean',
    ];
}
