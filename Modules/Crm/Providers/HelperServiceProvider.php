<?php

namespace Modules\Crm\Providers;

use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $path = __DIR__ . '/../Helpers/DataProcessing.php';
        if (file_exists($path)) {
            require_once $path;
        }
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
