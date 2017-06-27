<?php
return [
    'mail' => [
        'transport' => [
            'options' => array(
                'name'              => 'smtp.yandex.ru',
                'host'              => 'smtp.yandex.ru',
                'port'              => 465, // Notice port change for TLS is 587
                'connection_class'  => 'plain',
                'connection_config' => array(
                    'username' => 'ruslan@prophp.eu',
                    'password' => 'mn867535144',
                    'ssl'      => 'ssl'

                ),
            ),
        ],
        'detailed-config' => [
            'send-to' => array(
                //'ruslan.kiricenko@locatory.com'
            ),
            'default-from' => 'ruslan@prophp.eu'
        ]
    ]
];