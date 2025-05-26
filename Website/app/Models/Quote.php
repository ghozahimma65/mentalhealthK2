<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Quote extends Model
{

    protected $connection = 'mongodb';
    protected $collection = 'quotes';

    protected $fillable = [
        'content',
        'category',
    ];

}