<?php
/**
 * Created by PhpStorm.
 * User: dgilan
 * Date: 10/17/14
 * Time: 12:09 PM
 */

namespace Blog\Model;

use Framework\Database\ActiveRecord;

class User extends ActiveRecord
{
    private $_id;
    private $_email;
    private $_password;
    private $_role;

    public function __construct() {

    }

//    public static function getTable()
//    {
//        return 'users';
//    }

    public function getRole()
    {
        return $this->role;
    }
}