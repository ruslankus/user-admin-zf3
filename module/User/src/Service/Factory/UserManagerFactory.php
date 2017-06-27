<?php

namespace User\Service\Factory;



use Interop\Container\ContainerInterface;
use MailService\Service\MailService;
use User\Service\UserManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class UserManagerFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     *
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $em = $container->get('Doctrine\ORM\EntityManager');
        $mailService = $container->get(MailService::class);

        return new UserManager($em, $mailService);
    }
}