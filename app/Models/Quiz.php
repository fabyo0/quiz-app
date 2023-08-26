<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'published',
        'public'
    ];

    protected $casts = [
        'published' => 'boolean',
        'public' => 'boolean'
    ];
}