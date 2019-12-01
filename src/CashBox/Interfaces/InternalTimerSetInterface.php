<?php

namespace App\CashBox\Interfaces;

/**
 * Interface InternalTimerSetInterface
 * @package App\CashBox\Interfaces
 */
interface InternalTimerSetInterface
{
    /**
     * @param InternalTimerInterface $internalTimer
     */
    public function setTimer(InternalTimerInterface $internalTimer): void;
}