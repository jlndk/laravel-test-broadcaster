<?php

namespace Jlndk\FakeBroadcaster;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Jlndk\FakeBroadcaster\SkeletonClass
 */
class SkeletonFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'skeleton';
    }
}
