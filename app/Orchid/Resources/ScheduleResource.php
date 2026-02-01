<?php

namespace App\Orchid\Resources;

use App\Models\Schedule;
use App\Models\Studio;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class ScheduleResource extends Resource
{
    public static $model = Schedule::class;

    public static function label(): string
    {
        return 'Расписание';
    }

    public static function singularLabel(): string
    {
        return 'Слот расписания';
    }

    public static function icon(): string
    {
        return 'bs.calendar-week';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    private static function dayOptions(): array
    {
        return [
            0 => 'Воскресенье',
            1 => 'Понедельник',
            2 => 'Вторник',
            3 => 'Среда',
            4 => 'Четверг',
            5 => 'Пятница',
            6 => 'Суббота',
        ];
    }

    public function fields(): array
    {
        return [
            Relation::make('studio_id')->fromModel(Studio::class, 'name')->title('Студия')->required(),
            Select::make('day_of_week')->title('День недели')->options(self::dayOptions())->required(),
            Input::make('start_time')->title('Начало')->type('time')->required(),
            Input::make('end_time')->title('Конец')->type('time')->required(),
            Select::make('is_reserve')->title('Резервный день')->options([0 => 'Нет', 1 => 'Да']),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('studio_id', 'Студия')->render(fn ($m) => $m->studio?->name ?? '-'),
            TD::make('day_of_week', 'День')->render(fn ($m) => self::dayOptions()[$m->day_of_week] ?? $m->day_of_week),
            TD::make('start_time', 'Начало'),
            TD::make('end_time', 'Конец'),
            TD::make('is_reserve', 'Резерв')->render(fn ($m) => $m->is_reserve ? 'Да' : 'Нет'),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('studio_id', 'Студия')->render(fn ($m) => $m->studio?->name ?? '-'),
            Sight::make('day_of_week', 'День недели')->render(fn ($m) => self::dayOptions()[$m->day_of_week] ?? $m->day_of_week),
            Sight::make('start_time', 'Начало'),
            Sight::make('end_time', 'Конец'),
            Sight::make('is_reserve', 'Резервный день'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'studio_id' => 'required|exists:studios,id',
            'day_of_week' => 'required|integer|between:0,6',
            'start_time' => 'required',
            'end_time' => 'required',
        ];
    }

    public function with(): array
    {
        return ['studio'];
    }

    public function filters(): array
    {
        return [];
    }
}
