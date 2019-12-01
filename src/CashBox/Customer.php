<?php

namespace App\CashBox;

use App\CashBox\Interfaces\CustomerInterface;

/**
 * Class Customer
 * @package App\CashBox
 */
class Customer implements CustomerInterface
{
    /**
     * @var int
     */
    protected $timeX;

    /**
     * @var int
     */
    protected $timeY;

    /**
     * @return int
     */
    public function getTimeX(): int
    {
        return $this->timeX;
    }

    /**
     * @param int $x
     */
    public function setTimeX(int $x): void
    {
        $this->timeX = $x;
    }

    /**
     * @return int
     */
    public function getTimeY(): int
    {
        return $this->timeY;
    }

    /**
     * @param int $y
     */
    public function setTimeY(int $y): void
    {
        $this->timeY = $y;
    }
}
