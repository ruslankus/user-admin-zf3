<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class PasswordChangeForm extends Form
{
    protected $scenario;

    public function __construct($scenario = 'change')
    {
        parent::__construct('password-change-form');
        $this->scenario = $scenario;

        $this->setAttribute('method', 'post');

        $this->addElement();
        $this->addInputFilter();
    }



    protected function addElement()
    {
        if('change' == $this->scenario){

            $this->add([
                'type' => 'password',
                'name' => 'old-password',
                'options' => [
                    'label' => 'Old password'
                ]
            ]);

            // Add "new_password" field
            $this->add([
                'type' => 'password',
                'name' => 'new-password',
                'options' => [
                    'label' => 'New password'
                ]
            ]);

            // Add "confirm_new_password" field
            $this->add([
                'type' => 'password',
                'name' => 'confirm-new-password',
                'options' => [
                    'label' => 'Confirm new password'
                ]
            ]);

            // Add the CSRF field
            $this->add([
                'type' => 'csrf',
                'name' => 'csrf',
                'options' => [
                    'csrf_options' => [
                        'timout' => 600
                    ]
                ]

            ]);


            $this->add([
                'type' => 'submit',
                'name' => 'submit',
                'attributes' => [
                    'value' => 'Change Password'
                ]
            ]);

        }//if



    }




    protected function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        if('change' == $this->scenario){


            $inputFilter->add([
                'name' => 'old-password',
                'required' => true,
                'filters' => [],
                'validators' => [

                    [
                        'name' => 'StringLength',
                        'options' => [
                            'min' => 6,
                            'max' => 64
                        ]
                    ]
                ]
            ]);

        }


        $inputFilter->add([
            'name' => 'new-password',
            'required' => true,
            'filters' => [],
            'validators' => [

                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ]
                ]
            ]
        ]);



        $inputFilter->add([
            'name' => 'confirm-new-password',
            'required' => true,
            'filters' => [],
            'validators' => [

                [
                    'name' => 'Identical',
                    'options' => [
                       'token' => 'new-password'
                    ]
                ]
            ]
        ]);
    }

}