<?php

namespace EZSCALE\Virtfusion;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use EZSCALE\Virtfusion\Commands\VirtfusionCommand;

class VirtfusionServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('virtfusion')
            ->hasConfigFile();
    }
}
