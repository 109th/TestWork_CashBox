<?php

namespace App\CashBox\Interfaces;

use DateTime;

/**
 * Interface CashBoxInterface
 * @package App\CashBox\Interfaces
 */
interface CashBoxInterface
{
    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return bool
     */
    public function isOpen(): bool;

    /**
     * @return int
     */
    public function getQueueSize(): int;

    /**
     * @return int
     */
    public function getQueueExpectedTime(): int;

    /**
     *
     */
    public function setOpen(): void;

    /**
     *
     */
    public function setClose(): void;

    /**
     * @param CustomerInterface $customer
     */
    public function addToQueue(CustomerInterface $customer): void;

    /**
     *
     */
    public function processQueue(): void;

    /**
     * @return DateTime
     */
    public function getCurrentTime(): DateTime;

    /**
     * @param DateTime $time
     */
    public function setLastCustomerIncomeTime(DateTime $time): void;

    /**
     * @return DateTime|null
     */
    public function getLastCustomerIncomeTime(): ?DateTime;

    /**
     * @param DateTime $time
     */
    public function setLastCustomerProcessTime(DateTime $time): void;

    /**
     * @return DateTime|null
     */
    public function getLastCustomerProcessTime(): ?DateTime;
}
