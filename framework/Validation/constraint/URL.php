<?php
/**
 * File /framework/validation/constraint/URL.php contains URL constraint class
 * to validate URL.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * URL class is used to validate URL.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class URL extends Constraint
{
    /**
     * @var bool $_pathRequired Is path required for URL validation?
     */
    private $_pathRequired;

    /**
     * @var bool $_queryRequired Is query required for URL validation?
     */
    private $_queryRequired;

    /**
     * URL constructor takes $pathRequired, $queryRequired and error message.
     *
     * @param bool $pathRequired Is path required for URL validation?
     * @param bool $queryRequired Is query required for URL validation?
     * @param null|string $message Error message.
     *
     * @return object URL.
     */
    public function __construct($pathRequired = false, $queryRequired = false, $message = null)
    {
        $this->_pathRequired = $pathRequired;
        $this->_queryRequired = $queryRequired;
        $message = isset($message) ? $message : "must be URL";
        parent::__construct($message);
    }

    /**
     * Method to get URL::_pathRequired.
     *
     * @return bool  URL::_pathRequired.
     */
    public function getPathRequired()
    {
        return $this->_pathRequired;
    }

    /**
     * Method to set URL::_pathRequired.
     *
     * @param  bool $pathRequired Value for URL::_pathRequired.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function pathRequired($pathRequired = true)
    {
        if (is_bool($pathRequired)) {
            $this->_pathRequired = $pathRequired;
        } else {
            $parameterType = gettype($pathRequired);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for URL::pathRequired method must be 'bool', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to get URL::_queryRequired.
     *
     * @return bool  URL::_queryRequired.
     */
    public function getQueryRequired()
    {
        return $this->_queryRequired;
    }

    /**
     * Method to set URL::_queryRequired.
     *
     * @param  bool $queryRequired Value for URL::_queryRequired.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function queryRequired($queryRequired = true)
    {
        if (is_bool($queryRequired)) {
            $this->_queryRequired = $queryRequired;
        } else {
            $parameterType = gettype($queryRequired);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for URL::queryRequired method must be 'bool', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to validate URL.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is URL or not?
     */
    public function validate($value)
    {
        if (is_string($value)) {
            if ($this->_pathRequired === true && $this->_queryRequired === true) {
                if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED | FILTER_FLAG_QUERY_REQUIRED)) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($this->_pathRequired === true) {
                if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($this->_queryRequired === true) {
                if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_QUERY_REQUIRED)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (filter_var($value, FILTER_VALIDATE_URL)) {
                    return true;
                } else {
                    return false;
                }
            }
        } else {
            $parameterType = gettype($value);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for URL::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}