<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Studio extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedFilters = [];
    protected $allowedSorts = ['id', 'name', 'created_at'];

    protected $fillable = [
        'name',
        'description',
    ];

    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    public function subscriptionTypes(): HasMany
    {
        return $this->hasMany(SubscriptionType::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }
}
