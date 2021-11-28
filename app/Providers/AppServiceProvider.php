<?php

namespace App\Providers;

use App\Concrete\ProcessReport;
use App\Concrete\ReadCSVFile;
use App\Interfaces\ProcessFileInterface;
use App\Interfaces\ReadFileInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        $this->app->singleton(ReadFileInterface::class, ReadCSVFile::class);
        $this->app->bind(ProcessFileInterface::class, ProcessReport::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
