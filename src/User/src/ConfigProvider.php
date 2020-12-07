<?php

declare(strict_types=1);

namespace User;

use User\Handler\XhrHandler;
use User\Handler\XhrHandlerFactory;
use User\Model\CitiesRepository;
use User\Model\CitiesRepositoryFactory;
use User\Model\CitiesRepositoryInterface;
use User\Model\EducationRepository;
use User\Model\EducationRepositoryFactory;
use User\Model\EducationRepositoryInterface;
use User\Model\UserRepository;
use User\Model\UserRepositoryFactory;
use User\Model\UserRepositoryInterface;
use Zend\Expressive\Application;

/**
 * The configuration provider for the User module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke() : array
    {
        return [
            'dependencies' => $this->getDependencies(),
            'templates'    => $this->getTemplates(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies() : array
    {
        return [
            'invokables' => [
            ],
            'factories'  => [
                XhrHandler::class           => XhrHandlerFactory::class,

                UserRepository::class       => UserRepositoryFactory::class,
                EducationRepository::class  => EducationRepositoryFactory::class,
                CitiesRepository::class     => CitiesRepositoryFactory::class,
            ],
            'aliases' => [
                UserRepositoryInterface::class      => UserRepository::class,
                EducationRepositoryInterface::class => EducationRepository::class,
                CitiesRepositoryInterface::class    => CitiesRepository::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates() : array
    {
        return [
            'paths' => [
                'user'      => [__DIR__ . '/../templates/'],
                'layout'    => [__DIR__ . '/../templates/layout'],
            ],
        ];
    }

    public function registerRoutes(Application $app, string $basePath = ''): void
    {
        $app->route($basePath . '/xhr', Handler\XhrHandler::class, ['POST', 'GET'], 'users.xhr')
            ->setOptions([
                'tokens' => [
                    'csrf' => '[a-zA-Z0-9]+',
                ],
            ])
        ;
    }
}
