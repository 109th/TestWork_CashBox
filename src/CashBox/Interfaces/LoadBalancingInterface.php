<?php

namespace App\CashBox\Interfaces;

use SplFixedArray;

/**
 * Interface LoadBalancingInterface
 * @package App\CashBox\Interfaces
 */
interface LoadBalancingInterface
{
    /**
     * @param SplFixedArray $pool
     * @return CashBoxInterface
     */
    public function balance(SplFixedArray $pool): CashBoxInterface;
}
