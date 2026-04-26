<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
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
    'translations',
])]
class Service extends Model
{
    use HasFactory;
    use HasLocalizedContent;

    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'deliverables' => 'array',
            'details' => 'array',
            'sort_order' => 'integer',
        ];
    }

    public function getTitleAttribute($value): mixed
    {
        return $this->localizedScalar('title', $value);
    }

    public function getExcerptAttribute($value): mixed
    {
        return $this->localizedScalar('excerpt', $value);
    }

    public function getDescriptionAttribute($value): mixed
    {
        return $this->localizedScalar('description', $value);
    }

    public function getDeliverablesAttribute($value): array
    {
        return $this->localizedArray('deliverables', $value);
    }

    public function getDetailsAttribute($value): array
    {
        return $this->localizedArray('details', $value);
    }
}