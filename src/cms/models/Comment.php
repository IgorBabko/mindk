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

// XSS Defender

class Comment extends ActiveRecord
{
    protected $_id;
    protected $_postTitle;
    protected $_author;
    protected $_createdDate;
    protected $_text;

    public function __construct($condition = null)
    {
        if (isset($condition)) {
            $this->load($condition);
        }
    }

    public static function getTable()
    {
        return 'comments';
    }

    public static function getColumns()
    {
        return array(
            '_id'          => 'id',
            '_postTitle'   => 'post_title',
            '_author'      => 'author',
            '_createdDate' => 'created_date',
            '_text'        => 'text'
        );
    }

    public static function getConstraints($context = null)
    {
        return array(
            '_text' => array(
                new NotBlank()
            )
        );
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getPostTitle()
    {
        return $this->_postTitle;
    }

    public function getAuthor()
    {
        return $this->_author;
    }

    public function getCreatedDate()
    {
        return $this->_createdDate;
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
                "Parameter for Comment::setId method must be 'int' || 'float' || 'string', '$parameterType' is given"
            );
        }
    }

    public function setPostTitle($postTitle)
    {
        if (is_string($postTitle)) {
            $this->_postTitle = $postTitle;
        } else {
            $parameterType = gettype($postTitle);
            throw new Exception(
                "Parameter for Comment::setPostTitle method must be 'string', '$parameterType' is given"
            );
        }
    }

    public function setAuthor($author)
    {
        if (is_string($author)) {
            $this->_author = $author;
        } else {
            $parameterType = gettype($author);
            throw new Exception("Parameter for Comment::setAuthor method must be 'string', '$parameterType' is given");
        }
    }

    public function setText($text)
    {
        if (is_string($text)) {
            $this->_text = $text;
        } else {
            $parameterType = gettype($text);
            throw new Exception("Parameter for Comment::setText method must be 'string', '$parameterType' is given");
        }
    }

    public function setCreatedDate($createdDate)
    {
        if (is_string($createdDate)) {
            $this->_createdDate = $createdDate;
        } else {
            $parameterType = gettype($createdDate);
            throw new Exception(
                "Parameter for Comment::setCreatedDate method must be 'string', '$parameterType' is given"
            );
        }
    }
}