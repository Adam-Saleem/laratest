<?php

namespace Corals\Modules\UtilitySEO\Providers;

use Corals\Modules\UtilitySEO\Models\SEOItem;
use Corals\Modules\UtilitySEO\Policies\SEOItemPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class UtilityAuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        SEOItem::class => SEOItemPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
