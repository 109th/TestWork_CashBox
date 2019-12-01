<?php


namespace App\CashBox\Factories;


use App\CashBox\Customer;
use App\CashBox\Interfaces\CustomerInterface;
use Exception;
use InvalidArgumentException;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class CustomerFactory
 * @package App\CashBox\Factories
 */
class CustomerFactory
{
    /**
     * @param ContainerInterface $container
     * @return CustomerInterface
     * @throws Exception
     */
    public static function createCustomer(ContainerInterface $container): CustomerInterface
    {
        $implements = class_implements(Customer::class);
        if (!array_key_exists(CustomerInterface::class, $implements)) {
            throw new InvalidArgumentException('Class ' . Customer::class . ' doesn\'t implements interface '
                . CustomerInterface::class);
        }

        $customer = $container->get(Customer::class);
        $customer->setTimeX(random_int(15, 90));
        $customer->setTimeY(random_int(5, 20));

        return $customer;
    }
}
