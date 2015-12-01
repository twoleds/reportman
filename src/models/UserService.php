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
