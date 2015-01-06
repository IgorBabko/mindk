<?php
/**
 * File /framework/validation/constraint/InList.php contains InList constraint class
 * to check whether current value exists within specified list.
 *
 * PHP version 5
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * InList class is used to check whether current value exists within specified list.
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class InList extends Constraint
{

    /**
     * @var array $list List of allowed values
     */
    private $list;

    /**
     * InList constructor takes list of allowed values and error message.
     *
     * @param array        $list    List of allowed values.
     * @param null|string  $message Error message.
     *
     * @return InList InList object.
     */
    public function __construct($list = array(), $message = null)
    {
        $this->list = $list;
        $message    = isset($message)?$message:"must be from specified list";
        parent::__construct($message);
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
            if (in_array($value, $this->list, true)) {
                return true;
            } else {
                return false;
            }
        } else {
            throw new ConstraintException("001", "Value for InList::validate method is NULL");
        }
    }
}