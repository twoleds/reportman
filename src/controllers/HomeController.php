<?php
namespace Reportman\Controllers;

use Reportman\Models\User;
use Reportman\Models\UserService;
use Zend\Mvc\Controller\AbstractActionController;

class HomeController extends AbstractActionController
{

    public function indexAction()
    {

        /** @var UserService $userService */
        $userService = $this->getServiceLocator()->get('UserService');

//        $user = new User();
//        $user->setName('Jaroslav Kuba');
//        $user->setEmail('kubajaroslav@gmail.com');
//        $user->setPassword('localhost');
//
//        $userService->save($user);

        return parent::indexAction();
    }

}
