<?php

namespace App\Orchid\Screens;

use App\Orchid\Layouts\SearchBarLayout;
use App\Orchid\Resources\ClientResource;
use App\Orchid\Resources\PaymentResource;
use App\Orchid\Resources\SubscriptionResource;
use Illuminate\Database\Eloquent\Model;
use Orchid\Crud\Requests\IndexRequest;
use Orchid\Crud\Screens\ListScreen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\CheckBox;
use Orchid\Screen\Fields\Group;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

/**
 * Список ресурсов: для Клиентов, Платежей и Абонементов — строка поиска и кнопка «Поиск» вместо выпадающих фильтров.
 */
class ResourceListScreen extends ListScreen
{
    private const SEARCH_RESOURCES = [
        ClientResource::class       => 'Фамилия или телефон',
        PaymentResource::class      => 'Фамилия или телефон клиента',
        SubscriptionResource::class => 'Фамилия или телефон клиента',
    ];

    public function query(IndexRequest $request): array
    {
        return parent::query($request);
    }

    public function layout(): array
    {
        $grid = collect($this->resource->columns());

        $grid->prepend(TD::make()
            ->width(50)
            ->cantHide()
            ->canSee($this->availableActions()->isNotEmpty())
            ->render(function (Model $model) {
                return CheckBox::make('_models[]')
                    ->value($model->getKey())
                    ->checked(false);
            }));

        if ($this->resource->canShowTableActions()) {
            $grid->push(TD::make(__('Actions'))
                ->alignRight()
                ->cantHide()
                ->render(function (Model $model) {
                    return $this->getTableActions($model)
                        ->set('align', 'justify-content-end align-items-center')
                        ->autoWidth()
                        ->render();
                }));
        }

        $placeholder = self::SEARCH_RESOURCES[get_class($this->resource)] ?? null;

        $topLayout = $placeholder !== null
            ? new SearchBarLayout($placeholder)
            : Layout::selection($this->resource->filters());

        return [
            $topLayout,
            Layout::table('model', $grid->toArray()),
        ];
    }

    private function getTableActions(Model $model): Group
    {
        return Group::make([
            Link::make(__('View'))
                ->icon('bs.eye')
                ->canSee($this->can('view', $model))
                ->route('platform.resource.view', [
                    $this->resource::uriKey(),
                    $model->getAttribute($model->getKeyName()),
                ]),

            Link::make(__('Edit'))
                ->icon('bs.pencil')
                ->canSee($this->can('update', $model))
                ->route('platform.resource.edit', [
                    $this->resource::uriKey(),
                    $model->getAttribute($model->getKeyName()),
                ]),
        ]);
    }
}
