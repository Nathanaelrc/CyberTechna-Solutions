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
    'audience',
    'duration',
    'topics',
    'status',
    'sort_order',
    'translations',
])]
class Course extends Model
{
    use HasFactory;
    use HasLocalizedContent;

    protected function casts(): array
    {
        return [
            'translations' => 'array',
            'topics' => 'array',
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

    public function getAudienceAttribute($value): mixed
    {
        return $this->localizedScalar('audience', $value);
    }

    public function getDurationAttribute($value): mixed
    {
        return $this->localizedScalar('duration', $value);
    }

    public function getTopicsAttribute($value): array
    {
        return $this->localizedArray('topics', $value);
    }
}