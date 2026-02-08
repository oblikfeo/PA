<div class="search-bar mb-1">
    <div class="d-flex flex-nowrap align-items-center gap-2">
        <div class="flex-shrink-0" style="min-width: 200px; width: 420px;">
            <input type="text"
                   form="search-form"
                   name="filter[client_search]"
                   value="<?php echo e(request('filter.client_search', '')); ?>"
                   class="form-control form-control-sm"
                   placeholder="<?php echo e($placeholder ?? 'Фамилия или телефон'); ?>"
                   autocomplete="off"
                   aria-label="Поиск">
        </div>
        <div class="d-flex align-items-center gap-2 flex-shrink-0">
            <button type="submit" form="search-form" class="btn btn-sm search-bar-btn">
                Поиск
            </button>
            <?php if(request('filter.client_search')): ?>
                <a href="<?php echo e(url()->current()); ?>" class="btn btn-sm search-bar-reset">Сбросить</a>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\oblik\Desktop\P.A\resources\views/platform/layouts/search-bar.blade.php ENDPATH**/ ?>