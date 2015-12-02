<?php
namespace Reportman\Controllers;

use Reportman\Helpers\AuthService;
use Zend\InputFilter\Input;
use Zend\InputFilter\InputFilter;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Validator\EmailAddress;
use Zend\Validator\StringLength;
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

            var_dump($inputFilter->isValid());

            $viewModel->setVariable('email', $inputFilter->getRawValue('email'));

            if ($inputFilter->isValid()) {
                if ($authService->authorize($inputFilter->getValue('email'), $inputFilter->getValue('password'))) {

                    if (!empty($_POST['remember'])) {
                        setcookie('email', $inputFilter->getValue('email'), time() + 365*24*60*60, '/', null, null, true);
                    } else {
                        setcookie('email', '', time() - 24*60*60, '/', null, null, true);
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



    }

}
