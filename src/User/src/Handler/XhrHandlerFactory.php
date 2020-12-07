<?php

declare(strict_types=1);

namespace User\Handler;

use Psr\Container\ContainerInterface;
use User\Model\CitiesRepositoryInterface;
use User\Model\EducationRepositoryInterface;
use User\Model\UserRepositoryInterface;

class XhrHandlerFactory
{
    public function __invoke(ContainerInterface $container) : XhrHandler
    {
        return new XhrHandler(
            $container->get(UserRepositoryInterface::class),
            $container->get(EducationRepositoryInterface::class),
            $container->get(CitiesRepositoryInterface::class)
        );
    }
}
