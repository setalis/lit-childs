<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Регистрируем FigureLinkService как singleton
        $this->app->singleton(\App\Services\FigureLinkService::class, function ($app) {
            return new \App\Services\FigureLinkService;
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Принудительное использование HTTPS в production
        if (config('app.env') === 'production' && str_starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }

        // Подключаем helper-функции
        require app_path('Helpers/FigureLinkHelper.php');

        // Регистрируем Blade директивы
        \Illuminate\Support\Facades\Blade::directive('figureLinks', function ($expression) {
            return "<?php echo process_figure_links($expression); ?>";
        });

        \Illuminate\Support\Facades\Blade::directive('figureLinksByHtml', function ($expression) {
            return "<?php echo process_figure_links($expression, true); ?>";
        });
    }
}
