<?php

namespace FmTod\Quotes\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \FmTod\Quotes\Quotes
 */
class Quotes extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \FmTod\Quotes\Quotes::class;
    }
}
