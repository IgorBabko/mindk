<?php
/**
 * File /framework/validation/constraint/URL.php contains URL constraint class
 * to validate URL.
 *
 * PHP version 5
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * URL class is used to validate URL.
 *
 * @package Framework\validation\constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class URL extends Constraint
{

    /**
     * @var bool $pathRequired Is path required for URL validation?
     */
    private $pathRequired;
    /**
     * @var bool $queryRequired Is query required for URL validation?
     */
    private $queryRequired;

    /**
     * URL constructor takes $pathRequired, $queryRequired and error message.
     *
     * @param bool        $pathRequired  Is path required for URL validation?
     * @param bool        $queryRequired Is query required for URL validation?
     * @param null|string $message       Error message.
     *
     * @return URL URL object.
     */
    public function __construct($pathRequired = false, $queryRequired = false, $message = null)
    {
        $this->pathRequired = $pathRequired;
        $this->queryRequired = $queryRequired;
        $message = isset($message)?$message:"must be URL";
        parent::__construct($message);
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
            if ($this->pathRequired === true && $this->queryRequired === true) {
                if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED | FILTER_FLAG_QUERY_REQUIRED)) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($this->pathRequired === true) {
                if (filter_var($value, FILTER_VALIDATE_URL, FILTER_FLAG_PATH_REQUIRED)) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($this->queryRequired === true) {
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
                "001", "Value for URL::validate method must be 'string', '$parameterType' is given"
            );
        }
    }
}