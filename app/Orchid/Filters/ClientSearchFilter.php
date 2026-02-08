<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Input;

/**
 * Поиск по фамилии и телефону на вкладке «Клиенты».
 */
class ClientSearchFilter extends Filter
{
    public $parameters = ['filter.client_search'];

    public function name(): string
    {
        return 'Поиск (фамилия, телефон)';
    }

    public function run(Builder $builder): Builder
    {
        $value = $this->request->input('filter.client_search');
        if ($value === null || trim((string) $value) === '') {
            return $builder;
        }
        $like = '%' . trim($value) . '%';
        return $builder->where(function (Builder $q) use ($like): void {
            $q->where('last_name', 'like', $like)
                ->orWhere('phone', 'like', $like);
        });
    }

    public function display(): array
    {
        return [
            Input::make('filter.client_search')
                ->placeholder('Фамилия или телефон')
                ->value($this->request->input('filter.client_search')),
        ];
    }
}
