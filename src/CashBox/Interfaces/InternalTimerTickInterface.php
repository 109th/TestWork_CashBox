<?php

namespace App\CashBox\Interfaces;

/**
 * Interface InternalTimerTickInterface
 * @package App\CashBox\Interfaces
 */
interface InternalTimerTickInterface
{
    /**
     *
     */
    public function processTick(): void;
}