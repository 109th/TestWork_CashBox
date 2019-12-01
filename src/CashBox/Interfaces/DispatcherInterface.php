<?php

namespace App\CashBox\Interfaces;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Interface DispatcherInterface
 * @package App\CashBox\Interfaces
 */
interface DispatcherInterface
{
    /**
     * DispatcherInterface constructor.
     * @param LoadBalancingInterface $loadBalancing
     * @param CashBoxManagerInterface $cashBoxManager
     * @param ContainerInterface $container
     */
    public function __construct(LoadBalancingInterface $loadBalancing,
                                CashBoxManagerInterface $cashBoxManager,
                                ContainerInterface $container);

    /**
     * @param CustomerInterface $customer
     */
    public function incomeCustomer(CustomerInterface $customer): void;
}
