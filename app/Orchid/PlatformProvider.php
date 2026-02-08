<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Orchid\Screens\ResourceListScreen;
use Orchid\Crud\Screens\ListScreen;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
    public function register(): void
    {
        parent::register();
        $this->app->bind(ListScreen::class, ResourceListScreen::class);
    }

    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
    }

    /**
     * @return Menu[]
     */
    public function menu(): array
    {
        return [
            Menu::make('Главная')
                ->icon('bs.house')
                ->route('platform.main'),

            Menu::make('Клиенты')
                ->icon('bs.people')
                ->route('platform.resource.list', ['client-resources']),

            Menu::make('Платежи')
                ->icon('bs.cash-stack')
                ->route('platform.resource.list', ['payment-resources']),

            Menu::make('Абонементы')
                ->icon('bs.card-heading')
                ->route('platform.resource.list', ['subscription-resources']),

            Menu::make('Типы абонементов')
                ->icon('bs.card-list')
                ->route('platform.resource.list', ['subscription-type-resources']),

            Menu::make('Расписание')
                ->icon('bs.calendar-week')
                ->route('platform.resource.list', ['schedule-resources']),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function permissions(): array
    {
        return [
            ItemPermission::group(__('Система'))
                ->addPermission('platform.systems.roles', __('Роли'))
                ->addPermission('platform.systems.users', __('Пользователи')),
        ];
    }
}
