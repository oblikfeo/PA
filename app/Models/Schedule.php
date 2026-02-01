<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class Schedule extends Model
{
    use AsSource, Filterable, HasFactory;

    protected $allowedFilters = [];
    protected $allowedSorts = ['id', 'day_of_week', 'start_time', 'created_at'];

    protected $fillable = [
        'studio_id',
        'day_of_week',
        'start_time',
        'end_time',
        'is_reserve',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_reserve' => 'boolean',
    ];

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function getDayNameAttribute(): string
    {
        $days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        return $days[$this->day_of_week] ?? '';
    }
}
