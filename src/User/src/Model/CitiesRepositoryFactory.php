<?php

declare(strict_types=1);

namespace User\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ReflectionHydrator;

class CitiesRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : CitiesRepository
    {
        return new CitiesRepository(
            $container->get(AdapterInterface::class),
            CitiesRepository::TABLE_NAME,
            new ReflectionHydrator(),
            new City()
        );
    }
}
