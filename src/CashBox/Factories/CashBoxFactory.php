<?php

namespace App\CashBox\Factories;

use App\CashBox\CashBoxWithTimer;
use App\CashBox\Interfaces\CashBoxInterface;
use App\CashBox\Interfaces\InternalTimerInterface;
use App\CashBox\Interfaces\InternalTimerSetInterface;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CashBoxFactory
 * @package App\CashBox\Factories
 */
class CashBoxFactory
{
    /**
     * @var int
     */
    private static $count = 0;

    /**
     * @param ContainerInterface $container
     * @param InternalTimerInterface $internalTimer
     * @return CashBoxInterface
     */
    public static function createCashBox(ContainerInterface $container, InternalTimerInterface $internalTimer): CashBoxInterface
    {
        $implements = class_implements(CashBoxWithTimer::class);
        if (!array_key_exists(CashBoxInterface::class, $implements)) {
            throw new InvalidArgumentException('Class ' . CashBoxWithTimer::class . ' doesn\'t implements interface '
                . CashBoxInterface::class);
        }

        $cashBox = $container->get(CashBoxWithTimer::class);
        $cashBox->setName('CashBox_' . ++self::$count);
        $cashBox->setClose();

        if ($cashBox instanceof InternalTimerSetInterface) {
            $cashBox->setTimer($internalTimer);
        }

        return $cashBox;
    }

    /**
     * @return int
     */
    public static function getCount(): int
    {
        return self::$count;
    }
}
