<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'title',
    'slug',
    'excerpt',
    'description',
    'audience',
    'duration',
    'topics',
    'status',
    'sort_order',
])]
class Course extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'topics' => 'array',
            'sort_order' => 'integer',
        ];
    }
}