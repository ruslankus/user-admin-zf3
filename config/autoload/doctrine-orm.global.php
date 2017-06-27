<?php

use DoctrineORMModule\Service\EntityManagerFactory;

return array(
    'doctrine' => [
        'connection' => array(
            // default connection name
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                'params' => array(
                    'host'     => '172.18.0.1',
                    'port'     => '3306',
                    'user'     => 'root',
                    'password' => 'mysql',
                    'dbname'   => 'db-user',
                )
            )
        ),

    ],


    'dependencies' => [
        'factories' => [
            'doctrine.entitymanager.orm_default' => EntityManagerFactory::class,
        ],
    ],

);