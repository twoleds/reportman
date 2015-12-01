<?php
namespace Reportman\Controllers;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SessionController extends AbstractActionController
{

    public function loginAction()
    {
        return new ViewModel();
    }

    public function logoutAction()
    {
        return $this->redirect()->toRoute('login', ['logout' => 1]);
    }

}
