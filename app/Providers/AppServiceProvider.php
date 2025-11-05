<?php

namespace App\Providers;

use App\Models\Content\Comment;
use App\Models\Notification;
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
        $this->app->bind('message',function (){
            return new \App\Http\Services\Message\Message();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('admin.layouts.header',function ($view){
            $view->with('unseenComments',Comment::where('seen',0));
            $view->with('notifications',Notification::where('read_at',null));
        });
    }
}
