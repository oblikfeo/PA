<?php

namespace App\Orchid\Resources;

use App\Models\Client;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class ClientResource extends Resource
{
    public static $model = Client::class;

    public static function label(): string
    {
        return 'Клиенты';
    }

    public static function singularLabel(): string
    {
        return 'Клиент';
    }

    public static function icon(): string
    {
        return 'bs.people';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    public function fields(): array
    {
        return [
            Input::make('first_name')->title('Имя')->required(),
            Input::make('last_name')->title('Фамилия')->required(),
            Input::make('middle_name')->title('Отчество'),
            Input::make('age')->title('Возраст')->type('number'),
            Input::make('phone')->title('Телефон')->required(),
            Input::make('balance')->title('Баланс (кошелёк)')->type('number')->step(0.01),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('last_name', 'Фамилия'),
            TD::make('first_name', 'Имя'),
            TD::make('phone', 'Телефон'),
            TD::make('balance', 'Баланс'),
            TD::make('created_at', 'Создан')->render(fn ($m) => $m->created_at?->format('d.m.Y')),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('first_name', 'Имя'),
            Sight::make('last_name', 'Фамилия'),
            Sight::make('middle_name', 'Отчество'),
            Sight::make('age', 'Возраст'),
            Sight::make('phone', 'Телефон'),
            Sight::make('balance', 'Баланс'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:clients,phone,' . $model->id,
            'age' => 'nullable|integer|min:1|max:150',
            'balance' => 'nullable|numeric|min:0',
        ];
    }

    public function filters(): array
    {
        return [];
    }
}
