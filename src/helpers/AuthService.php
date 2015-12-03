<?php
namespace Reportman\Helpers;

use Reportman\Models\User;
use Reportman\Models\UserService;
use Zend\Session\SessionManager;

class AuthService
{

    /** @var UserService */
    private $userService;

    /** @var SessionManager */
    private $sessionManager;

    /** @var User */
    private $currentUser;

    /**
     * AuthService constructor.
     *
     * @param SessionManager $sessionManager
     * @param UserService $userService
     */
    public function __construct(SessionManager $sessionManager, UserService $userService)
    {
        $this->sessionManager = $sessionManager;
        $this->userService = $userService;
    }

    /**
     * Try to authorize
     * @param null|string $email
     * @param null|string $password
     * @return bool
     */
    public function authorize($email = null, $password = null)
    {

        if (!empty($this->currentUser)) {
            return $this->currentUser;
        }

        $this->sessionManager->start();

        $sessionStorage = $this->sessionManager->getStorage();
        if (empty($email)) {
            if (!empty($sessionStorage['auth_user'])) {
                $this->currentUser = $this->userService->findById($sessionStorage['auth_user']);
            }
        } else {
            $user = $this->userService->findByEmail($email);
            if (!empty($user) && $user->verifyPassword($password)) {
                $this->currentUser = $user;
                $sessionStorage['auth_user'] = $user->getId();
                $this->sessionManager->writeClose();
            }
        }

        return !empty($this->currentUser);

    }

    /**
     * Returns the authorized user.
     *
     * @return User
     */
    public function getAuthorizedUser()
    {
        if (empty($this->currentUser)) {
            $this->authorize();
        }
        return $this->currentUser;
    }

    /**
     * Destroy authorization.
     */
    public function destroy()
    {
        $this->sessionManager->getStorage()->clear('auth_user');
    }

}
