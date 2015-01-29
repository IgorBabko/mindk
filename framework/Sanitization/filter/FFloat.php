<?php
/**
 * File framework/sanitization/filter/FFloat.php contains FFloat filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FFloat filter class is used to filter float values given as a string.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FFloat extends Filter
{
    /**
     * @var bool $_allowedFraction Defines whether allow fraction or not.
     */
    private $_allowedFraction;

    /**
     * @var bool $_allowedScientific Defines whether allow scientific (E) notation or not.
     */
    private $_allowedScientific;

    /**
     * FFloat constructor takes bool values that define behavior of float sanitization.
     *
     * @param bool $allowedFraction   Defines whether allow fraction or not.
     * @param bool $allowedScientific Defines whether allow scientific (E) notation or not.
     *
     * @return object FFloat.
     */
    public function __construct($allowedFraction = true, $allowedScientific = true)
    {
        $this->_allowedFraction   = ($allowedFraction === true)?true:false;
        $this->_allowedScientific = ($allowedScientific === true)?true:false;
    }

    /**
     * Method to get FFloat::_allowedFraction.
     *
     * @return bool FFloat::_allowedFraction.
     */
    public function getAllowedFraction()
    {
        return $this->_allowedFraction;
    }

    /**
     * Method to set FFloat::_allowedFraction.
     *
     * @param  bool $allow Value for FFloat::_allowedFraction.
     *
     * @throws FilterException FilterException instance.
     *
     * @return void
     */
    public function allowFraction($allow = true)
    {
        if (is_bool($allow)) {
            $this->_allowedFraction = $allow;
        } else {
            $parameterType = gettype($allow);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FFloat::allowFraction method must be 'bool', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to get FFloat::_allowedScientific.
     *
     * @return bool FFloat::_allowedScientific.
     */
    public function getAllowedScientific()
    {
        return $this->_allowedScientific;
    }

    /**
     * Method to set FFloat::_allowedScientific.
     *
     * @param  bool $allow Value for FFloat::_allowedScientific.
     *
     * @throws FilterException FilterException instance.
     *
     * @return void
     */
    public function allowScientific($allow = true)
    {
        if (is_bool($allow)) {
            $this->_allowedScientific = $allow;
        } else {
            $parameterType = gettype($allow);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> parameter for FFloat::allowScientific method must be 'bool', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to sanitize float values.
     *
     * @param  string|float|int $value Source value.
     *
     * @return string|float|int Filtered value.
     *
     * @throws FilterException FilterException instance.
     *
     */
    public function sanitize($value)
    {
        if (is_string($value) || is_float($value) || is_int($value)) {
            if ($this->_allowedFraction === true && $this->_allowedScientific === true) {
                return filter_var(
                    $value,
                    FILTER_SANITIZE_NUMBER_FLOAT,
                    FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC
                );
            } elseif ($this->_allowedFraction === true) {
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            } elseif ($this->_allowedScientific === true) {
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_SCIENTIFIC);
            } else {
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
            }
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                500, "<strong>Internal server error:</strong> value for FFloat::sanitize method must be 'string' || 'int' || 'float',
                        '$parameterType' is given"
            );
        }
    }
}