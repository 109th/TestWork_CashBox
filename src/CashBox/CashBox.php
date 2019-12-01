<?php

namespace App\CashBox;

use App\CashBox\Interfaces\CashBoxInterface;
use App\CashBox\Interfaces\CustomerInterface;
use DateTime;
use Exception;
use SplQueue;

/**
 * Class CashBox
 * @package App\CashBox
 */
class CashBox implements CashBoxInterface
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var SplQueue
     */
    protected $queue;

    /**
     * @var bool
     */
    protected $isOpen;

    /**
     * @var DateTime
     */
    protected $lastCustomerIncomeTime;

    /**
     * @var DateTime
     */
    protected $lastCustomerProcessTime;

    /**
     * CashBox constructor.
     */
    public function __construct()
    {
        $this->queue = new SplQueue();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return bool
     */
    public function isOpen(): bool
    {
        return $this->isOpen;
    }

    /**
     * @return int
     */
    public function getQueueSize(): int
    {
        return $this->queue->count();
    }

    /**
     * @return int
     */
    public function getQueueExpectedTime(): int
    {
        $totalTime = 0;

        /**
         * @var $customer CustomerInterface
         */
        foreach ($this->queue as $customer) {
            $totalTime += $customer->getTimeX() + $customer->getTimeY();
        }

        return $totalTime;
    }

    /**
     *
     */
    public function setOpen(): void
    {
        $this->isOpen = true;
    }

    /**
     *
     */
    public function setClose(): void
    {
        $this->isOpen = false;
    }

    /**
     * @param CustomerInterface $customer
     * @throws Exception
     */
    public function addToQueue(CustomerInterface $customer): void
    {
        $this->queue->enqueue($customer);
        $this->setLastCustomerIncomeTime($this->getCurrentTime());
    }

    /**
     * @return DateTime
     * @throws Exception
     */
    public function getCurrentTime(): DateTime
    {
        return new DateTime();
    }

    /**
     *
     * @throws Exception
     */
    public function processQueue(): void
    {
        $this->queue->dequeue();
        $this->setLastCustomerProcessTime($this->getCurrentTime());
    }

    /**
     * @return DateTime|null
     */
    public function getLastCustomerIncomeTime(): ?DateTime
    {
        return $this->lastCustomerIncomeTime ? clone $this->lastCustomerIncomeTime : null;
    }

    /**
     * @param DateTime $time
     */
    public function setLastCustomerIncomeTime(DateTime $time): void
    {
        $this->lastCustomerIncomeTime = $time;
    }

    /**
     * @return DateTime|null
     */
    public function getLastCustomerProcessTime(): ?DateTime
    {
        return $this->lastCustomerProcessTime ? clone $this->lastCustomerProcessTime : null;
    }

    /**
     * @param DateTime $time
     */
    public function setLastCustomerProcessTime(DateTime $time): void
    {
        $this->lastCustomerProcessTime = $time;
    }
}
