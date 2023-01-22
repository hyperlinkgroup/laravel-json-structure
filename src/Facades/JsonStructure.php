<?php

namespace Hyperlink\JsonStructure\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hyperlink\JsonStructure\JsonStructure
 */
class JsonStructure extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Hyperlink\JsonStructure\JsonStructure::class;
    }
}
