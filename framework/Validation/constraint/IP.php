<?php
/**
 * File /framework/validation/constraint/IP.php contains IP constraint class
 * to validate an IP address.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraint;

use Framework\Exception\ConstraintException;

/**
 * IP class is used to validate an IP address.
 *
 * @package Framework\Validation\Constraint
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class IP extends Constraint
{
    /**
     * @var string $_ipType Type of IP
     */
    private $_ipType;

    /**
     * IP constructor takes type of IP and error message.
     *
     * @param  string      $ipType  Type of IP.
     * @param  null|string $message Error message.
     *
     * @return IP IP object.
     */
    public function __construct($ipType, $message = null)
    {
        $this->_ipType = empty($ipType)?'both':$ipType;
        $message       = isset($message)?$message:"must be $ipType IP-address";
        parent::__construct($message);
    }

    /**
     * Method to get type of IP.
     *
     * @return string Type of IP.
     */
    public function getIpType()
    {
        return $this->_ipType;
    }

    /**
     * Method to set type of IP.
     *
     * @param  string $ipType Type of IP to set.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return void
     */
    public function setIpType($ipType)
    {
        $ipTypes = array('both', 'ipv4', 'ipv6');
        if (in_array($ipType, $ipTypes, true)) {
            $this->_ipType = $ipType;
        } else {
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> unknown type of ip '$ipType'"
            );
        }
    }

    /**
     * Method to validate an IP address.
     *
     * @param  mixed $value Value to validate.
     *
     * @throws ConstraintException ConstraintException instance.
     *
     * @return bool Is Ip address valid or not?
     */
    public function validate($value)
    {
        $this->_ipType = strtolower($this->_ipType);
        $ipTypes       = array('both', 'ipv4', 'ipv6');

        if (!is_string($value)) {
            $parameterType = gettype($value);
            throw new ConstraintException(
                500, "<strong>Internal server error:</strong> value for IP::validate method must be 'string', '$parameterType' is given"
            );
        } elseif (in_array($this->_ipType, $ipTypes, true) !== true) {
            throw new ConstraintException(
                500,
                "<strong>Internal server error:</strong> unknown type of IP '{$this->_ipType}'"
            );
        } else {
            if ($this->_ipType === 'ipv4') {
                if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($this->_ipType === 'ipv6') {
                if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                if (filter_var($value, FILTER_VALIDATE_IP)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}