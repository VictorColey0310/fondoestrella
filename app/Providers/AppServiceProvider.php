<?php

namespace App\Providers;

use App\Models\Apariencia;
use Illuminate\Support\Facades\Auth;

use App\Models\Informacion; // Reemplaza "Logo" con el nombre de tu modelo o utiliza el facade correspondiente

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
}


}