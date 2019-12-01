<?php

namespace App\CashBox\Interfaces;

use DateTime;

/**
 * Interface Metrics
 * @package App\CashBox\Interfaces
 */
interface MetricsInterface
{
    /**
     * @param DateTime $time
     */
    public function customerIncome(DateTime $time): void;

    /**
     * @return array
     */
    public function getCustomerIncomeChartData(): array;

    /**
     * @param string $name
     * @param DateTime $time
     */
    public function cashBoxQueue(string $name, DateTime $time): void;

    /**
     * @return array
     */
    public function getCashBoxQueueChartData(): array;

    /**
     * @param string $name
     * @param int $cashBoxTime
     * @param DateTime $time
     */
    public function cashBoxTime(string $name, int $cashBoxTime, DateTime $time): void;

    /**
     * @return array
     */
    public function getCashBoxTimeChartData(): array;
}