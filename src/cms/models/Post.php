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
use Framework\Validation\Constraint\Int;
use Framework\Validation\Constraint\MaxLength;
use Framework\Validation\Constraint\NotBlank;
use Framework\Validation\Constraint\Unique;


class Post extends ActiveRecord
{
    protected $_id;
    protected $_categoryId;
    protected $_title;
    protected $_smallText;
    protected $_Text;
    protected $_posted;

    public static function getTable()
    {
        return 'posts';
    }

    public static function getColumns()
    {
        return array(
            '_id'         => 'id',
            '_categoryId' => 'category_id',
            '_title'      => 'title',
            '_smallText'  => 'smallText',
            '_text'       => 'text',
            '_postedDate' => 'posted_date',
        );
    }

    public static function getConstraints($context = null)
    {
        switch($context) {
            case 'add':
                return array(
                    '_categoryId' => array(
                        new Int()
                    ),
                    '_title' => array(
                        new Unique('posts', 'title'),
                        new MaxLength(255),
                        new AlphaNumeric('"Title" field must contain only alphanumeric characters'),

                    ),
                    '_smallText' => array(
                        new NotBlank('"Small text" field must not be blank')
                    ),
                    '_text' => array(
                        new NotBlank('"Text" field must not be blank')
                    )
                );
            case 'edit':
                return array(
                    '_categoryId' => array(
                        new Int()
                    ),
                    '_title' => array(
                        new Unique('posts', 'title'),
                        new MaxLength(255),
                        new AlphaNumeric('"Title" field must contain only alphanumeric characters'),

                    ),
                    '_smallText' => array(
                        new NotBlank('"Small text" field must not be blank')
                    ),
                    '_text' => array(
                        new NotBlank('"Text" field must not be blank')
                    )
                );
        }
    }

    public function getId() {
        return $this->_id;
    }

    public function getCategoryId() {
        return $this->_categoryId;
    }

    public function getTitle() {
        return $this->_title;
    }

    public function getSmallText() {
        return $this->_smallText;
    }

    public function getText() {
        return $this->_text;
    }

    public function getPostedDate()
    {
        return $this->_postedDate;
    }

    public function setId($id) {
        if (is_int($id) || is_float($id) || is_string($id)) {
            $this->_id = $id;
        } else {
            $parameterType = gettype($id);
            throw new Exception("Parameter for User::setId method must be 'int' || 'float' || 'string', '$parameterType' is given");
        }
    }

    public function setCategoryId($categoryId) {
        if (is_int($categoryId) || is_float($categoryId) || is_string($categoryId)) {
            $this->_categoryId = $categoryId;
        } else {
            $parameterType = gettype($categoryId);
            throw new Exception("Parameter for Post::setCategoryId method must be 'int' || 'float' || 'string', '$parameterType' is given");
        }
    }

    public function setTitle($title) {
        if (is_string($title)) {
            $this->_title = $title;
        } else {
            $parameterType = gettype($title);
            throw new Exception("Parameter for Post::setTitle method must be 'string', '$parameterType' is given");
        }
    }

    public function setSmallText($smallText) {
        if (is_string($smallText)) {
            $this->_smallText = $smallText;
        } else {
            $parameterType = gettype($smallText);
            throw new Exception("Parameter for Comment::setSmallText method must be 'string', '$parameterType' is given");
        }
    }

    public function setText($text) {
        if (is_string($text)) {
            $this->_text = $text;
        } else {
            $parameterType = gettype($text);
            throw new Exception("Parameter for Text::setText method must be 'string', '$parameterType' is given");
        }
    }

    public function setPosteDate($postedDate) {
        if (is_string($postedDate)) {
            $this->_postedDate = $postedDate;
        } else {
            $parameterType = gettype($postedDate);
            throw new Exception("Parameter for Comment::setPostedDate method must be 'string', '$parameterType' is given");
        }
    }
}