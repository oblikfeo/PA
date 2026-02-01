<?php

namespace App\Orchid\Resources;

use App\Models\Studio;
use App\Models\SubscriptionType;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class SubscriptionTypeResource extends Resource
{
    public static $model = SubscriptionType::class;

    public static function label(): string
    {
        return 'Типы абонементов';
    }

    public static function singularLabel(): string
    {
        return 'Тип абонемента';
    }

    public static function icon(): string
    {
        return 'bs.card-list';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    public function fields(): array
    {
        return [
            Relation::make('studio_id')->fromModel(Studio::class, 'name')->title('Студия')->required(),
            Input::make('name')->title('Название')->required(),
            Input::make('price')->title('Цена')->type('number')->step(0.01)->required(),
            Input::make('lessons_count')->title('Количество занятий')->type('number'),
            Input::make('validity_days')->title('Срок действия (дней)')->type('number'),
            Select::make('is_one_time')->title('Разовое')->options([0 => 'Нет', 1 => 'Да']),
            Select::make('is_personal')->title('Персональное')->options([0 => 'Нет', 1 => 'Да']),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('name', 'Название'),
            TD::make('price', 'Цена'),
            TD::make('lessons_count', 'Занятий'),
            TD::make('validity_days', 'Дней'),
            TD::make('created_at', 'Создан')->render(fn ($m) => $m->created_at?->format('d.m.Y')),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('studio_id', 'Студия')->render(fn ($m) => $m->studio?->name ?? '-'),
            Sight::make('name', 'Название'),
            Sight::make('price', 'Цена'),
            Sight::make('lessons_count', 'Количество занятий'),
            Sight::make('validity_days', 'Срок действия (дней)'),
            Sight::make('is_one_time', 'Разовое'),
            Sight::make('is_personal', 'Персональное'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'studio_id' => 'required|exists:studios,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
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
