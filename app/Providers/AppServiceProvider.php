<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Translation\Events\TranslationMissing;
use App\Models\MissingTranslation;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Event::listen(TranslationMissing::class, function (TranslationMissing $event) {
            MissingTranslation::updateOrCreate(
                ['group' => $event->group, 'key' => $event->key],
                ['count' => \DB::raw('count + 1')]
            );
        });
    }
}