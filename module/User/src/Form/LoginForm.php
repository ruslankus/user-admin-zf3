<?php

namespace User\Form;


use Zend\Form\Form;

class LoginForm extends Form
{

    public function __construct($name = null, array $options = [])
    {
        parent::__construct('login-form');

        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilters();
    }


    public function addElements()
    {
        $this->add([
            'type' => 'password'

        ]);
    }



    public function addInputFilters()
    {

    }


}