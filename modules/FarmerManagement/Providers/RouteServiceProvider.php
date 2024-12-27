<?php

namespace Modules\FarmerManagement\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * Boot the application services.
     */
    public function boot()
    {
        $this->mapWebRoutes();
    }

    /**
     * Map web routes for the FarmerManagement module.
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace('Modules\FarmerManagement\Http\Controllers')
            ->group(module_path('FarmerManagement', 'Routes/web.php'));
    }
}
