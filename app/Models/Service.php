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
    'deliverables',
    'details',
    'status',
    'sort_order',
])]
class Service extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'deliverables' => 'array',
            'details' => 'array',
            'sort_order' => 'integer',
        ];
    }
}