<?php

namespace App\Providers;

use App\Models\User\Permission;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Exception;

class PermissionsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        auth()->loginUsingId(4);
        try {
            Permission::get()->map(function ($permission){
                Gate::define($permission->name,function ($user) use ($permission){
                    return $user->hasPermissionTo($permission);
                });
            });
        }
        catch (\Exception $exception){
            report($exception);
            return false;
        }
    }
}
