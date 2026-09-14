<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

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
        // Di luar production, setiap kali kode mencoba mengakses relasi
        // yang belum di-eager-load, Laravel akan langsung melempar
        // LazyLoadingViolationException alih-alih diam-diam menjalankan
        // query tambahan (lazy load). Ini memaksa kita selalu memakai
        // with()/nested eager loading, bukan cuma "kebetulan aman".
        Model::preventLazyLoading(! app()->isProduction());
    }
}
