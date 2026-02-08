<?php

namespace App\Orchid\Resources;

use App\Models\Schedule;
use App\Models\Studio;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\Switcher;
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
            Input::make('title')->title('Название события')->placeholder('Например: Йога, Пилатес'),
            Select::make('days_of_week')->title('Дни недели (повторяется каждую неделю)')->options(self::dayOptions())->multiple()->required(),
            Input::make('start_time')->title('Начало')->type('time')->required(),
            Input::make('end_time')->title('Конец')->type('time')->required(),
            Switcher::make('is_enabled')->title('Включено в расписание')->sendTrueOrFalse()->placeholder('Выключенные слоты не показываются в календаре'),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('title', 'Событие')->render(fn ($m) => $m->title ?: '—'),
            TD::make('studio_id', 'Студия')->render(fn ($m) => $m->studio?->name ?? '-'),
            TD::make('days_short', 'Дни')->render(fn ($m) => $m->days_short),
            TD::make('start_time', 'Начало'),
            TD::make('end_time', 'Конец'),
            TD::make('is_enabled', 'Вкл')->render(function (Schedule $m) {
                $url = route('platform.schedule.toggle', $m);
                return view('platform.partials.schedule-enabled-switch', ['model' => $m, 'url' => $url])->render();
            }),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('title', 'Название события')->render(fn ($m) => $m->title ?: '—'),
            Sight::make('studio_id', 'Студия')->render(fn ($m) => $m->studio?->name ?? '-'),
            Sight::make('days_short', 'Дни недели')->render(fn ($m) => $m->days_short),
            Sight::make('start_time', 'Начало'),
            Sight::make('end_time', 'Конец'),
            Sight::make('is_enabled', 'Включено в расписание')->render(fn ($m) => $m->is_enabled ? 'Да' : 'Нет'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'studio_id' => 'required|exists:studios,id',
            'days_of_week' => 'required|array|min:1',
            'days_of_week.*' => 'integer|between:0,6',
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
