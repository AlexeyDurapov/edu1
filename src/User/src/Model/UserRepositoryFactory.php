<?php

declare(strict_types=1);

namespace User\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ReflectionHydrator;

class UserRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : UserRepository
    {
        return new UserRepository(
            $container->get(AdapterInterface::class),
            UserRepository::TABLE_NAME,
            new ReflectionHydrator(),
            new User()
        );
    }
}
