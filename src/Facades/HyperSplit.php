<?php

namespace Habib\Payout\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Habib\Payout\HyperSplitService
 */
class HyperSplit extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'hyper_split';
    }
}
