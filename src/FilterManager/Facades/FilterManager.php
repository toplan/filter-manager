<?php

namespace Toplan\FilterManager\Facades;

use Illuminate\Support\Facades\Facade;

class FilterManager extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'FilterManager';
    }
}
