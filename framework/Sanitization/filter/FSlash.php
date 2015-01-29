<?php
/**
 * File /framework/sanitization/filter/FSlash.php contains FSlash filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FSlash filter class is used to strip or add slashes to source string.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FSlash extends Filter
{
    /**
     * @var string $_action Defines whether 'strip' or 'add' slashes to source string
     */
    private $_action;

    /**
     * FSlash constructor takes action name ('strip', 'add') to define filter behavior.
     *
     * @param  string $action Defines whether 'strip' or 'add' slashes to source string.
     *
     * @return object FSlash.
     */
    public function __construct($action = 'add')
    {
        $this->_action = ($action === 'add')?'add':'strip';
    }

    /**
     * Method to get action.
     *
     * @return array Action.
     */
    public function getAction()
    {
        return $this->_action;
    }

    /**
     * Method to set action.
     *
     * @param  string $action Action.
     *
     * @throws FilterException FilterException instance.
     *
     * @return void
     */
    public function setAction($action)
    {
        if ($action === 'add' || $action === 'strip') {
            $this->_action = $action;
        } else {
            throw new FilterException(
                500,
                "<strong>Internal server error:</strong> parameter value for PSlash::setAction method must be 'add' || 'strip'"
            );
        }
    }

    /**
     * Method to strip or add slashes to source string.
     *
     * @param  string $value Source string.
     *
     * @throws FilterException FilterException instance.
     *
     * @return string Filtered string.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            if ($this->_action === 'add') {
                return addslashes($value);
            } else {
                return stripslashes($value);
            }
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FSlash::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}