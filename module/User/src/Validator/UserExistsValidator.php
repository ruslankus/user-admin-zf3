<?php

namespace User\Validator;

use User\Entity\User;
use Zend\Validator\AbstractValidator;
use Zend\Validator\Exception;

class UserExistsValidator extends AbstractValidator
{

    const NOT_SCALAR = 'notScalar';
    const USER_EXISTS = 'userExists';


    protected $messageTemplates = [
        self::NOT_SCALAR => 'The email must be a scalar value',
        self::USER_EXISTS => 'Another user with such an email already exists'
    ];

    protected $options = [
        'entityManager' => null,
        'user' => null
    ];

    public function __construct($options = null)
    {
        if(is_array($options)){
            $this->options['entityManager'] = !empty($options['entityManager']) ? $options['entityManager'] : null;
            $this->options['user'] = !empty($options['user']) ? $options['user'] : null;
        }

        parent::__construct($options);
    }

    /**
     * Returns true if and only if $value meets the validation requirements
     *
     * If $value fails validation, then this method returns false, and
     * getMessages() will return an array of messages that explain why the
     * validation failed.
     *
     * @param  mixed $value
     * @return bool
     * @throws Exception\RuntimeException If validation of $value is impossible
     */
    public function isValid($value)
    {
        if(!is_scalar($value)){
            $this->error(self::NOT_SCALAR);
            return false;
        }

        if(empty($value)){
            $this->error(self::USER_EXISTS);
            return false;
        }

        // Get Doctrine entity manager.
        $entityManager = $this->options['entityManager'];
        $userRepo = $entityManager->getRepository(User::class);
        $user = $userRepo->findByEmail($value);

        if(!empty($user)){
            $this->error(self::USER_EXISTS);
            return false;
        }

        return true;



    }
}