<?php

namespace App\Providers;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    /**
     * The path to the current lang files
     * @var string
     */
    protected $langPath;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (request()->is('en', 'en/*')) {
            Cache::pull('translations');
            App::setLocale('en');
            $this->langPath = resource_path('lang/en');
        } elseif (request()->is('vi', 'vi/*')) {
            Cache::pull('translations');
            App::setLocale('vi');
            $this->langPath = resource_path('lang/vi');
        }

        try {
            Cache::rememberForever('translations', function () {
                return collect(File::allFiles($this->langPath))->flatMap(function ($file) {
                    return [
                        $translation = $file->getBasename('.php') => trans($translation),
                    ];
                })->toJson();
            });
        } catch (\Exception $e) {
            report($e);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }

}
