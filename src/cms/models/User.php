<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:09 PM
 */

namespace CMS\Models;

use Exception;
use Framework\Model\ActiveRecord;
use Framework\Validation\Constraint\AlphaNumeric;
use Framework\Validation\Constraint\Email;
use Framework\Validation\Constraint\Match;
use Framework\Validation\Constraint\MinLength;
use Framework\Validation\Constraint\NotBlank;
use Framework\Validation\Constraint\Unique;

class User extends ActiveRecord
{
    protected $_id;
    protected $_username;
    protected $_password;
    protected $_email;
    protected $_picturePath;
    protected $_salt;
    protected $_role;
    protected $_joinedDate;

    public function __construct($condition = null)
    {
        if (isset($condition)) {
            $this->load($condition);
        }
    }

    public static function getTable()
    {
        return 'users';
    }

    public static function getColumns()
    {
        return array(
            '_id'          => 'id',
            '_username'    => 'username',
            '_password'    => 'password',
            '_email'       => 'email',
            '_picturePath' => 'picture_path',
            '_salt'        => 'salt',
            '_role'        => 'role',
            '_joinedDate'  => 'joined_date'
        );
    }

    public static function getConstraints($context)
    {
        switch ($context) {
            case 'signup':
                return array(
                    '_username' => array(
                        new Unique('users', 'username'),
                        new AlphaNumeric('Username must contain only alphanumeric characters'),
                        new NotBlank('Username must not be blank')
                    ),
                    '_password' => array(
                        new Match($_POST['confirmation'], '"Confirm password" field must match "password" field'),
                        new MinLength(8, 'Password length must be at least 8 characters'),
                        new NotBlank('"Password" field must not be blank')
                    ),
                    '_email'    => array(
                        new Unique('users', 'email'),
                        new Email('Email address is not valid'),
                        new NotBlank('Email must not be blank')
                    )
                );
            case 'update':
                return array(
                    '_username' => array(
                        new Unique(
                            'users',
                            'username',
                            isset($_SESSION['user']['name'])?array($_SESSION['user']['name']):null
                        ),
                        new AlphaNumeric('Username must contain only alphanumeric characters'),
                        new NotBlank('Username must not be blank')
                    ),
                    '_email'    => array(
                        new Unique(
                            'users',
                            'email',
                            isset($_SESSION['user']['email'])?array($_SESSION['user']['email']):null
                        ),
                        new Email('Email address is not valid')
                    )
                );
            case 'change_password':
                return array(
                    '_password' => array(
                        new Match($_POST['_confirmation'], '"Confirm password" field must match "password" field'),
                        new MinLength(8, 'Password length must be at least 8 characters'),
                        new NotBlank('Username must not be blank')
                    )
                );
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getUsername()
    {
        return $this->_username;
    }

    public function getEmail()
    {
        return $this->_email;
    }

    public function getPicturePath()
    {
        return $this->_picturePath;
    }

    public function getPassword()
    {
        return $this->_password;
    }

    public function getSalt()
    {
        return $this->_salt;
    }

    public function getRole()
    {
        return $this->_role;
    }

    public function getJoinedDate()
    {
        return $this->_joinedDate;
    }

    public function setId($id)
    {
        if (is_int($id) || is_float($id) || is_string($id)) {
            $this->_id = $id;
        } else {
            $parameterType = gettype($id);
            throw new Exception(
                "Parameter for User::setId method must be 'int' || 'float' || 'string', '$parameterType' is given"
            );
        }
    }

    public function setUsername($username)
    {
        if (is_string($username)) {
            $this->_username = $username;
        } else {
            $parameterType = gettype($username);
            throw new Exception("Parameter for User::setUsername method must be 'string', '$parameterType' is given");
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->_email = $email;
        } else {
            $parameterType = gettype($email);
            throw new Exception("Parameter for User::setEmail method must be 'string', '$parameterType' is given");
        }
    }

    public function setPicturePath($picturePath)
    {
        if (is_string($picturePath)) {
            $this->_picturePath = $picturePath;
        } else {
            $parameterType = gettype($picturePath);
            throw new Exception(
                "Parameter for User::setPicturePath method must be 'string', '$parameterType' is given"
            );
        }
    }

    public function setPassword($password)
    {
        if (is_string($password)) {
            $this->_password = $password;
        } else {
            $parameterType = gettype($password);
            throw new Exception("Parameter for User::setPassword method must be 'string', '$parameterType' is given");
        }
    }

    public function setSalt($salt)
    {
        if (is_string($salt)) {
            $this->_salt = $salt;
        } else {
            $parameterType = gettype($salt);
            throw new Exception("Parameter for User::setSalt method must be 'string', '$parameterType' is given");
        }
    }

    public function setRole($role)
    {
        if (is_string($role)) {
            $this->_role = $role;
        } else {
            throw new Exception(
                "Parameter value for User::setRole method must be 'GUEST' || 'USER' ||  'ADMIN', '$role' is given"
            );
        }
    }

    public function setJoinedDate($joinedDate)
    {
        if (is_string($joinedDate)) {
            $this->_joinedDate = $joinedDate;
        } else {
            $parameterType = gettype($joinedDate);
            throw new Exception("Parameter for User::setJoinedDate method must be 'string', '$parameterType' is given");
        }
    }
}