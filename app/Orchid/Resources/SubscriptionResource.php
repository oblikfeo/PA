<?php

namespace App\Orchid\Resources;

use App\Models\Client;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use App\Orchid\Filters\SubscriptionClientSearchFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Orchid\Crud\Layouts\ResourceFields;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\DateTimer;
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
            Relation::make('subscription_type_id')
                ->fromModel(SubscriptionType::class, 'name')
                ->title('Тип абонемента')
                ->required()
                ->help('Стоимость спишется с баланса клиента. При недостатке средств оформите пополнение в разделе «Платежи».'),
            DateTimer::make('purchase_date')->title('Дата покупки')->format('Y-m-d')->required(),
            DateTimer::make('expires_at')->title('Действует до')->format('Y-m-d'),
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
            TD::make('is_active', 'Активен')->render(function ($m) {
                return $m->isExpired() ? 'Кончился' : 'Да';
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
            Sight::make('is_active', 'Активен')->render(function ($m) {
                return $m->isExpired() ? 'Кончился' : 'Да';
            }),
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
        ];
    }

    public function with(): array
    {
        return ['client', 'subscriptionType'];
    }

    public function filters(): array
    {
        return [
            new SubscriptionClientSearchFilter(),
        ];
    }

    /**
     * Данные формы приходят с префиксом "model". Перед созданием проверяем баланс, после — списываем и создаём платёж.
     */
    public function save(ResourceRequest $request, Model $model): void
    {
        $data = $request->input(ResourceFields::PREFIX, $request->all());
        $wasRecentlyCreated = !$model->exists;

        if (!$model->exists && !empty($data['client_id']) && !empty($data['subscription_type_id'])) {
            $client = Client::find($data['client_id']);
            $type = SubscriptionType::find($data['subscription_type_id']);
            if ($client && $type) {
                $balance = (float) $client->balance;
                $price = (float) $type->price;
                if ($balance < $price) {
                    throw ValidationException::withMessages([
                        'model.subscription_type_id' => [
                            'На балансе клиента недостаточно средств. Требуется: ' . number_format($price, 2, '.', ' ') . ' ₽, на балансе: ' . number_format($balance, 2, '.', ' ') . ' ₽. Сначала оформите пополнение в разделе «Платежи».',
                        ],
                    ]);
                }
            }
        }

        $model->forceFill($data)->save();

        if ($wasRecentlyCreated && $model->client_id && $model->subscription_type_id) {
            $type = $model->subscriptionType;
            if ($type) {
                $price = (float) $type->price;
                DB::transaction(function () use ($model, $price): void {
                    Client::where('id', $model->client_id)->decrement('balance', $price);
                    Payment::create([
                        'client_id' => $model->client_id,
                        'subscription_id' => $model->id,
                        'amount' => $price,
                        'payment_date' => $model->purchase_date ?? now(),
                        'payment_method' => 'cash',
                        'notes' => 'Оплата абонемента #' . $model->id,
                    ]);
                });
            }
        }
    }

    /**
     * При удалении абонемента возвращаем сумму на баланс и удаляем связанные платежи.
     */
    public function delete(Model $model): void
    {
        $type = $model->subscriptionType ?? SubscriptionType::find($model->subscription_type_id);
        $price = $type ? (float) $type->price : 0;
        if ($price > 0 && $model->client_id) {
            DB::transaction(function () use ($model, $price): void {
                Client::where('id', $model->client_id)->increment('balance', $price);
                $model->payments()->delete();
            });
        }
        $model->delete();
    }
}
