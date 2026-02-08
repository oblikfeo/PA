<?php

namespace App\Orchid\Layouts;

use Orchid\Screen\Layout;
use Orchid\Screen\Repository;

/**
 * Строка поиска и кнопка «Поиск» вместо выпадающего блока фильтров.
 */
class SearchBarLayout extends Layout
{
    protected $template = 'platform.layouts.search-bar';

    protected string $placeholder;

    public function __construct(string $placeholder = 'Фамилия или телефон')
    {
        $this->placeholder = $placeholder;
    }

    public function build(Repository $repository)
    {
        return view($this->template, [
            'placeholder' => $this->placeholder,
        ]);
    }
}
