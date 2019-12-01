<?php

namespace App\CashBox;

use App\CashBox\Interfaces\CashBoxInterface;
use App\CashBox\Interfaces\LoadBalancingInterface;
use SplFixedArray;

/**
 * Class LoadBalancing
 * @package App\CashBox
 */
class LoadBalancing implements LoadBalancingInterface
{
    /**
     * @param SplFixedArray $pool
     * @return CashBoxInterface
     */
    public function balance(SplFixedArray $pool): CashBoxInterface
    {
        $poolLoad = [];

        /**
         * @var CashBoxInterface $value
         */
        foreach ($pool as $key => $value) {
            if ($value->getQueueSize() < 5) {
                return $value;
            }

            $poolLoad[$key] = $value->getQueueSize();
        }

        $b = current(array_keys($poolLoad, min($poolLoad)));
        return $pool[$b];
    }
}
