<?php

namespace App\CashBox\Interfaces;

use DateTime;

/**
 * Interface InternalTimerInterface
 * @package App\CashBox\Interfaces
 */
interface InternalTimerInterface
{
    /**
     *
     */
    public function processTick(): void;

    /**
     * @return DateTime
     */
    public function getCurrentTime(): DateTime;

    /**
     * @return bool
     */
    public function isFinished(): bool;
}