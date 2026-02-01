# Sport CRM

CRM для спортзала: Laravel 10 + Orchid (админка без React).

## Вход в админку

- **URL:** http://localhost:8000/admin  
- **Логин:** `admin`  
- **Пароль:** `admin`

## Установка

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan orchid:admin admin admin@admin.com admin
php artisan serve
```

## Разделы админки (Resources)

Клиенты, Студии, Типы абонементов, Расписание, Абонементы, Посещения, Платежи.

## Стек

Laravel 10, Orchid Platform, Orchid CRUD, SQLite.
