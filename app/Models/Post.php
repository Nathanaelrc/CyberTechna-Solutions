<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['title', 'slug', 'excerpt', 'content', 'status', 'published_at', 'user_id', 'translations'])]
class Post extends Model
{
    use HasFactory;
    use HasLocalizedContent;

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'translations' => 'array',
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

    public function getContentAttribute($value): mixed
    {
        return $this->localizedScalar('content', $value);
    }

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}