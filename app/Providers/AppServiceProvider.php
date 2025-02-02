<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

use App\View\Components\Alert;

use Illuminate\Pagination\Paginator;
//use App\View\Components\Inputs\Button;

//use App\View\Components\Forms\Button as FormButton;

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
    public function boot()
    {
        Blade::if('env', function($value){ //@env('local)
            //Tra ve gia tri boolen
            if(config('app.env') === $value){
                return true;
            }
            return false;
        });

        Blade::component('package-alert', Alert::class);

        //Blade::component('button', Button::class);

        //Blade::component('forms-button', FormButton::class);

        Paginator::useBootstrap();
    }
}
