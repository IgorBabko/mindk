<?php
/**
 * File /framework/sanitization/filter/FIP.php contains FIP filter class.
 *
 * PHP version 5
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Sanitization\Filter;

use Framework\Exception\FilterException;

/**
 * FIP filter class is used to sanitize ip address.
 * User can specify which type of ip ('IPV4', 'IPV6') must be filtered.
 * Type by default is 'both' which signs that both types of ip are allowed.
 *
 * @package Framework\Sanitization\Filter
 * @author  Igor Babko <i.i.babko@gmail.comm>
 */
class FIP extends Filter
{
    /**
     * @var string $_type Type of ip.
     */
    private $_type;

    /**
     * FIP constructor takes type of ip.
     *
     * @param  string $type Type of ip.
     *
     * @return FIP FIP object.
     */
    public function __construct($type = 'ipv4')
    {
        $this->_type = strtolower($type);
    }

    /**
     * Method to get type of IP.
     *
     * @return string Type of IP.
     */
    public function getType()
    {
        return $this->_type;
    }


    /**
     * Method to set type of IP.
     *
     * @param  string $type Type of IP to set.
     *
     * @throws FilterException FilterException instance.
     *
     * @return void
     */
    public function setType($type)
    {
        $type    = strtolower($type);
        $ipTypes = array('both', 'ipv4', 'ipv6');
        if (in_array($type, $ipTypes, true)) {
            $this->_type = $type;
        } else {
            throw new FilterException("001", "Value for FIP::setType method must be 'both' || 'ipv4' || 'ipv6'");
        }
    }

    /**
     * Method to sanitize ip.
     *
     * @param  string $value Source string.
     *
     * @return string Filtered string.
     *
     * @throws FilterException FilterException instance.
     */
    public function sanitize($value)
    {
        $ipTypes = array('both', 'ipv4', 'ipv6');

        if (!is_string($value)) {
            $parameterType = gettype($value);
            throw new FilterException(
                "001", "First parameter for FIP::sanitize method must be 'string',
                        '$parameterType' is given"
            );
        } elseif (in_array($this->_type, $ipTypes, true) !== true) {
            throw new FilterException(
                "002", "Second parameter for FIP::sanitize method must be equal to 'both' || 'ipv4' || 'ipv6',
                        '$this->_type' is given"
            );
        } else {
            if ($this->_type === 'ipv4') {
                return preg_replace("/[^\\d\\.]|\\.{2,}/", "", $value);
            } else {
                return preg_replace("/[^\\da-fA-F\\.:]|\\.{2,}|:{3,}/", "", $value);
            }
        }
    }
}