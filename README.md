# PHP_Laravel12_Translation_Loader

##  Project Introduction

PHP_Laravel12_Translation_Loader is a Laravel 12 demonstration project that implements database-driven translation management using the spatie/laravel-translation-loader package.

Unlike traditional Laravel applications that store translations only in language files, this project stores translations inside the language_lines database table and dynamically loads them at runtime.

The system integrates seamlessly with Laravel’s built-in __() helper function, allowing database translations to override file-based translations while maintaining compatibility with the framework’s default localization system.

This project showcases how to build scalable, dynamic, and production-ready multilingual applications using Laravel 12.

------------------------------------------------------------------------

## Project Overview

PHP_Laravel12_Translation_Loader is a multilingual Laravel 12 application that demonstrates how to implement dynamic, database-based localization using the spatie/laravel-translation-loader package.

This project replaces the traditional static file-based translation approach with a database-driven system that stores translation strings inside the language_lines table. The application dynamically retrieves translations at runtime based on the active locale.

The project architecture ensures:

- Clean separation of concerns

- Runtime language switching

- Middleware-based locale persistence

- Seamless integration with Laravel’s native localization system

- Fallback support to file-based translations if database entries are missing

------------------------------------------------------------------------

## Requirements

- PHP 8.2+
- Composer
- MySQL
- Laravel 12
- XAMPP / WAMP / Local Server

------------------------------------------------------------------------

## Step 1: Create Laravel 12 Project

Open terminal and run:

``` bash
composer create-project laravel/laravel PHP_Laravel12_Translation_Loader "12.*"
```

Move into project:

``` bash
cd PHP_Laravel12_Translation_Loader
```

Check Laravel version:

``` bash
php artisan --version
```

------------------------------------------------------------------------

## Step 2: Configure Database

Update `.env` file:

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=translation_loader
DB_USERNAME=root
DB_PASSWORD=
```

Run migration to verify connection:

``` bash
php artisan migrate
```

------------------------------------------------------------------------

## Step 3: Install Translation Loader Package

Install package:

``` bash
composer require spatie/laravel-translation-loader
```

Publish migration:

``` bash
php artisan vendor:publish --provider="Spatie\TranslationLoader\TranslationServiceProvider" --tag="translation-loader-migrations"
```

Run migration:

``` bash
php artisan migrate
```

This creates:

    language_lines

table.

------------------------------------------------------------------------

## Step 4: Publish Config File

If you want to customize configuration:

```bash
php artisan vendor:publish --provider="Spatie\TranslationLoader\TranslationServiceProvider" --tag="translation-loader-config"
```

This will create:

config/translation-loader.php


------------------------------------------------------------------------

## Step 5: Create Model (Optional - Already Provided)

The package provides a default model:

    Spatie\TranslationLoader\LanguageLine

If you want custom model:

``` bash
php artisan make:model LanguageLine
```

app/Models/LanguageLine.php

``` php
<?php

namespace App\Models;

use Spatie\TranslationLoader\LanguageLine as BaseLanguageLine;

class LanguageLine extends BaseLanguageLine
{
    // You can customize here
}
```

------------------------------------------------------------------------

## Step 6: Insert Translations into Database

Use Tinker:

``` bash
php artisan tinker
```

Insert sample:

``` php
Spatie\TranslationLoader\LanguageLine::create([
    'group' => 'messages',
    'key' => 'welcome',
    'text' => [
        'en' => 'Welcome to our website',
        'fr' => 'Bienvenue sur notre site',
        'hi' => 'हमारी वेबसाइट पर आपका स्वागत है'
    ]
]);
```

Exit tinker.

------------------------------------------------------------------------

## Step 7: Use Translations in Blade

Create a new file:

resources/views/translation.blade.php

```html
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laravel 12 Translation Loader</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-gradient-to-br from-indigo-600 via-purple-600 to-pink-500 flex items-center justify-center p-6">

    <div class="bg-white/20 backdrop-blur-lg shadow-2xl rounded-3xl p-10 w-full max-w-xl text-center border border-white/30">

        <!-- Header -->
        <h1 class="text-4xl font-bold text-white mb-4">
            {{ __('messages.welcome') }}
        </h1>

        <p class="text-white/80 mb-8 text-lg">
            Laravel 12 Database Translation Loader
        </p>

        <!-- Language Switcher -->
        <div class="flex flex-wrap justify-center gap-4">

            <a href="/set-language/en"
               class="px-6 py-3 rounded-xl bg-white text-indigo-600 font-semibold shadow-md hover:scale-105 hover:bg-indigo-100 transition duration-300">
                🇺🇸 English
            </a>

            <a href="/set-language/fr"
               class="px-6 py-3 rounded-xl bg-white text-purple-600 font-semibold shadow-md hover:scale-105 hover:bg-purple-100 transition duration-300">
                🇫🇷 French
            </a>

            <a href="/set-language/hi"
               class="px-6 py-3 rounded-xl bg-white text-pink-600 font-semibold shadow-md hover:scale-105 hover:bg-pink-100 transition duration-300">
                🇮🇳 Hindi
            </a>

        </div>

        <!-- Footer -->
        <div class="mt-10 text-white/70 text-sm">
            Built with ❤️ using Laravel 12 & Translation Loader
        </div>

    </div>

</body>
</html>
```

------------------------------------------------------------------------

## Step 8: Change Language Dynamically

routes/web.php

``` php
<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('translation');
});

Route::get('/set-language/{locale}', function ($locale) {

    session(['locale' => $locale]);
    app()->setLocale($locale);

    return redirect('/');
});
```

------------------------------------------------------------------------

## Step 9: Apply Middleware for Locale

Create middleware:

``` bash
php artisan make:middleware SetLocale
```

app/Http/Middleware/SetLocale.php

``` php
<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        if (session()->has('locale')) {
            app()->setLocale(session('locale'));
        }

        return $next($request);
    }
}
```

Register middleware in:

bootstrap/app.php

``` php
->withMiddleware(function ($middleware) {
    $middleware->appendToGroup('web', [
        \App\Http\Middleware\SetLocale::class,
    ]);
})
```

------------------------------------------------------------------------

## Step 10: Test Application

Start server:

``` bash
php artisan serve
```

Visit:

```bash
    http://127.0.0.1:8000/
```

Change language:

```bash
    http://127.0.0.1:8000/set-language/fr
```

------------------------------------------------------------------------

## Output

<img width="1919" height="1029" alt="Screenshot 2026-02-25 141741" src="https://github.com/user-attachments/assets/04b3a2f7-f30b-49ff-bcd8-7069e58ac9bf" />

<img width="1918" height="1027" alt="Screenshot 2026-02-25 141757" src="https://github.com/user-attachments/assets/7f980275-cd4d-4975-8b1d-b1fc56c18a40" />

<img width="1919" height="1031" alt="Screenshot 2026-02-25 141813" src="https://github.com/user-attachments/assets/2d54e292-481a-47c0-8c19-335486764e3b" />

------------------------------------------------------------------------

## Project Structure Overview

```
PHP_Laravel12_Translation_Loader/
│
├── app/
│   ├── Http/
│   │   └── Middleware/
│   │       └── SetLocale.php
│   │
│   └── Models/
│       └── (optional) LanguageLine.php
│
├── bootstrap/
│   └── app.php
│
├── config/
│   └── translation-loader.php
│
├── database/
│   └── migrations/
│       ├── 0001_01_01_000000_create_users_table.php
│       ├── 0001_01_01_000001_create_cache_table.php
│       ├── 0001_01_01_000002_create_jobs_table.php
│       └── 2026_02_25_XXXXXX_create_language_lines_table.php
│
├── resources/
│   └── views/
│       ├── welcome.blade.php        (default Laravel view)
│       └── translation.blade.php    (your modern UI page)
│
├── routes/
│   └── web.php
│
├── vendor/
│
├── .env
├── composer.json
└── artisan
```

------------------------------------------------------------------------

Your PHP_Laravel12_Translation_Loader Project is now ready!

