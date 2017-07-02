<?php

namespace User\Form;

use User\Validator\UserExistsValidator;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\Hostname;

class UserForm extends Form
{
    // update or create
    private $scenario;

    private $entityManager = null;

    /**
     * @var User\Entity\User
     */
    private $user = null;


    public function __construct($scenario = 'create', $entityManager = null, $user = null)
    {
        parent::__construct('usser-form');

        $this->setAttribute('method', 'post');

        $this->scenario = $scenario;
        $this->entityManager = $entityManager;
        $this->user = $user;

        $this->addElements();
        $this->addInputFilter();
    }


    protected function addElements()
    {
        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'E-mail',
            ],
        ]);

        // Add "full_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'full_name',
            'options' => [
                'label' => 'Full Name',
            ],
        ]);

        if($this->scenario == 'create'){

            // Add "password" field
            $this->add([
                'type'  => 'password',
                'name' => 'password',
                'options' => [
                    'label' => 'Password',
                ],
            ]);

            // Add "confirm_password" field
            $this->add([
                'type'  => 'password',
                'name' => 'confirm_password',
                'options' => [
                    'label' => 'Confirm password',
                ],
            ]);

        }

        // Add "status" field
        $this->add([
            'type'  => 'select',
            'name' => 'status',
            'options' => [
                'label' => 'Status',
                'value_options' => [
                    1 => 'Active',
                    2 => 'Retired',
                ]
            ],
        ]);


        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Create'
            ],
        ]);


    }


    protected function addInputFilter()
    {
        $inputFilter = new InputFilter();

        $inputFilter->add(
            [
                'name' => 'email',
                'required' => true,
                'filters' => [
                    ['name' => 'StringTrim']
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 64
                        ]

                    ],
                    [
                        'name' => "EmailAddress",
                        'options' => [
                            'allow' => Hostname::ALLOW_DNS,
                            'usesMxCheck' => false
                        ]
                    ],
                    [
                        'name' => UserExistsValidator::class,
                        'options' => [
                            'entityManager' => $this->entityManager,
                            'user' => $this->user
                        ]
                    ]

                ]
            ]
        );//add Email


        $inputFilter->add(
            [
                'name'     => 'full_name',
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 1,
                            'max' => 128
                        ]
                    ]
                ]
            ]
        );//add fullname

        $inputFilter->add(
            [
                'name'     => 'password',
                'required' => true,
                'filters'  => [],
                'validators' => [
                    [
                        'name'    => 'StringLength',
                        'options' => [
                            'min' => 6,
                            'max' => 32
                        ]
                    ]
                ]
            ]
        );//add password


        $inputFilter->add([
            'name'     => 'confirm_password',
            'required' => true,
            'filters'  => [],
            'validators' => [
                [
                    'name'    => 'Identical',
                    'options' => [
                        'token' => 'password',
                    ]
                ]
            ]

        ]);//add confirm_password

        $inputFilter->add([
            'name'     => 'status',
            'required' => true,
            'filters'  => [
                ['name' => 'ToInt'],
            ],
            'validators' => [
                ['name'=>'InArray', 'options'=>['haystack'=>[1, 2]]]
            ]
        ]);

        $this->setInputFilter($inputFilter);
    }

}