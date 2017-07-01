<?php
namespace User\Service;


use Doctrine\ORM\EntityManagerInterface;
use MailService\Service\MailService;
use User\Entity\User;
use Zend\Math\Rand;


class UserManager
{
    protected $em;
    protected $mailService;

    public function __construct(EntityManagerInterface $em , MailService $mailService)
    {
        $this->em = $em;
        $this->mailService = $mailService;
    }

    public function addUser($data = null)
    {

        $userRepo = $this->em->getRepository(User::class);

        if($userRepo->checkUserExists($data['email'])){
            throw new \Exception('User with such email is allready exist');
        }


        $newUser = $userRepo->createNewUser($data);

        return $newUser;
    }


    public function createAdminUserIfNotExists()
    {
        $adminData = [
            'email' => 'admin@email.local',
            'full_name' => 'Admin',
            'password' => '123456'
        ];
        $userRepo = $this->em->getRepository(User::class);
        $user = $userRepo->findOneBy([]);
        if(empty($user)){
            $user = $userRepo->createNewUser($adminData);
        }

        return !(empty($user)) ? $user : false;
    }


    public function generatePasswordResetToken(User $user)
    {

        $token = Rand::getString(32,'0123456789abcdefghijklmnopqrstuvwxyz',true);
        $user->setPwdResetToken($token);
        $user->setPwdResetTokenCreationDate(new \DateTime());
        $this->em->persist($user);
        $this->em->flush();

        $httpHost = isset($_SERVER['HTTP_HOST'])?$_SERVER['HTTP_HOST']:'localhost';
        $passwordResetUrl = 'http://' . $httpHost . '/set-password/' . $token;

        //send token
        $this->mailService->sendResetTokenMail($user->getEmail(), $passwordResetUrl);

        return true;
    }


    public function validateToken($token)
    {

        $userEnt = $this->em->getRepository(User::class);
        $user = $userEnt->findOneByPwdResetToken($token);
        if(empty($user)){
            return false;
        }

        $tokenCreateDateObj = $user->getPwdResetTokenCreationDate();
        $tokenCreateDate = $tokenCreateDateObj->getTimestamp();

        $currentDate = time();
        if($currentDate - $tokenCreateDate > 24 * 60 * 60){
            return false; // token is too old
        }

        return true;
    }

    public function setNewPasswordByToken($token, $newPass)
    {
        $userEnt = $this->em->getRepository(User::class);
        $result = $userEnt->setNewPass($token, $newPass);

        return $result;
    }

}