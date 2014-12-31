<?php
/**
 * File /framework/Validation/Constraints/IP.php contains IP constraint class
 * to validate an IP address.
 *
 * PHP version 5
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Validation\Constraints;

use Framework\Exception\ConstraintException;

/**
 * IP class is used to validate an IP address.
 *
 * @package Framework\Validation\Constraints
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class IP extends Constraint
{

    /**
     * @var string $ipType Type of IP
     */
    private $ipType;

    /**
     * IP constructor takes type of IP and error message.
     *
     * @param string        $ipType  Type of IP.
     * @param null|string   $message Error message.
     *
     * @return IP IP object.
     */
    public function __construct($ipType, $message = null)
    {
        $this->ipType = empty($ipType)?'both':$ipType;
        $message      = isset($message)?$message:"must be $ipType IP-address";
        parent::__construct($message);
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
        $this->ipType = strtolower($this->ipType);
        $ipTypes      = array('both', 'ipv4', 'ipv6');

        if (!is_string($value)) {
            $parameterType = gettype($value);
            throw new ConstraintException(
                "001", "Value for IP::validate method must be 'string', '$parameterType' is given"
            );
        } elseif (in_array($this->ipType, $ipTypes, true) !== true) {
            throw new ConstraintException("002", "Unknown type of IP");
        } else {
            if ($this->ipType === 'ipv4') {
                if (filter_var($value, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4)) {
                    return true;
                } else {
                    return false;
                }
            } elseif ($this->ipType === 'ipv6') {
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