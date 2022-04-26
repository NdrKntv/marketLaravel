<?php

namespace App\Providers;

use App\Models\Comment;
use App\Models\Product;
use App\Models\User;
use App\Policies\CUDPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Comment::class => CUDPolicy::class,
        User::class => CUDPolicy::class,
        Product::class => CUDPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
