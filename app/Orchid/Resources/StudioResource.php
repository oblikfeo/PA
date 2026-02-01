<?php

namespace App\Orchid\Resources;

use App\Models\Studio;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class StudioResource extends Resource
{
    public static $model = Studio::class;

    public static function label(): string
    {
        return 'Студии';
    }

    public static function singularLabel(): string
    {
        return 'Студия';
    }

    public static function icon(): string
    {
        return 'bs.building';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    public function fields(): array
    {
        return [
            Input::make('name')->title('Название')->required(),
            TextArea::make('description')->title('Описание')->rows(3),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('name', 'Название'),
            TD::make('description', 'Описание')->width('40%'),
            TD::make('created_at', 'Создан')->render(fn ($m) => $m->created_at?->format('d.m.Y')),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('name', 'Название'),
            Sight::make('description', 'Описание'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    public function filters(): array
    {
        return [];
    }
}
