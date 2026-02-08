<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Schedule;
use App\Models\Studio;
use App\Models\SubscriptionType;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Создание студий...');
        $modelStudio = Studio::firstOrCreate(
            ['name' => 'Модельная студия'],
            ['description' => 'Студия для модельных занятий']
        );
        $yogaStudio = Studio::firstOrCreate(
            ['name' => 'Йога студия'],
            ['description' => 'Студия для занятий йогой']
        );
        $this->command->info('  Студий: ' . Studio::count());

        $this->command->info('Создание типов абонементов...');
        $types = [
            ['studio' => $modelStudio, 'name' => 'Месячный абонемент', 'price' => 5000, 'validity_days' => 30, 'is_one_time' => false, 'is_personal' => false],
            ['studio' => $modelStudio, 'name' => 'Разовое занятие', 'price' => 1500, 'validity_days' => 7, 'is_one_time' => true, 'is_personal' => false],
            ['studio' => $yogaStudio, 'name' => 'Абонемент 4 занятия', 'price' => 3000, 'validity_days' => 30, 'is_one_time' => false, 'is_personal' => false],
            ['studio' => $yogaStudio, 'name' => 'Абонемент 8 занятий', 'price' => 5000, 'validity_days' => 60, 'is_one_time' => false, 'is_personal' => false],
            ['studio' => $yogaStudio, 'name' => 'Разовое занятие', 'price' => 1000, 'validity_days' => 7, 'is_one_time' => true, 'is_personal' => false],
            ['studio' => $yogaStudio, 'name' => 'Персональное занятие', 'price' => 2500, 'validity_days' => 7, 'is_one_time' => true, 'is_personal' => true],
        ];
        foreach ($types as $t) {
            SubscriptionType::firstOrCreate(
                ['studio_id' => $t['studio']->id, 'name' => $t['name']],
                [
                    'price' => $t['price'],
                    'validity_days' => $t['validity_days'],
                    'is_one_time' => $t['is_one_time'],
                    'is_personal' => $t['is_personal'],
                ]
            );
        }
        $this->command->info('  Типов абонементов: ' . SubscriptionType::count());

        $this->command->info('Создание расписания...');
        // Слоты с одним днём (старый формат)
        $slots = [
            ['studio' => $modelStudio, 'day_of_week' => 0, 'days_of_week' => null, 'title' => null, 'start_time' => '13:00', 'end_time' => '14:30', 'is_reserve' => false, 'is_enabled' => true],
            ['studio' => $modelStudio, 'day_of_week' => 0, 'days_of_week' => null, 'title' => null, 'start_time' => '15:00', 'end_time' => '16:30', 'is_reserve' => false, 'is_enabled' => true],
            ['studio' => $modelStudio, 'day_of_week' => 6, 'days_of_week' => null, 'title' => null, 'start_time' => '15:00', 'end_time' => '16:30', 'is_reserve' => true, 'is_enabled' => true],
        ];
        foreach ($slots as $s) {
            Schedule::firstOrCreate(
                [
                    'studio_id' => $s['studio']->id,
                    'day_of_week' => $s['day_of_week'],
                    'start_time' => $s['start_time'],
                ],
                [
                    'end_time' => $s['end_time'],
                    'is_reserve' => $s['is_reserve'],
                    'is_enabled' => $s['is_enabled'],
                    'title' => $s['title'],
                    'days_of_week' => $s['days_of_week'],
                ]
            );
        }
        // Повторяющееся событие: йога по средам и пятницам каждую неделю
        Schedule::firstOrCreate(
            [
                'studio_id' => $yogaStudio->id,
                'title' => 'Йога',
                'start_time' => '19:00',
            ],
            [
                'day_of_week' => 3,
                'days_of_week' => [3, 5],
                'end_time' => '20:00',
                'is_reserve' => false,
                'is_enabled' => true,
            ]
        );
        $this->command->info('  Слотов расписания: ' . Schedule::count());

        $this->command->info('Создание тестовых клиентов...');
        $clients = [
            ['first_name' => 'Иван', 'last_name' => 'Петров', 'middle_name' => 'Сергеевич', 'phone' => '+79001234501', 'age' => 25, 'balance' => 500],
            ['first_name' => 'Мария', 'last_name' => 'Сидорова', 'middle_name' => null, 'phone' => '+79001234502', 'age' => 30, 'balance' => 0],
            ['first_name' => 'Алексей', 'last_name' => 'Козлов', 'middle_name' => 'Иванович', 'phone' => '+79001234503', 'age' => 28, 'balance' => 1500],
        ];
        foreach ($clients as $c) {
            Client::firstOrCreate(
                ['phone' => $c['phone']],
                array_merge($c, ['middle_name' => $c['middle_name'] ?? ''])
            );
        }
        $this->command->info('  Клиентов: ' . Client::count());

        $this->command->info('Готово. В админке: Студии, Типы абонементов, Расписание, Клиенты.');
    }
}
