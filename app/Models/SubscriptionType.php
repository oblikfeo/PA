<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class SubscriptionType extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedFilters = [];
    protected $allowedSorts = ['id', 'name', 'price', 'created_at'];

    protected $fillable = [
        'studio_id',
        'name',
        'price',
        'lessons_count',
        'validity_days',
        'is_one_time',
        'is_personal',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'lessons_count' => 'integer',
        'validity_days' => 'integer',
        'is_one_time' => 'boolean',
        'is_personal' => 'boolean',
    ];

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function subscriptions(): HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
