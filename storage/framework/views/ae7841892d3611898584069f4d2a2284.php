<div class="container-fluid">
    <div class="calendar-card bg-white rounded shadow-sm overflow-hidden">
        
        <div class="calendar-header bg-light border-bottom px-4 py-3 d-flex flex-wrap justify-content-between align-items-center gap-3">
            <h4 class="mb-0 text-body-emphasis fw-semibold"><?php echo e($monthName); ?> <?php echo e($year); ?></h4>
            <div class="d-flex gap-2 flex-wrap">
                <?php
                    $prevMonth = $month - 1 ?: 12;
                    $prevYear = $month - 1 ? $year : $year - 1;
                    $nextMonth = $month + 1 <= 12 ? $month + 1 : 1;
                    $nextYear = $month + 1 <= 12 ? $year : $year + 1;
                ?>
                <a href="<?php echo e(route('platform.main', ['year' => $prevYear, 'month' => $prevMonth])); ?>" class="calendar-nav-btn">← Назад</a>
                <a href="<?php echo e(route('platform.main')); ?>" class="calendar-nav-btn calendar-nav-btn-now">Сейчас</a>
                <a href="<?php echo e(route('platform.main', ['year' => $nextYear, 'month' => $nextMonth])); ?>" class="calendar-nav-btn">Вперёд →</a>
            </div>
        </div>

        <div class="calendar-body p-4">
            
            <div class="calendar-weekdays row g-2 mb-2">
                <?php $__currentLoopData = ['Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб', 'Вс']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $wd): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col calendar-weekday-cell text-center small fw-semibold text-body-secondary py-2"><?php echo e($wd); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <?php $__currentLoopData = $calendar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $week): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="calendar-week row g-2 mb-2">
                    <?php $__currentLoopData = $week; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cell): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col calendar-day-cell <?php echo e($cell['schedules']->isNotEmpty() ? 'calendar-day-active' : ''); ?> <?php echo e($cell['day'] === null ? 'calendar-day-empty' : ''); ?>">
                            <?php if($cell['day'] !== null): ?>
                                <div class="calendar-day-num"><?php echo e($cell['day']); ?></div>
                                <?php if($cell['schedules']->isNotEmpty()): ?>
                                    <div class="calendar-day-times small mt-1">
                                        <?php $__currentLoopData = $cell['schedules']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $s): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div>
                                                <?php if($s->title): ?>
                                                    <span class="calendar-event-title"><?php echo e($s->title); ?></span>
                                                    <span class="text-muted"> <?php echo e(\Carbon\Carbon::parse($s->start_time)->format('H:i')); ?><?php if($s->end_time): ?>–<?php echo e(\Carbon\Carbon::parse($s->end_time)->format('H:i')); ?><?php endif; ?></span>
                                                <?php else: ?>
                                                    <?php echo e(\Carbon\Carbon::parse($s->start_time)->format('H:i')); ?><?php if($s->end_time): ?>–<?php echo e(\Carbon\Carbon::parse($s->end_time)->format('H:i')); ?><?php endif; ?>
                                                <?php endif; ?>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted opacity-50">—</span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>

<style>
/* Карточка календаря — на всю ширину шапки (Главная / календарь) */
.calendar-card {
    width: 100%;
}

/* Кнопки навигации — как пункты меню: скругление, бордер, розовый акцент */
.calendar-nav-btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    font-size: 0.875rem;
    font-weight: 500;
    color: #4c0519;
    background-color: rgba(120, 53, 95, 0.12);
    border: 1px solid rgba(120, 53, 95, 0.25);
    border-radius: 8px;
    text-decoration: none;
    transition: background-color 0.2s, border-color 0.2s, color 0.2s, box-shadow 0.2s;
}
.calendar-nav-btn:hover {
    color: #be185d;
    background-color: rgba(190, 25, 112, 0.2);
    border-color: rgba(190, 25, 112, 0.4);
}
.calendar-nav-btn-now:hover {
    color: #fff;
    background: linear-gradient(135deg, #db2777 0%, #be185d 100%);
    border-color: #9d174d;
    box-shadow: 0 2px 6px rgba(190, 25, 112, 0.35);
}

/* Заголовки дней недели */
.calendar-weekday-cell {
    min-height: 2rem;
}

/* Ячейка дня — квадратик в стиле карточки */
.calendar-day-cell {
    min-height: 5rem;
    padding: 0.6rem 0.5rem !important;
    background: #fff;
    border: 1px solid rgba(120, 53, 95, 0.15);
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
    transition: box-shadow 0.2s, border-color 0.2s, background 0.2s;
}
.calendar-day-cell:hover {
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.08);
}
.calendar-day-cell.calendar-day-active {
    background: linear-gradient(180deg, #fce7f3 0%, #fbcfe8 100%);
    border-color: rgba(219, 39, 119, 0.35);
    box-shadow: 0 2px 6px rgba(219, 39, 119, 0.15);
}
.calendar-day-cell.calendar-day-active:hover {
    box-shadow: 0 2px 8px rgba(219, 39, 119, 0.25);
}
.calendar-day-cell.calendar-day-empty {
    background: #f8f9fa;
    border-color: rgba(0, 0, 0, 0.06);
}

.calendar-day-num {
    font-weight: 600;
    color: #1f2937;
}
.calendar-day-active .calendar-day-num {
    color: #831843;
}
.calendar-day-times {
    color: #831843;
    line-height: 1.35;
    font-weight: 500;
}
.calendar-event-title {
    font-weight: 600;
}
</style>
<?php /**PATH C:\Users\oblik\Desktop\P.A\resources\views/platform/calendar.blade.php ENDPATH**/ ?>