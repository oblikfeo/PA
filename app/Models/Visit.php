<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Visit extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedFilters = [];
    protected $allowedSorts = ['id', 'visit_date', 'created_at'];

    protected $fillable = [
        'client_id',
        'subscription_id',
        'studio_id',
        'visit_date',
        'visit_time',
        'is_missed',
        'notes',
    ];

    protected $casts = [
        'visit_date' => 'date',
        'is_missed' => 'boolean',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(Subscription::class);
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }
}
