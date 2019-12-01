<?php

namespace App\CashBox;

use App\CashBox\Interfaces\CashBoxInterface;
use App\CashBox\Interfaces\CashBoxManagerInterface;
use App\CashBox\Interfaces\CustomerInterface;
use App\CashBox\Interfaces\InternalTimerInterface;
use App\CashBox\Interfaces\MetricsInterface;
use DateInterval;
use Exception;
use SplFixedArray;

/**
 * Class CashBoxManager
 * @package App\CashBox
 */
class CashBoxManager implements CashBoxManagerInterface
{
    /**
     *
     */
    public const TTL = 'PT300S';

    /**
     * @var InternalTimerInterface
     */
    protected $internalTimer;

    /**
     * @var DateInterval
     */
    protected $closeInterval;

    /**
     * @var MetricsInterface
     */
    protected $metrics;

    /**
     * CashBoxController constructor.
     * @param InternalTimerInterface $internalTimer
     * @throws Exception
     */
    public function __construct(InternalTimerInterface $internalTimer)
    {
        $this->internalTimer = $internalTimer;
        $this->closeInterval = new DateInterval(self::TTL);
    }

    /**
     * @param SplFixedArray $pool
     */
    public function checkToOpen(SplFixedArray $pool): void
    {
        // Не требуется
    }

    /**
     * @param CashBoxInterface $cashBox
     * @param CustomerInterface $customer
     */
    public function processCustomer(CashBoxInterface $cashBox, CustomerInterface $customer): void
    {
        if ($cashBox->isOpen() === false) {
            $cashBox->setOpen();
        }
        $cashBox->addToQueue($customer);

        $currentTime = $this->internalTimer->getCurrentTime();
        $customerTime = $customer->getTimeX() + $customer->getTimeY();
        $this->metrics->customerIncome($currentTime);
        $this->metrics->cashBoxQueue($cashBox->getName(), $currentTime);
        $this->metrics->cashBoxTime($cashBox->getName(), $customerTime, $currentTime);
    }

    /**
     * @param SplFixedArray $pool
     */
    public function checkToClose(SplFixedArray $pool): void
    {
        /**
         * @var $cashBox CashBoxInterface
         */
        foreach ($pool as $cashBox) {
            if ($cashBox->isOpen()) {
                $currentTime = $this->internalTimer->getCurrentTime();
                $currentTime->sub($this->closeInterval);
                if ($currentTime > $cashBox->getLastCustomerProcessTime()) {
                    $cashBox->setClose();
                }
            }
        }
    }

    /**
     * @required
     * @param MetricsInterface $metrics
     */
    public function setMetrics(MetricsInterface $metrics): void
    {
        $this->metrics = $metrics;
    }
}
