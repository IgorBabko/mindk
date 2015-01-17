<?php
/**
 * File /framework/validation/constraint/InList.php contains InList constraint class
 * to check whether current value exists within specified list.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * InList class is used to check whether current value exists within specified list.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class InList extends Constraint
{
    /**
     * @var array $_list List of allowed values
     */
    private $_list;

    /**
     * InList constructor takes list of allowed values and error message.
     *
     * @param  array        $list    List of allowed values.
     * @param  null|string  $message Error message.
     *
     * @return InList InList object.
     */
    public function __construct($list = array(), $message = null)
    {
        $this->_list = $list;
        $message     = isset($message)?$message:"must be from specified list";
        parent::__construct($message);
    }

    /**
     * Method to get list.
     *
     * @return array List.
     */
    public function getList()
    {
        return $this->_list;
    }

    /**
     * Method to set list.
     *
     * @param  array $list List to set.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setList($list = array())
    {
        if (is_array($list)) {
            $this->_list = $list;
        } else {
            $parameterType = gettype($list);
            throw new ConstraintException(
                "001", "Parameter for InList::setList method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to check whether current value exists within specified list.
     *
     * @param  mixed $value Value to check.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Does value exist in list or not?
     */
    public function validate($value)
    {
        if (isset($value)) {
            if (in_array($value, $this->_list, true)) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ConstraintException("001", "Value for InList::validate method is NULL");
        }
    }
}