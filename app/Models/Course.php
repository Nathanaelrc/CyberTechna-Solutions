<?php

namespace App\Models;

use App\Models\Concerns\HasLocalizedContent;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

#[Fillable([
    'title',
    'slug',
    'excerpt',
    'description',
    'audience',
    'duration',
    'delivery_mode',
    'next_session_at',
    'session_timezone',
    'session_length_minutes',
    'meeting_provider',
    'registration_url',
    'topics',
    'status',
    'sort_order',
    'integrations',
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
            'next_session_at' => 'datetime',
            'session_length_minutes' => 'integer',
            'sort_order' => 'integer',
            'integrations' => 'array',
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

    public function nextSessionLocal(): ?Carbon
    {
        if (! $this->next_session_at) {
            return null;
        }

        return $this->next_session_at->copy()->timezone($this->session_timezone ?: config('services.google.meet_timezone', 'UTC'));
    }

    public function deliveryModeLabel(): string
    {
        return match ($this->delivery_mode) {
            'remote' => __('Remoto en vivo'),
            'hybrid' => __('Híbrido'),
            'onsite' => __('Presencial'),
            default => __('Formato a medida'),
        };
    }

    public function meetingProviderLabel(): ?string
    {
        return match ($this->meeting_provider) {
            'google_meet' => 'Google Meet',
            'zoom' => 'Zoom',
            'teams' => 'Microsoft Teams',
            'custom' => __('Herramienta del cliente'),
            default => null,
        };
    }

    public function googleMeetData(): array
    {
        return (array) data_get($this->integrations, 'google_meet', []);
    }
}