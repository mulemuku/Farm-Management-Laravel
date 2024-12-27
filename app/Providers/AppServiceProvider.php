<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\File;

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
        //
        Schema::defaultStringLength(191);
        $modulesPath = base_path('modules');
        $modules = File::directories($modulesPath);
        $activeModules = config('modules');

        foreach ($modules as $module) {
            // Check if the module has a 'Routes/web.php' file
            $routeFile = $module . '/Routes/web.php';
            if (File::exists($routeFile)) {
                $this->loadModuleRoutes($routeFile);
            }
    
            // Check if the module has a 'Views' directory
            $viewPath = $module . '/Views';
            if (File::isDirectory($viewPath)) {
                $this->loadModuleViews($viewPath, basename($module));
            }

            $moduleName = basename($module);
            if (!isset($activeModules[$moduleName]) || !$activeModules[$moduleName]) {
                continue; // Skip inactive modules
            }
        }
    }

    protected function loadModuleRoutes($routeFile)
    {
        require $routeFile;
    }
    
    protected function loadModuleViews($viewPath, $moduleName)
    {
     $this->app['view']->addNamespace($moduleName, $viewPath);
    }

}
