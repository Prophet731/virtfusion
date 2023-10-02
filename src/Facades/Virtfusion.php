<?php

namespace EZSCALE\Virtfusion\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \EZSCALE\Virtfusion\Virtfusion
 */
class Virtfusion extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \EZSCALE\Virtfusion\Virtfusion::class;
    }
}
