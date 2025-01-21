<?php

namespace App\Providers;

use App\Models\User;
use Dedoc\Scramble\Scramble;
use Dedoc\Scramble\Support\Generator\OpenApi;
use Dedoc\Scramble\Support\Generator\SecurityScheme;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
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
        // * scramble 填加 Authorization 提示
        Scramble::afterOpenApiGenerated(function (OpenApi $openApi) {
            $openApi->secure(
                SecurityScheme::http('bearer')
            );
        });

        // * scramble 預設 local 可以進入
        Gate::define('viewApiDocs', function (User $user) {
            // return in_array($user->email, ['admin@app.com']);
            return false;
        });

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
