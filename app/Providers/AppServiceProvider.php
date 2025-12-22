<?php

namespace App\Providers;

use App\Rules\ExtraUnique;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule as BaseRule;

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
        BaseRule::macro('extraUnique', function (string $table, array $conditions, ?string $column = null) {
            return new ExtraUnique($table, $conditions, $column);
        });
    }
}
