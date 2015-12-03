<?php
namespace Reportman\Controllers;

use Reportman\Helpers\AuthService;
use Reportman\Models\User;
use Reportman\Models\UserService;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class UserController extends AbstractActionController
{

    public function loginAction()
    {

        // redirect to homepage if user is already authorized

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');
        if ($authService->authorize()) {
            return $this->redirect()->toRoute('home', []);
        }

        // process post form

        $viewModel = new ViewModel();
        if (!empty($_POST)) {

            $email = new Input('email');
            $email->getValidatorChain()
                ->attach(new EmailAddress());

            $password = new Input('password');
            $password->getValidatorChain()
                ->attach(new StringLength(6));

            $inputFilter = new InputFilter();
            $inputFilter
                ->add($email)
                ->add($password)
                ->setData($_POST);

            $viewModel->setVariable('email', $inputFilter->getRawValue('email'));

            if ($inputFilter->isValid()) {
                if ($authService->authorize($inputFilter->getValue('email'), $inputFilter->getValue('password'))) {

                    if (!empty($_POST['remember'])) {
                        setcookie('email', $inputFilter->getValue('email'), time() + 365 * 24 * 60 * 60, '/', null, null, true);
                    } else {
                        setcookie('email', '', time() - 24 * 60 * 60, '/', null, null, true);
                    }

                    $this->redirect()->toRoute('home', [], ['query' => ['login' => 1]]);

                }
            }

            $viewModel->setVariable('error', true);

        } else {

            $email = new Input('email');
            $email->getValidatorChain()
                ->attach(new EmailAddress());

            $inputFilter = new InputFilter();
            $inputFilter->add($email)->setData($_COOKIE);

            if ($inputFilter->isValid()) {
                $viewModel->setVariable('email', $inputFilter->getValue('email'));
                $viewModel->setVariable('remember', true);
            }

        }

        return $viewModel;
    }

    public function logoutAction()
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');
        if (!empty($authService->authorize())) {
            $authService->destroy();
            $this->redirect()->toRoute('login', [], ['query' => ['logout' => 1]]);
        }

        return $this->redirect()->toRoute('login', ['logout' => 1]);
    }

    public function registerAction()
    {

        $viewModel = new ViewModel();
        if (!empty($_POST)) {

            $name = new Input('name');
            $name->getValidatorChain()
                ->attach(new StringLength(1));

            $email = new Input('email');
            $email->getValidatorChain()
                ->attach(new EmailAddress());

            $password = new Input('password');
            $password->getValidatorChain()
                ->attach(new StringLength(6));

            $passwordCheck = new Input('password_check');
            $passwordCheck->getValidatorChain()
                ->attach(new StringLength(6));

            $inputFilter = new InputFilter();
            $inputFilter
                ->add($name)
                ->add($email)
                ->add($password)
                ->add($passwordCheck)
                ->setData($_POST);

            $viewModel->setVariable('name', $inputFilter->getRawValue('name'));
            $viewModel->setVariable('email', $inputFilter->getRawValue('email'));

            if ($inputFilter->isValid() && $inputFilter->getValue('password') == $inputFilter->getValue('password_check')) {

                $user = new User();
                $user->setName($inputFilter->getValue('name'));
                $user->setEmail($inputFilter->getValue('email'));
                $user->setPassword($inputFilter->getValue('password'));

                /** @var UserService $userService */
                $userService = $this->getServiceLocator()->get('UserService');

                try {
                    $userService->save($user);
                    $this->redirect()->toRoute('login', [], ['query' => ['register' => 1]]);
                } catch (\Exception $ex) {
                    // TODO: Handle DB error
                }

            }

            $viewModel->setVariable('error', true);

        }

        return $viewModel;

    }

    public function keepAliveAction()
    {

        /** @var AuthService $authService */
        $authService = $this->getServiceLocator()->get('AuthService');

        $response = $this->getResponse();
        $response->setContent(Json::encode([
            'result' => $authService->authorize()
        ]));

        return $response;

    }

}
