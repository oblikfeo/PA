<?php

namespace App\Orchid\Resources;

use App\Models\Client;
use App\Models\Studio;
use App\Models\Subscription;
use App\Models\Visit;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class VisitResource extends Resource
{
    public static $model = Visit::class;

    public static function label(): string
    {
        return 'Посещения';
    }

    public static function singularLabel(): string
    {
        return 'Посещение';
    }

    public static function icon(): string
    {
        return 'bs.calendar-check';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    public function fields(): array
    {
        return [
            Relation::make('client_id')->fromModel(Client::class, 'last_name')->title('Клиент')->required()->searchColumns('first_name', 'last_name', 'phone'),
            Relation::make('subscription_id')->fromModel(Subscription::class, 'id')->title('Абонемент')->allowEmpty(),
            Relation::make('studio_id')->fromModel(Studio::class, 'name')->title('Студия')->required(),
            DateTimer::make('visit_date')->title('Дата посещения')->format('Y-m-d')->required(),
            Input::make('visit_time')->title('Время')->type('time'),
            Select::make('is_missed')->title('Пропуск')->options([0 => 'Нет', 1 => 'Да']),
            TextArea::make('notes')->title('Заметки')->rows(2),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('client_id', 'Клиент')->render(fn ($m) => $m->client ? $m->client->full_name : '-'),
            TD::make('studio_id', 'Студия')->render(fn ($m) => $m->studio ? $m->studio->name : '-'),
            TD::make('visit_date', 'Дата')->render(fn ($m) => $m->visit_date ? $m->visit_date->format('d.m.Y') : '-'),
            TD::make('visit_time', 'Время'),
            TD::make('is_missed', 'Пропуск')->render(fn ($m) => $m->is_missed ? 'Да' : 'Нет'),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('client_id', 'Клиент')->render(fn ($m) => $m->client ? $m->client->full_name : '-'),
            Sight::make('subscription_id', 'Абонемент')->render(fn ($m) => (string) ($m->subscription_id ?? '-')),
            Sight::make('studio_id', 'Студия')->render(fn ($m) => $m->studio ? $m->studio->name : '-'),
            Sight::make('visit_date', 'Дата посещения'),
            Sight::make('visit_time', 'Время'),
            Sight::make('is_missed', 'Пропуск'),
            Sight::make('notes', 'Заметки'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'studio_id' => 'required|exists:studios,id',
            'visit_date' => 'required|date',
        ];
    }

    public function with(): array
    {
        return ['client', 'studio', 'subscription'];
    }

    public function filters(): array
    {
        return [];
    }
}
