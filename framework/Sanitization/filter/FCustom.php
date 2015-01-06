<?php
/**
 * File framework/sanitization/filter/FCustom.php contains FCustom filter class.
 *
 * PHP version 5
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FCustom filter class is used to sanitize value according to callback function.
 * Callback function defines algorithm for sanitization.
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class FCustom extends Filter
{

    /**
     * @var string $callback Function name for sanitization
     */
    private $callback;

    /**
     * FCustom constructor which takes name of the function that will sanitize value.
     *
     * @param  string $callback Name of function for sanitization.
     *
     * @return FCustom FCustom object.
     */
    public function __construct($callback)
    {
        $this->callback = $callback;
    }

    /**
     * Method to make sanitization according to callback function.
     *
     * @param mixed $value Value to sanitize.
     *
     * @return mixed Filtered value.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        if (isset($value) && is_string($this->callback)) {
            if (function_exists($this->callback)) {
                return filter_var($value, FILTER_CALLBACK, array('options' => $this->callback));
            } else {
                throw new FilterException("005", "Callback function '{$this->callback}' does not exist");
            }
        } elseif (!isset($value)) {
            throw new FilterException("006", "Parameter for FCustom::sanitize is NULL");
        } else {
            throw new FilterException("007", "Callback function has not been specified");
        }
    }
}