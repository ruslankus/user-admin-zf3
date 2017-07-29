<?php

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use Zend\Validator\EmailAddress;
use Zend\Validator\Hostname;

class PasswordResetForm extends Form
{

    public function __construct($name = null, array $options = [])
    {
        parent::__construct('password-reset-form');

        $this->setAttribute('method', 'post');
        $this->addElements();
        $this->addInputFilter();
    }


    protected function addElements()
    {
        //Add mail field;
        $this->add([
            'type' => 'email',
            'name' => 'email',
            'option' => [
                'label' => 'Your E-mail'
            ]
        ]);

        //Add captcha field;
        $this->add([
           'type' => 'captcha',
           'name' => 'captcha',
           'options' => [
               'label' => 'Human check',
               'captcha' => [
                   'class' => 'Image',
                   'imgDir' => 'public/img/captcha',
                   'suffix' => 'png',
                   'imgUrl' => '/img/captcha/',
                   'imgAlt' => 'CAPTCHA Image',
                   'font' => './data/font/ThorneShaded.ttf',
                   'fsize' => 24,
                   'width' => 350,
                   'height' => 100,
                   'expiration' => 600,
                   'dotNoiseLevel' => 40,
                   'lineNoiseLevel' => 3,
                   'wordLen' => 4

               ]
           ]
        ]);


        // Add the CSRF field;
        $this->add([
            'type' => 'csrf',
            'name' => 'csrf',
            'options' => [
                'csfr_options' => [
                    'timeout' => 600
                ]
            ]
        ]);


        // Add the Submit button
        $this->add([
            'type'  => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Reset Password',
                'id' => 'submit',
            ],
        ]);

    }

    protected function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        //Email filter;
        $inputFilter->add([
           'name' => 'email',
           'required' => true,
           'filter' => [
                ['name' => 'StringTrrim']
           ],
           'validators' => [
               [
                   'name' => 'EmailAddress',
                   'options' => [
                       'allow' => Hostname::ALLOW_DNS,
                       'useMxCheck' => false
                   ]
               ]
           ]
        ]);

    }


}