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
use Framework\Sanitization\Filter\FHtmlEntity;
use Framework\Validation\Constraint\AlphaNumeric;
use Framework\Validation\Constraint\MaxLength;
use Framework\Validation\Constraint\NotBlank;
use Framework\Validation\Constraint\Unique;

class Post extends ActiveRecord
{
    protected $_id;
    protected $_category;
    protected $_title;
    protected $_smallText;
    protected $_text;
    protected $_postedDate;
    protected $_amountOfComments;

    public function __construct($condition = null)
    {
        if (isset($condition)) {
            $this->load($condition);
        }
    }

    public static function getTable()
    {
        return 'posts';
    }

    public static function getColumns()
    {
        return array(
            '_id'               => 'id',
            '_category'         => 'category',
            '_title'            => 'title',
            '_smallText'        => 'small_text',
            '_text'             => 'text',
            '_postedDate'       => 'posted_date',
            '_amountOfComments' => 'amount_of_comments'
        );
    }

    public static function getFilters() {
        return array(
            '_smallText' => array(
                new FHtmlEntity()
            ),
            '_text' => array(
                new FHtmlEntity()
            )
        );
    }

    public static function getConstraints($context = null)
    {
        switch ($context) {
            case 'add':
                return array(
                    '_title'     => array(
                        new Unique('posts', 'title'),
                        new MaxLength(255),

                    ),
                    '_smallText' => array(
                        new NotBlank('"Small text" field must not be blank')
                    ),
                    '_text'      => array(
                        new NotBlank('"Text" field must not be blank')
                    )
                );
            case 'edit':
                return array(
                    '_title'     => array(
                        new MaxLength(255)
                    ),
                    '_smallText' => array(
                        new NotBlank('"Small text" field must not be blank')
                    ),
                    '_text'      => array(
                        new NotBlank('"Text" field must not be blank')
                    )
                );
        }
    }

    public function getId()
    {
        return $this->_id;
    }

    public function getCategory()
    {
        return $this->_category;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getSmallText()
    {
        return $this->_smallText;
    }

    public function getText()
    {
        return $this->_text;
    }

    public function getPostedDate()
    {
        return $this->_postedDate;
    }

    public function getAmountOfComments()
    {
        return $this->_amountOfComments;
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

    public function setCategory($category)
    {
        if (is_string($category)) {
            $this->_category = $category;
        } else {
            $parameterType = gettype($category);
            throw new Exception("Parameter for Post::setCategory method must be 'string', '$parameterType' is given");
        }
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->_title = $title;
        } else {
            $parameterType = gettype($title);
            throw new Exception("Parameter for Post::setTitle method must be 'string', '$parameterType' is given");
        }
    }

    public function setSmallText($smallText)
    {
        if (is_string($smallText)) {
            $this->_smallText = $smallText;
        } else {
            $parameterType = gettype($smallText);
            throw new Exception(
                "Parameter for Comment::setSmallText method must be 'string', '$parameterType' is given"
            );
        }
    }

    public function setText($text)
    {
        if (is_string($text)) {
            $this->_text = $text;
        } else {
            $parameterType = gettype($text);
            throw new Exception("Parameter for Text::setText method must be 'string', '$parameterType' is given");
        }
    }

    public function setPostedDate($postedDate)
    {
        if (is_string($postedDate)) {
            $this->_postedDate = $postedDate;
        } else {
            $parameterType = gettype($postedDate);
            throw new Exception(
                "Parameter for Comment::setPostedDate method must be 'string', '$parameterType' is given"
            );
        }
    }

    public function setAmountOfComments($amountOfComments)
    {
        if (is_string($amountOfComments) || is_int($amountOfComments) || is_float($amountOfComments)) {
            $this->_amountOfComments = $amountOfComments;
        } else {
            $parameterType = gettype($amountOfComments);
            throw new Exception(
                "Parameter for Post::setAmountOfComments method must be 'string' || 'int' || 'float', '$parameterType' is given"
            );
        }
    }
}