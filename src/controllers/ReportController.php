<?php
namespace Reportman\Controllers;

use Reportman\Helpers\AuthService;
use Reportman\Helpers\DateHelper;
use Reportman\Helpers\TimeHelper;
use Reportman\Models\Report;
use Reportman\Models\ReportService;
use Reportman\Models\UserService;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
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

        // process input parameters

        $dateFrom = !empty($_GET['from']) ? strtotime($_GET['from']) : strtotime('first day of this month', time());
        $dateTo = !empty($_GET['to']) ? strtotime($_GET['to']) : strtotime('last day of this month', time());
        $issueId = !empty($_GET['issue']) ? intval($_GET['issue']) : null;
        $userId = !empty($_GET['user']) ? intval($_GET['user']) : null;

        // select users for filter

        /** @var UserService $userService */
        $userService = $this->getServiceLocator()->get('UserService');

        $users = [];
        if ($authService->getAuthorizedUser()->isAdmin()) {
            $users = $userService->findAll();
        }

        // find user's reports

        /** @var ReportService $reportService */
        $reportService = $this->getServiceLocator()->get('ReportService');

        $filterUserId = $authService->getAuthorizedUser()->getId();
        if (!empty($userId) && $authService->getAuthorizedUser()->isAdmin()) {
            $filterUserId = $userId;
        }

        $reports = $reportService->findByUser(
            $filterUserId,
            date('Y-m-d', $dateFrom),
            date('Y-m-d', $dateTo),
            $issueId
        );

        // set variables for view

        $viewModel = new ViewModel();
        $viewModel->setVariable('reports', $reports);
        $viewModel->setVariable('dateFrom', $dateFrom);
        $viewModel->setVariable('dateTo', $dateTo);
        $viewModel->setVariable('issueId', $issueId);
        $viewModel->setVariable('userId', $userId);
        $viewModel->setVariable('users', $users);
        return $viewModel;
    }

    public function exportAction()
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');
        if (!$authService->authorize()) {
            $this->redirect()->toRoute('login');
        }

        $this->layout()->setVariable('currentUser', $authService->getAuthorizedUser());

        // process input parameters

        $dateFrom = !empty($_GET['from']) ? strtotime($_GET['from']) : strtotime('first day of this month', time());
        $dateTo = !empty($_GET['to']) ? strtotime($_GET['to']) : strtotime('last day of this month', time());
        $issueId = !empty($_GET['issue']) ? intval($_GET['issue']) : null;
        $userId = !empty($_GET['user']) ? intval($_GET['user']) : null;

        // find user's reports

        /** @var ReportService $reportService */
        $reportService = $this->getServiceLocator()->get('ReportService');

        $filterUserId = $authService->getAuthorizedUser()->getId();
        if (!empty($userId) && $authService->getAuthorizedUser()->isAdmin()) {
            $filterUserId = $userId;
        }

        $reports = $reportService->findByUser(
            $filterUserId,
            date('Y-m-d', $dateFrom),
            date('Y-m-d', $dateTo),
            $issueId
        );


        /** @var UserService $userService */
        $userService = $this->getServiceLocator()->get('UserService');
        $user = $userService->findById($filterUserId);

        // create csv

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="reports-' . $user->getAlias() . '.csv"');

        $file = fopen('php://output', 'w');

        fputcsv($file, [
            'Date',
            'Issue Id',
            'Issue Text',
            'Spent time',
            'Estimated Time',
            'Complete'
        ]);

        $formatTime = new TimeHelper();
        $formatDate = new DateHelper();

        /** @var Report $report */
        foreach ($reports as $report) {
            fputcsv($file, [
                $formatDate(strtotime($report->getDate())),
                $report->getIssueId(),
                $report->getIssueText(),
                $formatTime($report->getSpentTime()),
                $formatTime($report->getEstimatedTime()),
                $report->getComplete() . '%'
            ]);
        }

        fclose($file);
        exit;

    }

}
