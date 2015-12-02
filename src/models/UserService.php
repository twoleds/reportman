<?php
namespace Reportman\Models;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Adapter\ParameterContainer;

class UserService
{

    /** @var Adapter */
    private $adapter;

    /**
     * UserService constructor.
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Find user by the specified email address.
     *
     * @param string $email
     * @return null|User
     */
    public function findByEmail($email)
    {
        $statement = $this->adapter->createStatement(
            'SELECT * FROM `users` WHERE `email` = :email LIMIT 1'
        );

        $params = new ParameterContainer();
        $params['email'] = $email;

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        $user = null;
        if ($result->count() > 0) {
            $result->rewind();
            $user = new User($result->current());
        }

        return $user;
    }

    /**
     * Find user by the specified identifier.
     *
     * @param int $id
     * @return null|User
     */
    public function findById($id)
    {
        $statement = $this->adapter->createStatement(
            'SELECT * FROM `users` WHERE `id` = :id LIMIT 1'
        );

        $params = new ParameterContainer();
        $params['id'] = $id;

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        $user = null;
        if ($result->count() > 0) {
            $result->rewind();
            $user = new User($result->current());
        }

        return $user;
    }

    /**
     * Store the specified user to database.
     *
     * @param User $user
     */
    public function save(User $user)
    {

        $params = new ParameterContainer();
        $params['name'] = $user->getName();
        $params['email'] = $user->getEmail();
        $params['password'] = $user->getPassword();

        if (empty($user->getId())) {
            $statement = $this->adapter->createStatement(
                'INSERT INTO `users` SET ' .
                '`name` = :name, ' .
                '`email` = :email, ' .
                '`password` = :password'
            );
        } else {
            $statement = $this->adapter->createStatement(
                'UPDATE `users` SET ' .
                '`name` = :name, ' .
                '`email` = :email, ' .
                '`password` = :password ' .
                'WHERE `id` = :id'
            );
            $params['id'] = $user->getId();
        }

        $statement->setParameterContainer($params);
        $result = $statement->execute();

        if (empty($user->getId())) {
            $user->setId($result->getGeneratedValue());
        }

    }

}
