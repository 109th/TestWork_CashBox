<?php

namespace App;

use App\CashBox\Interfaces\CustomerInterface;
use App\CashBox\Interfaces\DispatcherInterface;
use App\CashBox\Interfaces\InternalTimerInterface;
use App\CashBox\Interfaces\InternalTimerTickInterface;
use Psr\Container\ContainerInterface;

/**
 * Class Modeling
 * @package App
 */
class Modeling
{
    /**
     * @var DispatcherInterface
     */
    private $dispatcher;

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @var InternalTimerInterface
     */
    private $timer;

    /**
     * Modeling constructor.
     * @param DispatcherInterface $dispatcher
     * @param ContainerInterface $container
     * @param InternalTimerInterface $timer
     */
    public function __construct(DispatcherInterface $dispatcher,
                                ContainerInterface $container,
                                InternalTimerInterface $timer)
    {
        $this->dispatcher = $dispatcher;
        $this->container = $container;
        $this->timer = $timer;
    }

    /**
     *
     * @throws \Exception
     */
    public function do(): void
    {
        $countTicks = 0;

        while (!$this->timer->isFinished()) {
            if ($countTicks % 6 === random_int(0, 3)) {
                $customer = $this->container->get(CustomerInterface::class);
                $this->dispatcher->incomeCustomer($customer);
            }

            if ($this->dispatcher instanceof InternalTimerTickInterface) {
                $this->dispatcher->processTick();
            }
            $this->timer->processTick();

            $countTicks++;
        }
    }
}
