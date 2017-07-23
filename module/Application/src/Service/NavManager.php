<?php
/**
 * Created by PhpStorm.
 * User: ruslan
 * Date: 01/07/17
 * Time: 16:16
 */

namespace Application\Service;


use Zend\View\Helper\Url;

class NavManager
{
    protected  $urlHelper;

    public function __construct(Url $urlHelper)
    {
        $this->urlHelper = $urlHelper;
    }

    public function getMenuItems()
    {
        $url = $this->urlHelper;
        $items = [];


        $items[] = [
            'id' => 'home',
            'label' => 'Home',
            'link'  => $url('home')
        ];

        $items[] = [
            'id' => 'about',
            'label' => 'About',
            'link'  => $url('about')
        ];


        $items[] = [
            'id' => 'login',
            'label' => 'Sign in',
            'link'  => $url('login'),
            'float' => 'right'
            ];

        $items[] = [
            'id' => 'admin',
            'label' => 'Admin',
            'dropdown' => [
                [
                    'id' => 'users',
                    'label' => 'Manage Users',
                    'link' => $url('users')
                ]
            ]
        ];

        /*
        $items[] = [
            'id' => 'logout',
            'label' => $this->authService->getIdentity(),
            'float' => 'right',
            'dropdown' => [
                [
                    'id' => 'settings',
                    'label' => 'Settings',
                    'link' => $url('application', ['action'=>'settings'])
                ],
                [
                    'id' => 'logout',
                    'label' => 'Sign out',
                    'link' => $url('logout')
                ],
            ]
        ];
        */


        return $items;
    }
}