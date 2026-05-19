<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Storybook extends Model
{
    protected $table = 'storybooks';

    public $timestamps = false;

    protected $fillable = [
        'title',
        'author',
        'reader',
        'image',
        'pages',
        'category',
        'is_active'
    ];

    protected $casts = [
        'pages' => 'array',
        'is_active' => 'boolean'

    ];
}