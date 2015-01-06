<?php
/**
 * File framework/sanitization/filter/FFloat.php contains FFloat filter class.
 *
 * PHP version 5
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filters;

use Framework\Exception\FilterException;

/**
 * FFloat filter class is used to filter float values given as a string.
 *
 * @package Framework\sanitization\filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FFloat extends Filter
{
    /**
     * @var bool $allowedFraction Defines whether allow fraction or not.
     */
    private $allowedFraction;

    /**
     * @var bool $allowedScientific Defines whether allow scientific (E) notation or not.
     */
    private $allowedScientific;

    /**
     * FFloat constructor takes bool values that define behavior of float sanitization.
     *
     * @param bool $allowedFraction   Defines whether allow fraction or not.
     * @param bool $allowedScientific Defines whether allow scientific (E) notation or not.
     *
     * @return FFloat FFloat object.
     */
    public function __construct($allowedFraction = true, $allowedScientific = true)
    {
        $this->allowedFraction   = ($allowedFraction === true)?true:false;
        $this->allowedScientific = ($allowedScientific === true)?true:false;
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
            if ($this->allowedFraction === true && $this->allowedScientific === true) {
                return filter_var(
                    $value,
                    FILTER_SANITIZE_NUMBER_FLOAT,
                    FILTER_FLAG_ALLOW_FRACTION | FILTER_FLAG_ALLOW_SCIENTIFIC
                );
            } elseif ($this->allowedFraction === true) {
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            } elseif ($this->allowedScientific === true) {
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_SCIENTIFIC);
            } else {
                return filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
            }
        } else {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "Value for FFloat::sanitize method must be 'string' || 'int' || 'float',
                        '$parameterType' is given"
            );
        }
    }
}