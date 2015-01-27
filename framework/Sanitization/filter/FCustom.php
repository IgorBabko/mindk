<?php
/**
 * File framework/sanitization/filter/FCustom.php contains FCustom filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FCustom filter class is used to sanitize value according to callback function.
 * Callback function defines algorithm for sanitization.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FCustom extends Filter
{
    /**
     * @var string $_callback Function name for sanitization
     */
    private $_callback;

    /**
     * FCustom constructor which takes name of the function that will sanitize value.
     *
     * @param  string $callback Name of function for sanitization.
     *
     * @return FCustom FCustom object.
     */
    public function __construct($callback)
    {
        $this->_callback = $callback;
    }

    /**
     * Method to get name of callback function.
     *
     * @return string Name of callback function.
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * Method to set callback function.
     *
     * @param  string $callback Name of callback function.
     *
     * @throws FilterException FilterException instance.
     *
     * @return void
     */
    public function setCallback($callback)
    {
        if (is_string($callback)) {
            $this->_callback = $callback;
        } else {
            $parameterType = gettype($callback);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FCustom::setCallback method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to make sanitization according to callback function.
     *
     * @param  mixed $value Value to sanitize.
     *
     * @return mixed Filtered value.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (isset($value) && is_string($this->_callback)) {
            if (function_exists($this->_callback)) {
                return filter_var($value, FILTER_CALLBACK, array('options' => $this->_callback));
            } else {
                throw new FilterException(
                    500,
                    "<strong>Internal server error:</strong> callback function '{$this->_callback}' does not exist"
                );
            }
        } elseif (!isset($value)) {
            throw new FilterException(
                500,
                "<strong>Internal server error:</strong> parameter for FCustom::sanitize is NULL"
            );
        } else {
            throw new FilterException(
                500,
                "<strong>Internal server error:</strong> callback function has not been specified"
            );
        }
    }
}