<?php
namespace User;

use User\Controller\AuthController;
use User\Controller\Factory\UserControllerFactory;
use User\Controller\UserController;
use User\Service\Factory\UserManagerFactory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [

    'router' => [

        'routes' => [

            'login' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/login',

                    'defaults' => [
                        'controller' => AuthController::class,
                        'action' => 'login'
                    ]
                ]
            ],


            'users' => [
                'type' => Segment::class,
                'options' => [
                    'route' => '/users[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller'    => UserController::class,
                        'action' => 'index'
                    ]
                ]
            ]
        ]
    ],
    'controllers' => [
        'factories' => [
            Controller\AuthController::class => InvokableFactory::class,
            UserController::class => UserControllerFactory::class

        ],
    ],
    'service_manager' => [
        'factories' => [
            Service\UserManager::class => UserManagerFactory::class
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],

    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],


];