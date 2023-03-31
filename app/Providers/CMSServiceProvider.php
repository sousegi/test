<?php

namespace App\Providers;

use App\Models\Admin;
use App\Services\ModuleService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

/**
 * Class CMSServiceProvider
 * @package App\Providers
 */
class CMSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {
        config([
            'auth.providers.admins' => [
                'driver' => 'eloquent',
                'model' => Admin::class,
            ],
        ], config('auth.providers.admins', []));

        config([
            'auth.guards.admin' => [
                'driver' => 'session',
                'provider' => 'admins',
            ],
        ], config('auth.guards.admin', []));

        config([
            'auth.passwords.admins' => [
                'provider' => 'admins',
                'table' => 'password_resets',
                'expire' => 60,
            ],
        ], config('auth.password.admins', []));
    }

    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(): void
    {
        $this->configureViewsProperties();
        $this->requireHelpers();
    }

    private function configureViewsProperties(): void
    {
        app('view')->composer('admin.layouts.authentication', function ($view) {
            try {
                $filename = base_path('vendor/amigo/cms').'/composer.json';
                $composerData = json_decode(file_get_contents($filename));

                $version = $composerData->version;
            } catch (Exception $e) {
                $version = '1.0.0';
            }

            $view->with([
                'version' => $version,
            ]);
        });

        app('view')->composer('admin.layouts.backend',
            function ($view) {
                try {
                    $filename = base_path('vendor/amigo/cms').'/composer.json';
                    $composerData = json_decode(file_get_contents($filename));

                    $version = $composerData->version;
                } catch (Exception $e) {
                    $version = '1.0.0';
                }

                $view->with([
                    'version' => $version,
                ]);
            }
        );

        app('view')->composer('components.admin.layouts.admin-dropdown',
            function ($view) {
                try {
                    $admin = Auth::guard('admin')->user();
                    $adminName = $admin->name;
                    $adminEmail = $admin->email;
                } catch (Exception $e) {
                    $adminName = 'John Doe';
                    $adminEmail = 'admin@xairo.com';
                }

                $view->with([
                    'adminName' => $adminName,
                    'adminEmail' => $adminEmail,
                ]);
            }
        );

        app('view')->composer('admin.layouts.nav',
            function ($view) {
                try {
                    $modules = app(ModuleService::class)->getModulesForMenu();
                } catch (Exception $e) {
                    $modules = collect([]);
                }

                $view->with([
                    'modules' => $modules,
                ]);
            }
        );
    }

    private function requireHelpers(): void
    {
        if (file_exists(app_path('helpers.php'))) {
            require app_path('helpers.php');
        }
    }
}
