<?php

namespace App\CashBox;

use App\CashBox\Interfaces\CashBoxInterface;
use App\CashBox\Interfaces\CashBoxManagerInterface;
use App\CashBox\Interfaces\CustomerInterface;
use App\CashBox\Interfaces\DispatcherInterface;
use App\CashBox\Interfaces\InternalTimerTickInterface;
use App\CashBox\Interfaces\LoadBalancingInterface;
use SplFixedArray;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class Dispatcher
 * @package App\CashBox
 */
class Dispatcher implements DispatcherInterface, InternalTimerTickInterface
{
    /**
     *
     */
    public const POOL_SIZE = 3;

    /**
     * @var LoadBalancingInterface
     */
    protected $loadBalancing;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var SplFixedArray
     */
    protected $cashBoxPool;

    /**
     * @var CashBoxManagerInterface
     */
    protected $cashBoxManager;

    /**
     * Dispatcher constructor.
     * @param LoadBalancingInterface $loadBalancing
     * @param CashBoxManagerInterface $cashBoxManager
     * @param ContainerInterface $container
     */
    public function __construct(LoadBalancingInterface $loadBalancing,
                                CashBoxManagerInterface $cashBoxManager,
                                ContainerInterface $container)
    {
        $this->loadBalancing = $loadBalancing;
        $this->cashBoxManager = $cashBoxManager;
        $this->container = $container;
        $this->cashBoxPool = new SplFixedArray(self::POOL_SIZE);

        for ($count = 0; $count < $this->cashBoxPool->getSize(); $count++) {
            $cashBox = $this->container->get(CashBoxInterface::class);
            $this->cashBoxPool[$count] = $cashBox;
        }
    }

    /**
     * @param CustomerInterface $customer
     */
    public function incomeCustomer(CustomerInterface $customer): void
    {
        $this->cashBoxManager->checkToOpen($this->cashBoxPool);

        $cashBox = $this->loadBalancing->balance($this->cashBoxPool);
        $this->cashBoxManager->processCustomer($cashBox, $customer);

        $this->cashBoxManager->checkToClose($this->cashBoxPool);
    }

    /**
     *
     */
    public function processTick(): void
    {
        /**
         * @var CashBoxInterface $cashBox
         */
        foreach ($this->cashBoxPool as $cashBox) {
            if ($cashBox instanceof InternalTimerTickInterface) {
                $cashBox->processTick();
            }
        }
    }
}
