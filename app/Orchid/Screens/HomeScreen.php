<?php

declare(strict_types=1);

namespace App\Orchid\Screens;

use App\Models\Schedule;
use Carbon\Carbon;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class HomeScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        $year = (int) request('year', now()->year);
        $month = (int) request('month', now()->month);
        $schedules = Schedule::with('studio')->enabled()->get();

        return [
            'calendar' => $this->buildCalendar($year, $month, $schedules),
            'year' => $year,
            'month' => $month,
            'monthName' => $this->monthName($month),
        ];
    }

    public function name(): ?string
    {
        return 'Главная';
    }

    public function description(): ?string
    {
        return 'Календарь расписания на месяц';
    }

    public function commandBar(): iterable
    {
        return [];
    }

    public function layout(): iterable
    {
        return [
            Layout::view('platform.calendar'),
        ];
    }

    /**
     * Строим календарь: массив недель, каждая неделя — 7 дней (Пн–Вс).
     * День: day (число или null), date, day_of_week (0–6), schedules (слоты на этот день недели).
     */
    private function buildCalendar(int $year, int $month, $schedules): array
    {
        $first = Carbon::create($year, $month, 1);
        $gridStart = $first->copy()->startOfWeek(Carbon::MONDAY);
        $days = [];
        $current = $gridStart->copy();

        for ($i = 0; $i < 42; $i++) {
            $dayOfWeek = (int) $current->format('w');
            $dayNum = $current->month === $month ? $current->day : null;
            $daySchedules = $current->month === $month
                ? $schedules->filter(fn ($s) => $s->hasDay($dayOfWeek))->values()
                : collect();

            $days[] = [
                'day' => $dayNum,
                'date' => $current->month === $month ? $current->copy() : null,
                'day_of_week' => $dayOfWeek,
                'schedules' => $daySchedules,
            ];
            $current->addDay();
        }

        return array_chunk($days, 7);
    }

    private function monthName(int $month): string
    {
        $names = [
            1 => 'Январь', 2 => 'Февраль', 3 => 'Март', 4 => 'Апрель',
            5 => 'Май', 6 => 'Июнь', 7 => 'Июль', 8 => 'Август',
            9 => 'Сентябрь', 10 => 'Октябрь', 11 => 'Ноябрь', 12 => 'Декабрь',
        ];
        return $names[$month] ?? '';
    }
}
