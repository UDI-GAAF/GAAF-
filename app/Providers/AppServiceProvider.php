<?php

namespace App\Providers;

use Illuminate\Support\Number;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Si la extensión intl no está disponible en el proceso del servidor
        // (caso común en XAMPP Windows con php artisan serve), sobreescribimos
        // Number::format() con una implementación nativa de PHP que no la requiere.
        if (! extension_loaded('intl')) {
            Number::macro('format', function (int|float $number, ?int $precision = null, ?int $maxPrecision = null, ?string $locale = null): string|false {
                if (! is_null($maxPrecision)) {
                    return number_format($number, $maxPrecision);
                }

                if (! is_null($precision)) {
                    return number_format($number, $precision);
                }

                return number_format($number);
            });
        }
    }
}
