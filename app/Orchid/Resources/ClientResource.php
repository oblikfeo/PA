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
            Input::make('phone')->title('Телефон')->required(),
            Input::make('balance')
                ->title('Баланс (кошелёк)')
                ->type('number')
                ->step(0.01)
                ->value(0)
                ->disabled()
                ->help('Баланс меняется только через раздел «Платежи» (пополнение) и при покупке абонемента.'),
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
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('first_name', 'Имя'),
            Sight::make('last_name', 'Фамилия'),
            Sight::make('phone', 'Телефон'),
            Sight::make('balance', 'Баланс'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'required|string|max:255|unique:clients,phone,' . $model->id,
            'balance' => 'nullable|numeric|min:0',
        ];
    }

    public function filters(): array
    {
        return [];
    }
}
