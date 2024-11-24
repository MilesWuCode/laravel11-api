<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Model;

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
        // * https://laravel-news.com/shouldbestrict
        Model::shouldBeStrict();

        // * 在測試環境中強制關閉
        // * https://laravel.com/docs/11.x/eloquent#configuring-eloquent-strictness
        // * https://laravel-news.com/disable-eloquent-lazy-loading-during-development

        // * 防止延遲載入
        // Model::preventLazyLoading(! $this->app->isProduction());

        // * 防止默默地丟棄屬性
        // Model::preventSilentlyDiscardingAttributes(! $this->app->isProduction());

        // * 防止存取遺失的屬性
        // Model::preventAccessingMissingAttributes(! $this->app->isProduction());
    }
}
