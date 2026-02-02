<?php

namespace App\Orchid\Resources;

use App\Models\Client;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\ValidationException;
use Orchid\Crud\Layouts\ResourceFields;
use Orchid\Crud\Resource;
use Orchid\Crud\ResourceRequest;
use Orchid\Screen\Fields\DateTimer;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\Relation;
use Orchid\Screen\Fields\Select;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Sight;
use Orchid\Screen\TD;

class PaymentResource extends Resource
{
    public static $model = Payment::class;

    public static function label(): string
    {
        return 'Платежи';
    }

    public static function singularLabel(): string
    {
        return 'Платёж';
    }

    public static function icon(): string
    {
        return 'bs.cash-stack';
    }

    public static function displayInNavigation(): bool
    {
        return false;
    }

    public function fields(): array
    {
        return [
            Relation::make('client_id')->fromModel(Client::class, 'last_name')->title('Клиент')->required()->searchColumns('first_name', 'last_name', 'phone'),
            Input::make('amount')->title('Сумма')->type('number')->step(0.01)->required(),
            DateTimer::make('payment_date')->title('Дата оплаты')->format('Y-m-d')->required(),
            Select::make('payment_method')->title('Способ оплаты')->options([
                'cash' => 'Наличные',
                'card' => 'Карта',
                'transfer' => 'Перевод',
            ]),
            TextArea::make('notes')->title('Заметки')->rows(2),
        ];
    }

    public function columns(): array
    {
        return [
            TD::make('id'),
            TD::make('client_id', 'Клиент')->render(fn ($m) => $m->client?->full_name ?? '-'),
            TD::make('amount', 'Сумма'),
            TD::make('payment_date', 'Дата')->render(fn ($m) => $m->payment_date?->format('d.m.Y')),
            TD::make('payment_method', 'Способ')->render(function ($m) {
                $methods = ['cash' => 'Наличные', 'card' => 'Карта', 'transfer' => 'Перевод'];
                return $methods[$m->payment_method] ?? $m->payment_method;
            }),
        ];
    }

    public function legend(): array
    {
        return [
            Sight::make('id'),
            Sight::make('client_id', 'Клиент')->render(fn ($m) => $m->client?->full_name ?? '-'),
            Sight::make('amount', 'Сумма'),
            Sight::make('payment_date', 'Дата оплаты'),
            Sight::make('payment_method', 'Способ оплаты'),
            Sight::make('notes', 'Заметки'),
            Sight::make('created_at', 'Создан'),
            Sight::make('updated_at', 'Обновлён'),
        ];
    }

    public function rules(\Illuminate\Database\Eloquent\Model $model): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
        ];
    }

    public function with(): array
    {
        return ['client', 'subscription'];
    }

    public function filters(): array
    {
        return [];
    }

    /**
     * Данные формы приходят с префиксом "model" — передаём в модель только их.
     * После сохранения обновляем баланс клиента для пополнений.
     */
    public function save(ResourceRequest $request, Model $model): void
    {
        $data = $request->input(ResourceFields::PREFIX, $request->all());
        if ((float) ($data['amount'] ?? 0) <= 0) {
            throw ValidationException::withMessages([
                'model.amount' => ['Сумма пополнения баланса должна быть больше нуля.'],
            ]);
        }
        $wasRecentlyCreated = !$model->exists;
        $oldAmount = $model->exists ? (float) $model->getRawOriginal('amount') : 0;

        $model->forceFill($data)->save();

        $isTopUp = empty($model->subscription_id);
        if ($isTopUp && $model->client_id && (float) $model->amount > 0) {
            if ($wasRecentlyCreated) {
                Client::where('id', $model->client_id)->increment('balance', $model->amount);
            } else {
                $newAmount = (float) $model->amount;
                $diff = $newAmount - $oldAmount;
                if ($diff !== 0.0) {
                    Client::where('id', $model->client_id)->increment('balance', $diff);
                }
            }
        }
    }

    /**
     * Перед удалением пополнения — списываем сумму с баланса клиента.
     */
    public function delete(Model $model): void
    {
        $isTopUp = empty($model->subscription_id);
        if ($isTopUp && $model->client_id && (float) $model->amount > 0) {
            Client::where('id', $model->client_id)->decrement('balance', $model->amount);
        }
        $model->delete();
    }
}
