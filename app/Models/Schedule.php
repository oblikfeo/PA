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

    protected $attributes = [
        'day_of_week' => 0,
        'is_enabled' => true,
    ];

    protected $fillable = [
        'studio_id',
        'title',
        'day_of_week',
        'days_of_week',
        'start_time',
        'end_time',
        'is_enabled',
    ];

    protected $casts = [
        'day_of_week' => 'integer',
        'is_enabled' => 'boolean',
    ];

    /**
     * Для формы и календаря: если days_of_week не задан (старые записи), используем один day_of_week.
     */
    public function getDaysOfWeekAttribute($value): array
    {
        if (is_array($value) && count($value) > 0) {
            return $value;
        }
        $decoded = $value === null || $value === '' ? null : json_decode($value, true);
        if (is_array($decoded) && count($decoded) > 0) {
            return $decoded;
        }
        return $this->attributes['day_of_week'] !== null ? [(int) $this->attributes['day_of_week']] : [];
    }

    public function setDaysOfWeekAttribute($value): void
    {
        $arr = is_array($value) ? $value : (array) $value;
        $arr = array_values(array_map('intval', array_filter($arr, fn ($d) => $d >= 0 && $d <= 6)));
        $this->attributes['days_of_week'] = $arr ? json_encode($arr) : null;
        if (count($arr) > 0) {
            $this->attributes['day_of_week'] = $arr[0];
        }
    }

    public function studio(): BelongsTo
    {
        return $this->belongsTo(Studio::class);
    }

    public function getDayNameAttribute(): string
    {
        $days = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];
        $d = $this->attributes['day_of_week'] ?? null;
        return $d !== null ? ($days[$d] ?? '') : '';
    }

    public function scopeEnabled($query)
    {
        return $query->where('is_enabled', true);
    }

    /**
     * Проверяет, попадает ли слот на указанный день недели (0–6).
     * Учитывает days_of_week (повторяющееся событие) или одиночный day_of_week.
     */
    public function hasDay(int $dayOfWeek): bool
    {
        $days = $this->days_of_week;
        if (is_array($days) && count($days) > 0) {
            return in_array($dayOfWeek, $days, true);
        }
        $d = $this->attributes['day_of_week'] ?? null;
        return $d !== null && (int) $d === $dayOfWeek;
    }

    /**
     * Краткие названия дней для отображения (Пн, Вт, ...).
     */
    public function getDaysShortAttribute(): string
    {
        $names = ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб'];
        $days = $this->days_of_week;
        if (is_array($days) && count($days) > 0) {
            return implode(', ', array_map(fn ($d) => $names[$d] ?? (string) $d, $days));
        }
        $d = $this->attributes['day_of_week'] ?? null;
        return $d !== null ? ($names[$d] ?? (string) $d) : '';
    }
}
