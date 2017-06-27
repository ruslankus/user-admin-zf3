<?php

namespace MailService;

use MailService\Factory\MailServiceFactory;
use MailService\Service\MailService;

return array(

    'service_manager' => array(

        'factories' => array(
            MailService::class => MailServiceFactory::class
        )
    ),


    'view_manager' => array(

        'template_map' => array(
            'mail/reset-pass' => __DIR__ . "/../view/mail/user-service/reset-password.phtml",
        ),
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
);
