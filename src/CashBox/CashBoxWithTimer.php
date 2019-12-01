<?php

namespace App\CashBox;

use App\CashBox\Interfaces\CustomerInterface;
use App\CashBox\Interfaces\InternalTimerInterface;
use App\CashBox\Interfaces\InternalTimerSetInterface;
use App\CashBox\Interfaces\InternalTimerTickInterface;
use DateTime;
use Exception;

/**
 * Class CashBoxWithTimer
 * @package App\CashBox
 */
class CashBoxWithTimer extends CashBox implements InternalTimerTickInterface, InternalTimerSetInterface
{
    /**
     * @var InternalTimerInterface
     */
    protected $internalTimer;

    /**
     * @return DateTime
     */
    public function getCurrentTime(): DateTime
    {
        return $this->internalTimer->getCurrentTime();
    }

    /**
     * @param InternalTimerInterface $internalTimer
     */
    public function setTimer(InternalTimerInterface $internalTimer): void
    {
        $this->internalTimer = $internalTimer;
    }

    /**
     *
     * @throws Exception
     */
    public function processTick(): void
    {
        if ($this->queue->offsetExists(0)) {
            /**
             * @var CustomerInterface $customer
             */
            $customer = $this->queue->offsetGet(0);
            $customerProcessTime = $customer->getTimeX() + $customer->getTimeY();

            $lastCustomerTime = $this->getLastCustomerProcessTime() ?? $this->getLastCustomerIncomeTime();
            $currentTimestamp = $this->internalTimer->getCurrentTime()->getTimestamp();
            $cashBoxFreeTimestamp = $lastCustomerTime->getTimestamp() + $customerProcessTime;
            if ($currentTimestamp >= $cashBoxFreeTimestamp) {
                $this->processQueue();
            }
        }
    }
}
