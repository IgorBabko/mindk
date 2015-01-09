<?php
/**
 * File /framework/security/XssDefender.php contains XssDefender class.
 *
 * PHP version 5
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Security;

use Framework\Exception\XssDefenderException;

/**
 * XssDefender class is used to prevent XSS attacks.
 * Default implementation of {@link XssDefenderInterface}.
 *
 * Class contains different methods to prevent XSS attacks
 * depending on context where input data is supposed to be inserted.
 *
 * $input - data come from insecure sources.
 *
 * Context list:
 *     html)      used when input can be inserted into html code:
 *                e.g. "<span>" . $input . "</span>";
 *                e.g. "<div>"  . $input . "</div>".
 *     script)    used when input can be inserted into script:
 *                e.g. "<script> var v = " . $input . "; </script>".
 *
 *     attribute) used when input can be inserted for attribute value:
 *                e.g. "<div class='" . $input . "'>attribute context</div>".
 *
 *     style)     used when input can be inserted into style attribute or style tag:
 *                e.g. "<span style='" . $input . "'></span>";
 *                e.g. "<style>"       . $input . "</style".
 *
 *     url)       used when input can be inserted into href or src attributes
 *                (only allows URLs that start with http(s) or ftp):
 *                e.g. "<a      href='" . $input . "'>click</a>";
 *                e.g. "<img    src='"  . $input . "'>";
 *                e.g. "<iframe src='"  . $input . "'>".
 *
 * @package Framework\security
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class XssDefender implements XssDefenderInterface
{
    /**
     * @var array $_specialCharacters Characters which must be replaced
     *                               depending on context
     */
    private static $_specialCharacters = array(
        'html' => array(
            '<' => '&lt;',
            '>' => '&gt;'
        ),
        'attribute' => array(
            '"' => '&quot;',
            "'" => '&apos;',
            '`' => '&grave;'
        ),
        'style' => array(
            '"'  => '&quot;',
            "'"  => '&apos;',
            '`'  => '&grave;',
            '('  => '&lpar;',
            '\\' => '&bsol;',
            '<'  => '&lt;',
            '&'  => '&amp;'

        ),
        'script'    => array(
            '"'  => '&quot;',
            '<'  => '&lt;',
            "'"  => '&apos;',
            '\\' => '&bsol;',
            '%'  => '&percnt;',
            '&'  => '&amp;'
        )
    );

    /**
     * {@inheritdoc}
     */
    public static function getSpecialCharacters()
    {
        return self::$_specialCharacters;
    }

    /**
     * {@inheritdoc}
     */
    public static function setSpecialCharacters($specialCharacters = array())
    {
        if (is_array($specialCharacters)) {
            self::$_specialCharacters = $specialCharacters;
        } else {
            $parameterType = gettype($specialCharacters);
            throw new XssDefenderException(
                "001", "Parameter for XssDefender::setSpecialCharacters method must be 'array', '$parameterType' is given'"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function cleanHtml($input)
    {
        $replace   = array_keys(self::$_specialCharacters['html']);
        $with      = array_values(self::$_specialCharacters['html']);
        $safeInput = str_replace($replace, $with, $input);

        return stripslashes($safeInput);
    }

    /**
     * {@inheritdoc}
     */
    public static function cleanScript($input)
    {
        $replace   = array_keys(self::$_specialCharacters['script']);
        $with      = array_values(self::$_specialCharacters['script']);
        $safeInput = str_replace($replace, $with, $input);

        return stripslashes($safeInput);
    }

    /**
     * {@inheritdoc}
     */
    public static function cleanAttribute($input)
    {
        $replace   = array_keys(self::$_specialCharacters['attribute']);
        $with      = array_values(self::$_specialCharacters['attribute']);
        $safeInput = str_replace($replace, $with, $input);

        return stripslashes($safeInput);
    }

    /**
     * {@inheritdoc}
     */
    public static function cleanStyle($input)
    {
        $replace   = array_keys(self::$_specialCharacters['style']);
        $with      = array_values(self::$_specialCharacters['style']);
        $safeInput = str_replace($replace, $with, $input);

        return stripslashes($safeInput);
    }

    /**
     * {@inheritdoc}
     */
    public static function cleanUrl($input)
    {
        if (preg_match("#^(?:(?:https?|ftp):{1})\/\/[^\"\s\\\\]*.[^\"\s\\\\]*$#iu", (string)$input, $match)) {
            return $match[0];
        } else {
            $safeInput = 'javascript:void(0)';
            return $safeInput;
        }
    }
}