<?php
namespace User\Controller;


use Doctrine\ORM\EntityManagerInterface;
use User\Entity\User;
use User\Form\PasswordChangeForm;
use User\Form\PasswordResetForm;
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
        $userId = (int)$this->params()->fromRoute('id');
        $response = $this->getResponse();
        $request = $this->getRequest();
        if(empty($userId)){
            //TODO Need to make not found controller
            $response->setStatusCode(404);
            throw new \RuntimeException('User not found', 404);

        }

        $userRepo = $this->entityManager->getRepository(User::class);
        $user = $userRepo->find($userId);
        if(empty($user)){
            //TODO Need to make not found controller
            $response->setStatusCode(404);
            throw new \RuntimeException('User not found', 404);

        }

        $form = new UserForm('update',$this->entityManager, $user);

        if($request->isPost()){


        }else{
            $form->setData([
                'full_name' => $user->getFullName(),
                'email' => $user->getEmail(),
                'status' => $user->getStatus()
            ]);
        }







        return new ViewModel(compact('form', 'user'));
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
        $id  = (int)$this->params()->fromRoute('id', null);
        if(empty($id)){
            $responce = $this->getResponse();
            $responce->setStatusCode(404);
            return;
        }

        $userRepo = $this->entityManager->getRepository(User::class);
        $user = $userRepo->find($id);
        if(empty($user)){
            $responce = $this->getResponse();
            $responce->setStatusCode(404);
            return;
        }

        $form = new PasswordChangeForm();

        $request = $this->request;
        if($request->isPost()){

            $data = $this->params()->fromPost();
            $form->setData($data);

            if($form->isValid()){

                $formData = $form->getData();

                $result = $this->userManger->changePassword($user, $formData);
                $flashMessenger = $this->flashMessenger();

                if(!$result){
                    $flashMessenger->addErrorMessage(
                      "Sorry, the old password is incorrect. Could not set the new password."
                    );
                }else{
                    $flashMessenger->addSuccessMessage(
                        "Changed the password successfully."
                    );
                }

                //redirect
                return $this->redirect()->toRoute('users',['action' => 'view', 'id' => $user->getId()]);
            }

        }


        return new ViewModel(compact('user','form'));

    }


    public function resetPasswordAction()
    {
        $form = new PasswordResetForm();

        $request = $this->getRequest();
        if($request->isPost()){
            $form->setData($this->params()->fromPost());

            if($form->isValid()){
                //do something
            }
        }


        return new ViewModel(compact('form'));
    }

}