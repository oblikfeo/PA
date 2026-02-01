<?php

namespace App\Orchid\Resources;

use App\Models\Client;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Orchid\Crud\Resource;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class SubscriptionResource extends Resource
{
    public static $model = Subscription::class;

    public static function label(): string
    {
        return 'Абонементы';
    }

    public static function singularLabel(): string
    {
        return 'Абонемент';
    }

    public static function icon(): string
    {
        return 'bs.card-heading';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    public function fields(): array
    {
        return [
            Relation::make('client_id')->fromModel(Client::class, 'last_name')->title('Клиент')->required()->searchColumns('first_name', 'last_name', 'phone'),
            Relation::make('subscription_type_id')->fromModel(SubscriptionType::class, 'name')->title('Тип абонемента')->required(),
            DateTimer::make('purchase_date')->title('Дата покупки')->format('Y-m-d')->required(),
            DateTimer::make('expires_at')->title('Действует до')->format('Y-m-d'),
            Input::make('lessons_remaining')->title('Остаток занятий')->type('number')->required(),
            Select::make('is_active')->title('Активен')->options([1 => 'Да', 0 => 'Нет']),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('client_id', 'Клиент')->render(function ($m) {
                return $m->client ? $m->client->full_name : '-';
            }),
            TD::make('subscription_type_id', 'Тип')->render(function ($m) {
                return $m->subscriptionType ? $m->subscriptionType->name : '-';
            }),
            TD::make('purchase_date', 'Покупка')->render(function ($m) {
                return $m->purchase_date ? $m->purchase_date->format('d.m.Y') : '-';
            }),
            TD::make('expires_at', 'До')->render(function ($m) {
                return $m->expires_at ? $m->expires_at->format('d.m.Y') : '-';
            }),
            TD::make('lessons_remaining', 'Остаток'),
            TD::make('is_active', 'Активен')->render(function ($m) {
                return $m->is_active ? 'Да' : 'Нет';
            }),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('client_id', 'Клиент')->render(function ($m) {
                return $m->client ? $m->client->full_name : '-';
            }),
            Sight::make('subscription_type_id', 'Тип абонемента')->render(function ($m) {
                return $m->subscriptionType ? $m->subscriptionType->name : '-';
            }),
            Sight::make('purchase_date', 'Дата покупки'),
            Sight::make('expires_at', 'Действует до'),
            Sight::make('lessons_remaining', 'Остаток занятий'),
            Sight::make('is_active', 'Активен'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'subscription_type_id' => 'required|exists:subscription_types,id',
            'purchase_date' => 'required|date',
            'lessons_remaining' => 'required|integer|min:0',
        ];
    }

    public function with(): array
    {
        return ['client', 'subscriptionType'];
    }

    public function filters(): array
    {
        return [];
    }
}
