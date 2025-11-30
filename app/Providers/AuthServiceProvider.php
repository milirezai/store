<?php

namespace App\Providers;

use App\Models\Content\Post;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        //  روش یک
//        Gate::define('update-post',function (User $user, Post $post){
//            return $user->id === $post->author_id;
//        });

        // روش دو
        Gate::define('update-post',function (User $user){
            return  $user->user_type === 1 ? Response::allow() : Response::deny('شما اجازه ویراییش این ');
        });

    }
}
