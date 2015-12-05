<?php
namespace Reportman\Controllers;

use Reportman\Helpers\AuthService;
use Reportman\Helpers\DateHelper;
use Reportman\Models\Report;
use Reportman\Models\ReportService;
use Reportman\Models\UserService;
use Zend\Http\Response;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class ReportAjaxController extends AbstractRestfulController
{

    public function create($data)
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');

        /** @var ReportService $reportService */
        $reportService = $this->getServiceLocator()->get('ReportService');

        /** @var Response $response */
        $response = $this->getResponse();

        // authorize user

        if (!$authService->authorize()) {
            $response->setStatusCode(403);
            return new JsonModel([
                'error' => 'Unauthorized access.'
            ]);
        }

        // create report

        $report = new Report();

        $report->setDate(date('Y-m-d'));
        if (!empty($data['date'])) {
            try {
                $report->setDate(
                    \DateTime::createFromFormat('d.m.Y', $data['date'])->format('Y-m-d')
                );
            } catch (\Exception $ex) {
            }
        }

        $report->setIssueId($data['issueId']);
        $report->setIssueText($data['issueText']);
        $report->setSpentTime($data['spentTime']);
        $report->setEstimatedTime($data['estimatedTime']);
        $report->setComplete($data['complete']);
        $report->setUserId($authService->getAuthorizedUser()->getId());

        $reportService->save($report);

        return new JsonModel([
            'error' => null,
            'result' => $report->getId(),
        ]);

    }

    public function delete($id)
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');

        /** @var ReportService $reportService */
        $reportService = $this->getServiceLocator()->get('ReportService');

        /** @var Response $response */
        $response = $this->getResponse();

        // authorize user

        if (!$authService->authorize()) {
            $response->setStatusCode(403);
            return new JsonModel([
                'error' => 'Unauthorized access.'
            ]);
        }

        // find report by the specified id

        $report = $reportService->findById($id);

        if (empty($report)) {
            $response->setStatusCode(404);
            return new JsonModel([
                'error' => 'Report not found.'
            ]);
        }

        if (
            $report->getUserId() != $authService->getAuthorizedUser()->getId()
        ) {
            $response->setStatusCode(403);
            return new JsonModel([
                'error' => 'Unauthorized access.'
            ]);
        }

        // delete report

        $result = $reportService->delete($id);

        // return output

        return new JsonModel([
            'error' => null,
            'result' => $result,
        ]);

    }

    public function update($id, $data)
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');

        /** @var ReportService $reportService */
        $reportService = $this->getServiceLocator()->get('ReportService');

        /** @var Response $response */
        $response = $this->getResponse();

        // authorize user

        if (!$authService->authorize()) {
            $response->setStatusCode(403);
            return new JsonModel([
                'error' => 'Unauthorized access.'
            ]);
        }

        // find report by the specified id

        $report = $reportService->findById($id);

        if (empty($report)) {
            $response->setStatusCode(404);
            return new JsonModel([
                'error' => 'Report not found.'
            ]);
        }

        if (
            $report->getUserId() != $authService->getAuthorizedUser()->getId()
        ) {
            $response->setStatusCode(403);
            return new JsonModel([
                'error' => 'Unauthorized access.'
            ]);
        }

        // update report & save

        if (!empty($data['date'])) {
            try {
                $report->setDate(
                    \DateTime::createFromFormat('d.m.Y', $data['date'])->format('Y-m-d')
                );
            } catch (\Exception $ex) {
            }
        }

        if (isset($data['issueId'])) {
            $report->setIssueId($data['issueId']);
        }

        if (isset($data['issueText'])) {
            $report->setIssueText($data['issueText']);
        }

        if (isset($data['spentTime'])) {
            $report->setSpentTime($data['spentTime']);
        }

        if (isset($data['estimatedTime'])) {
            $report->setEstimatedTime($data['estimatedTime']);
        }

        if (isset($data['complete'])) {
            $report->setComplete($data['complete']);
        }

        $reportService->save($report);

        // return output

        return new JsonModel([
            'error' => null,
            'result' => true,
        ]);

    }

    public function get($id)
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');

        /** @var UserService $userService */
        $userService = $this->getServiceLocator()->get('UserService');

        /** @var ReportService $reportService */
        $reportService = $this->getServiceLocator()->get('ReportService');

        /** @var Response $response */
        $response = $this->getResponse();

        // authorize user

        if (!$authService->authorize()) {
            $response->setStatusCode(403);
            return new JsonModel([
                'error' => 'Unauthorized access.'
            ]);
        }

        // find report by the specified id

        $report = $reportService->findById($id);

        if (empty($report)) {
            $response->setStatusCode(404);
            return new JsonModel([
                'error' => 'Report not found.'
            ]);
        }

        if (
            $report->getUserId() != $authService->getAuthorizedUser()->getId()
            && !$authService->getAuthorizedUser()->isAdmin()
        ) {
            $response->setStatusCode(403);
            return new JsonModel([
                'error' => 'Unauthorized access.'
            ]);
        }

        // find user

        if ($report->getUserId() == $authService->getAuthorizedUser()->getId()) {
            $user = $authService->getAuthorizedUser();
        } else {
            $user = $userService->findById($report->getUserId());
        }

        // return output

        $formatDate = new DateHelper();

        return new JsonModel([
            'error' => null,
            'result' => [
                'id' => $report->getId(),
                'issueId' => $report->getIssueId(),
                'issueText' => $report->getIssueText(),
                'spentTime' => $report->getSpentTime(),
                'estimatedTime' => $report->getEstimatedTime(),
                'complete' => $report->getComplete(),
                'date' => $formatDate(strtotime($report->getDate())),
                'user' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'avatar' => $user->getAvatar('20'),
                ],
            ],
        ]);

    }

}
