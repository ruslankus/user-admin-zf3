<?php
namespace User\Controller;


use Doctrine\ORM\EntityManagerInterface;
use User\Entity\User;
use User\Service\UserManager;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    protected $entityManager;

    protected $userManger;

    public function __construct(EntityManagerInterface $entityManager, UserManager $userManager)
    {
        $this->entityManager = $entityManager;
        $this->userManger = $userManager;
    }

    public function indexAction()
    {
        $userRepo = $this->entityManager->getRepository(User::class);
        $users = $userRepo->findBy([],['id' => 'ASC']);

        return new ViewModel(compact('users'));
    }


    public function addAction()
    {
        return new ViewModel();
    }


    public function editAction()
    {
        return new ViewModel();
    }


    public function viewAction()
    {

    }


    public function changePasswordAction()
    {

    }


    public function resetPasswordAction()
    {

    }

}