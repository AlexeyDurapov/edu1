<?php

declare(strict_types=1);

namespace User\Model;

use Psr\Container\ContainerInterface;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Hydrator\ReflectionHydrator;

class EducationRepositoryFactory
{
    public function __invoke(ContainerInterface $container) : EducationRepository
    {
        return new EducationRepository(
            $container->get(AdapterInterface::class),
            EducationRepository::TABLE_NAME,
            new ReflectionHydrator(),
            new User()
        );
    }
}
