<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // VALIDATION RULES
        //Add this custom validation rule.
        \Validator::extend('alpha_space', function ($attribute, $value) {

            // This will only accept alpha and spaces.
            // If you want to accept hyphens use: /^[\pL\s-]+$/u.
            return preg_match('/^[\pL\s]+$/u', $value);
        });

        \Validator::extend('alphanum_dot', function ($attribute, $value) {
            return preg_match('/^[a-zA-Z0-9.]+$/u', $value);
        });

        \Validator::extend('phone', function($attribute, $value) {
            return preg_match('%^(?:(?:\(?(?:00|\+)([1-4]\d\d|[1-9]\d?)\)?)?[\-\.\ \\\/]?)?((?:\(?\d{1,}\)?[\-\.\ \\\/]?){0,})(?:[\-\.\ \\\/]?(?:#|ext\.?|extension|x)[\-\.\ \\\/]?(\d+))?$%i',
                    $value) && strlen($value) >= 10;
        });

        // FIND VALUE IN COLLECTION

        \Validator::extend('teacher_exists', function($attribute, $value) {

        });
    }
}
