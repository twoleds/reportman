<?php
namespace Reportman\Controllers;

use Reportman\Helpers\AuthService;
use Reportman\Models\ReportService;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ReportController extends AbstractActionController
{

    public function createAction()
    {
        return parent::indexAction();
    }

    public function indexAction()
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');
        if (!$authService->authorize()) {
            $this->redirect()->toRoute('login');
        }

        $this->layout()->setVariable('currentUser', $authService->getAuthorizedUser());

        // find user's reports

        /** @var ReportService $reportService */
        $reportService = $this->getServiceLocator()->get('ReportService');

        $reports = $reportService->findByUser(
            $authService->getAuthorizedUser()->getId(),
            date('Y-m-d', strtotime('first day of this month', time())),
            date('Y-m-d', strtotime('last day of this month', time()))
        );

        $viewModel = new ViewModel();
        $viewModel->setVariable('reports', $reports);
        return $viewModel;
    }

}
