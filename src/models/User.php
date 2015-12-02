<?php
namespace Reportman\Models;

/**
 * Class User represents an user in the system.
 *
 * @package Reportman\Models
 */
class User
{

    /** @var int */
    private $id;

    /** @var string */
    private $name;

    /** @var string */
    private $email;

    /** @var string */
    private $password;

    /**
     * Initializes new instance of an user.
     *
     * @param array $params
     */
    public function __construct(array $params = null)
    {
        if (!empty($params)) {
            $this->id = (int)$params['id'];
            $this->name = (string)$params['name'];
            $this->email = (string)$params['email'];
            $this->password = (string)$params['password'];
        }
    }

    /**
     * Returns the unique identifier of this user. This identifier is
     * generated by the database via the auto increment column.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Sets the unique identifier of this user. This identifier is generated
     * by the database via the auto increment column.
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Returns the full name of this user.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Sets the full name of this user.
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Returns the email address of this user. This email address is used
     * for logging to the application or sending notifications.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Sets the email address of this user. This email address is used
     * for logging to the application or sending notifications.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Returns the password of this user. The password will be protected
     * by the function password_hash in PHP.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Sets the password of this user. The password will be protected by
     * the function password_hash in PHP.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        return $this;
    }

    /**
     * Verifies the password of this user. Returns true if the password match
     * the user's password; otherwise returns false. The password is protected
     * by the function password_hash in PHP.
     *
     * @param string $password
     * @return bool
     */
    public function verifyPassword($password)
    {
        return password_verify($password, $this->password);
    }

}
