<?php
namespace User\Entity\Repositories;


use Doctrine\ORM\EntityRepository;
use Zend\Crypt\Password\Bcrypt;

class User extends EntityRepository
{

    // User status constants.
    const STATUS_ACTIVE       = 1; // Active user.
    const STATUS_RETIRED      = 2; // Retired user.


    public function createNewUser(array $userData)
    {
        $class = $this->getClassName();

        $em = $this->getEntityManager();

        $user = new $class;
        $user->setFullName($userData['full_name']);
        $user->setEmail($userData['email']);
        $pashHash = $this->getHashPass($userData['password']);

        $user->setPassword($pashHash);
        $user->setStatus(self::STATUS_ACTIVE);
        $user->setDateCreated(new \DateTime());

        $em->persist($user);
        $em->flush();

        return $user;

    }


    public function checkUserExists($email)
    {
        $result = $this->findOneBy(['email' => $email]);

        return !empty($result)? true : false;
    }



    public function setNewPass($token, $newPass)
    {
        $userObj = $this->findOneByPwdResetToken($token);
        if(empty($userObj)){
            return false;
        }

        $hash = $this->getHashPass($newPass);
        $userObj->setPassword($hash);
        $userObj->setPwdResetToken('');
        $em = $this->getEntityManager();
        $em->persist($userObj);
        $em->flush();
        $em->clear();

        return true;
    }



    protected function getHashPass($passString)
    {
        $bcrypt = new Bcrypt();
        $hash = $bcrypt->create($passString);

        return $hash;
    }


}

