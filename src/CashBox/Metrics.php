<?php

namespace App\CashBox;

use App\CashBox\Interfaces\MetricsInterface;
use DateTime;

/**
 * Class Metrics
 * @package App\CashBox
 */
class Metrics implements MetricsInterface
{
    /**
     * @var array
     */
    protected $customersIncome = [];

    /**
     * @var array
     */
    protected $cashBoxQueue = [];

    /**
     * @var array
     */
    protected $cashBoxTime = [];

    /**
     * @var array
     */
    protected $cashBoxNames = [];

    /**
     * @param DateTime $time
     */
    public function customerIncome(DateTime $time): void
    {
        $hour = $time->format('H');

        if (!array_key_exists($hour, $this->customersIncome)) {
            $this->customersIncome[$hour] = 0;
        }

        $this->customersIncome[$hour]++;
    }

    /**
     * @return array
     */
    public function getCustomerIncomeChartData(): array
    {
        $header = [
            ['Hour', 'Counts']
        ];
        $data = [];

        foreach ($this->customersIncome as $hour => $count) {
            $data[] = [$hour, $count];
        }

        return array_merge($header, $data);
    }

    /**
     * @param string $name
     * @param DateTime $time
     */
    public function cashBoxQueue(string $name, DateTime $time): void
    {
        $hour = $time->format('H');

        if (!array_key_exists($hour, $this->cashBoxQueue)) {
            $this->cashBoxQueue[$hour] = [];
        }

        if (!array_key_exists($name, $this->cashBoxQueue[$hour])) {
            $this->cashBoxQueue[$hour][$name] = 0;
        }

        $this->addCashBoxName($name);

        $this->cashBoxQueue[$hour][$name]++;
    }

    /**
     * @param $name
     */
    protected function addCashBoxName($name): void
    {
        if (!in_array($name, $this->cashBoxNames, true)) {
            $this->cashBoxNames[] = $name;
        }
    }

    /**
     * @return array
     */
    public function getCashBoxQueueChartData(): array
    {
        sort($this->cashBoxNames, SORT_STRING);
        $header = [
            array_merge(['Hour'], $this->cashBoxNames)
        ];
        $data = [];

        foreach ($this->cashBoxQueue as $hour => $name) {
            $row = [$hour];
            foreach ($this->cashBoxNames as $cashBoxName) {
                $row[] = array_key_exists($cashBoxName, $name) ? $name[$cashBoxName] : 0;
            }
            $data[] = $row;
        }

        return array_merge($header, $data);
    }

    /**
     * @param string $name
     * @param int $cashBoxTime
     * @param DateTime $time
     */
    public function cashBoxTime(string $name, int $cashBoxTime, DateTime $time): void
    {
        $hour = $time->format('H');

        if (!array_key_exists($hour, $this->cashBoxTime)) {
            $this->cashBoxTime[$hour] = [];
        }

        if (!array_key_exists($name, $this->cashBoxTime[$hour])) {
            $this->cashBoxTime[$hour][$name] = 0;
        }

        $this->addCashBoxName($name);

        $this->cashBoxTime[$hour][$name] += $cashBoxTime;
    }

    /**
     * @return array
     */
    public function getCashBoxTimeChartData(): array
    {
        sort($this->cashBoxNames, SORT_STRING);
        $header = [
            array_merge(['Hour'], $this->cashBoxNames)
        ];
        $data = [];

        foreach ($this->cashBoxTime as $hour => $name) {
            $row = [$hour];
            foreach ($this->cashBoxNames as $cashBoxName) {
                $row[] = array_key_exists($cashBoxName, $name) ? $name[$cashBoxName] : 0;
            }
            $data[] = $row;
        }

        return array_merge($header, $data);
    }
}