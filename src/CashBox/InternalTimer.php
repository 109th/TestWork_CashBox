<?php

namespace App\CashBox;

use App\CashBox\Interfaces\InternalTimerInterface;
use DateInterval;
use DateTime;

/**
 * Class InternalTimer
 * @package App\CashBox
 */
class InternalTimer implements InternalTimerInterface
{
    /**
     *
     */
    public const TICK_INTERVAL = 'PT5S';

    /**
     * @var DateTime
     */
    private $currentTime;


    /**
     * @var DateTime
     */
    private $finishTime;

    /**
     * InternalTimer constructor.
     */
    public function __construct()
    {
        $this->currentTime = new DateTime('2019-11-01T00:00:00');

        // Максимум 24 часа, иначе не будут правильно работать метрики
        // Пусть будет так в рамках тестового задания
        $this->finishTime = new DateTime('2019-11-02T00:00:00');
    }

    /**
     *
     */
    public function processTick(): void
    {
        $this->currentTime->add(new DateInterval(self::TICK_INTERVAL));
    }

    /**
     * @return DateTime
     */
    public function getCurrentTime(): DateTime
    {
        return clone $this->currentTime;
    }

    /**
     * @return bool
     */
    public function isFinished(): bool
    {
        return $this->currentTime >= $this->finishTime;
    }
}
