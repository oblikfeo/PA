<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Input;

/**
 * Поиск по клиентам на вкладке «Абонементы» (фамилия, телефон).
 */
class SubscriptionClientSearchFilter extends Filter
{
    public $parameters = ['filter.client_search'];

    public function name(): string
    {
        return 'Клиент (фамилия, телефон)';
    }

    public function run(Builder $builder): Builder
    {
        $value = $this->request->input('filter.client_search');
        if ($value === null || trim((string) $value) === '') {
            return $builder;
        }
        $like = '%' . trim($value) . '%';
        return $builder->whereHas('client', function (Builder $q) use ($like): void {
            $q->where('last_name', 'like', $like)
                ->orWhere('phone', 'like', $like);
        });
    }

    public function display(): array
    {
        return [
            Input::make('filter.client_search')
                ->placeholder('Фамилия или телефон клиента')
                ->value($this->request->input('filter.client_search')),
        ];
    }
}
