<?php

namespace App\Providers;

use App\Models\Form;
use App\Policies\FormPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Form::class => FormPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
