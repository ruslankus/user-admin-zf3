<?php

namespace MailService\Factory;



use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use MailService\Service\MailService;

use Zend\Mail\Transport\Smtp;
use Zend\Mail\Transport\SmtpOptions;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Renderer\PhpRenderer;
use Zend\View\Resolver\TemplateMapResolver;


class MailServiceFactory implements FactoryInterface
{

    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     *
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config  = $container->get('Config');
        //Setting smtp  transport
        $transportOptions = $config['mail']['transport']['options'];

        $mailTransport = new Smtp();
        $mailOptions = new SmtpOptions($transportOptions);
        $mailTransport->setOptions($mailOptions);
        //Setting renderer
        $mailRenderer = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap($container->get('Config')['view_manager']['template_map']);
        $mailRenderer->setResolver($resolver);

        $from = $config['mail']['detailed-config']['default-from'];
        //$sendTo = $config['mail']['detailed-config']['send-to'];

        $service = new MailService($mailTransport, $mailRenderer, $from);

        return $service;
    }
}

/*
class MailServiceFactory implements FactoryInterface
{



    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config  = $serviceLocator->get('Config');
        //Setting smtp  transport
        $transportOptions = $config['mail']['transport']['options'];

        $mailTransport = new Smtp();
        $mailOptions = new SmtpOptions($transportOptions);
        $mailTransport->setOptions($mailOptions);
        //Setting renderer
        $mailRenderer = new PhpRenderer();
        $resolver = new TemplateMapResolver();
        $resolver->setMap($serviceLocator->get('Config')['view_manager']['template_map']);
        $mailRenderer->setResolver($resolver);

        $from = $config['mail']['detailed-config']['default-from'];
        //$sendTo = $config['mail']['detailed-config']['send-to'];

        $service = new MailService($mailTransport, $mailRenderer, $from);

        return $service;
    }
}

*/