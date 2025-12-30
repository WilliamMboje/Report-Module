<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;



class AwarenessReport extends Model
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
