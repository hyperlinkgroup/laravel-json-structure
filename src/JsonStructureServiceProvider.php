<?php

namespace Hyperlink\JsonStructure;

use Hyperlink\JsonStructure\Commands\JsonStructureCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class JsonStructureServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-json-structure')
            ->hasCommand(JsonStructureCommand::class);
    }
}
