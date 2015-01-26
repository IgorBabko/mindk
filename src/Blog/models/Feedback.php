<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:09 PM
 */

namespace Blog\Models;

use Exception;
use Framework\Model\ActiveRecord;
use Framework\Validation\Constraint\AlphaNumeric;
use Framework\Validation\Constraint\Email;
use Framework\Validation\Constraint\NotBlank;
use Framework\Validation\Constraint\Unique;

class Feedback extends ActiveRecord
{
    protected $_id;
    protected $_username;
    protected $_email;
    protected $_text;

    public static function getTable()
    {
        return 'feedbacks';
    }

    public static function getColumns()
    {
        return array(
            '_id' => 'id',
            '_username' => 'username',
            '_email' => 'email',
            '_text' => 'text'
        );
    }

    public static function getConstraints($context = null)
    {
        return array(
            '_username' => array(
                new NotBlank('"Username" field must not be blank'),
                new AlphaNumeric('"Username" field must contain only alphanumeric characters'),
                new Unique('feedback', 'username')
            ),
            '_email'    => array(
                new Email('Email address is not valid'),
                new Unique('feedback', 'email'),
                new NotBlank('Email must not be blank')
            ),
            '_text'     => array(
                new NotBlank('"Text" field must not be blank'),
            ),
        );
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

    public function getText()
    {
        return $this->_text;
    }

    public function setId($id)
    {
        if (is_int($id) || is_float($id) || is_string($id)) {
            $this->_id = $id;
        } else {
            $parameterType = gettype($id);
            throw new Exception(
                "Parameter for Feedback::setId method must be 'int' || 'float' || 'string', '$parameterType' is given"
            );
        }
    }

    public function setUsername($username)
    {
        if (is_string($username)) {
            $this->_username = $username;
        } else {
            $parameterType = gettype($username);
            throw new Exception(
                "Parameter for Feedback::setUsername method must be 'string', '$parameterType' is given"
            );
        }
    }

    public function setEmail($email)
    {
        if (is_string($email)) {
            $this->_email = $email;
        } else {
            $parameterType = gettype($email);
            throw new Exception("Parameter for Feedback::setEmail method must be 'string', '$parameterType' is given");
        }
    }

    public function setText($text)
    {
        if (is_string($text)) {
            $this->_text = $text;
        } else {
            $parameterType = gettype($text);
            throw new Exception("Parameter for Feedback::setText method must be 'string', '$parameterType' is given");
        }
    }
}