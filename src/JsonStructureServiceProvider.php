<?php

namespace Hyperlink\JsonStructure;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Hyperlink\JsonStructure\Commands\JsonStructureCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-json-structure_table')
            ->hasCommand(JsonStructureCommand::class);
    }
}
