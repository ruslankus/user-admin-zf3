<?php

namespace User\Controller\Factory;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use User\Controller\UserController;
use User\Service\UserManager;
use Zend\ServiceManager\Exception\ServiceNotCreatedException;
use Zend\ServiceManager\Exception\ServiceNotFoundException;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserControllerFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('doctrine.entitymanager.orm_default');
        $userManages = $container->get(UserManager::class);

        return new UserController($em, $userManages);
    }
}