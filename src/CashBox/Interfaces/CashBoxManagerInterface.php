<?php

namespace App\CashBox\Interfaces;

use SplFixedArray;

/**
 * Interface CashBoxManagerInterface
 * @package App\CashBox\Interfaces
 */
interface CashBoxManagerInterface
{
    /**
     * CashBoxManagerInterface constructor.
     * @param InternalTimerInterface $internalTimer
     */
    public function __construct(InternalTimerInterface $internalTimer);

    /**
     * @param CashBoxInterface $cashBox
     * @param CustomerInterface $customer
     */
    public function processCustomer(CashBoxInterface $cashBox, CustomerInterface $customer): void;

    /**
     * @param SplFixedArray $pool
     */
    public function checkToOpen(SplFixedArray $pool): void;

    /**
     * @param SplFixedArray $pool
     */
    public function checkToClose(SplFixedArray $pool): void;
}
