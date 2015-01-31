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
use Framework\Validation\Constraint\NotBlank;
use Framework\Validation\Constraint\Unique;

class Category extends ActiveRecord
{
    protected $_id;
    protected $_name;

    public function __construct($condition = null)
    {
        if (isset($condition)) {
            $this->load($condition);
        }
    }

    public static function getTable()
    {
        return 'categories';
    }

    public static function getColumns()
    {
        return array(
            '_id' => 'id',
            '_name' => 'name',
        );
    }

    public static function getConstraints($context = null)
    {
        switch ($context) {
            case 'add':
                return array(
                    '_name' => array(
                        new Unique('categories', 'name'),
                        new NotBlank('"Category name" field must not be blank')
                    )
                );
            case 'edit':
                return array(
                    '_name' => array(
                        new Unique('categories', 'name'),
                        new NotBlank('"Category name" field must not be blank')
                    )
                );
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getName()
    {
        return $this->_name;
    }

    public function setId($id)
    {
        if (is_int($id) || is_float($id) || is_string($id)) {
            $this->_id = $id;
        } else {
            $parameterType = gettype($id);
            throw new Exception(
                "Parameter for Category::setId method must be 'int' || 'float' || 'string', '$parameterType' is given"
            );
        }
    }

    public function setName($name)
    {
        if (is_string($name)) {
            $this->_name = $name;
        } else {
            $parameterType = gettype($name);
            throw new Exception("Parameter for Category::setName method must be 'string', '$parameterType' is given");
        }
    }
}