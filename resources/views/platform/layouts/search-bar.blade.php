<div class="search-bar mb-1">
    <div class="d-flex flex-nowrap align-items-center gap-2">
        <div class="flex-shrink-0" style="min-width: 200px; width: 420px;">
            <input type="text"
                   form="search-form"
                   name="filter[client_search]"
                   value="{{ request('filter.client_search', '') }}"
                   class="form-control form-control-sm"
                   placeholder="{{ $placeholder ?? 'Фамилия или телефон' }}"
                   autocomplete="off"
                   aria-label="Поиск">
        </div>
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <button type="submit" form="search-form" class="btn btn-sm search-bar-btn">
                Поиск
            </button>
            @if(request('filter.client_search'))
                <a href="{{ url()->current() }}" class="btn btn-sm search-bar-reset">Сбросить</a>
            @endif
        </div>
    </div>
</div>
