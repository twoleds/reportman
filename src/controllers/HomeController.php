<?php
namespace Reportman\Controllers;

use Reportman\Helpers\AuthService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class HomeController extends AbstractActionController
{

    public function indexAction()
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');
        if (!$authService->authorize()) {
            $this->redirect()->toRoute('login');
        } else {
            $this->redirect()->toRoute('report-index');
        }

        return parent::indexAction();
    }

}
