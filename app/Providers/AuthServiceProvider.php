<?php

namespace App\Providers;

use App\Models\Item;
use App\Policies\RequerimientoPolicy;
use Illuminate\Support\Facades\Gate;
use App\Models\Requerimiento;
use App\Policies\ItemPolicy;
// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Requerimiento::class => RequerimientoPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
