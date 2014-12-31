<?php
/**
 * File framework/Sanitization/Filters/FSlash.php contains FSlash filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FSlash filter class is used to strip or add slashes to source string.
 *
 * @package Framework\Sanitization\Filters
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FSlash extends Filter
{

    /**
     * @var string $action Defines whether 'strip' or 'add' slashes to source string
     */
    private $action;

    /**
     * FSlash constructor takes action name ('strip', 'add') to define filter behavior.
     *
     * @param  string $action Defines whether 'strip' or 'add' slashes to source string.
     *
     * @return FSlash FSlash object.
     */
    public function __construct($action = 'add')
    {
        $this->action = ($action === 'add')?'add':'strip';
    }

    /**
     * Method to strip or add slashes to source string.
     *
     * @param  string $value Source string.
     *
     * @return string Filtered string.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (is_string($value)) {
            if ($this->action === 'add') {
                return addslashes($value);
            } else {
                return stripslashes($value);
            }
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Parameter for FSlash::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        }
    }
}