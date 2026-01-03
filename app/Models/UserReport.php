<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserReport extends Model
{
    protected $fillable = [
        'title',
        'columns',
        'filters',
    ];

    protected $casts = [
        'columns' => 'array',
        'filters' => 'array',
    ];
}
