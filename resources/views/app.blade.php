<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Sport CRM') }}</title>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100 flex items-center justify-center">
            <p class="text-gray-600">
                <a href="{{ url('/admin') }}" class="text-indigo-600 hover:underline">Перейти в админ-панель (Orchid)</a>
            </p>
        </div>
    </body>
</html>
