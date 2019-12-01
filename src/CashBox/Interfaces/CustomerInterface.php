<?php

namespace App\CashBox\Interfaces;

/**
 * Interface CustomerInterface
 * @package App\CashBox\Interfaces
 */
interface CustomerInterface
{
    /**
     * @param int $x
     */
    public function setTimeX(int $x): void;

    /**
     * @return int
     */
    public function getTimeX(): int;

    /**
     * @param int $y
     */
    public function setTimeY(int $y): void;

    /**
     * @return int
     */
    public function getTimeY(): int;
}