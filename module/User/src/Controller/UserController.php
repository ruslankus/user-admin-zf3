<?php
namespace User\Controller;


use Doctrine\ORM\EntityManagerInterface;
use User\Entity\User;
use User\Form\UserForm;
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
        $form = new UserForm('create', $this->entityManager);

        $request = $this->getRequest();
        if($request->isPost()){

            $data = $this->params()->fromPost();
            $form->setData($data);

            if($form->isValid()){

                $clearData = $form->getData();
                $newUser = $this->userManger->addUser($clearData);
                if(!empty($newUser)){
                    return $this->redirect()->toRoute('users', ['action' => 'view', 'id' => $newUser->getId() ]);
                }
            }
        }

        return new ViewModel(compact('form'));
    }


    public function editAction()
    {
        return new ViewModel();
    }


    public function viewAction()
    {

        $userId = (int)$this->params()->fromRoute('id');
        $userRepo = $this->entityManager->getRepository(User::class);
        $user = $userRepo->find($userId);


        return new ViewModel(compact('user'));
    }


    public function changePasswordAction()
    {

    }


    public function resetPasswordAction()
    {

    }

}