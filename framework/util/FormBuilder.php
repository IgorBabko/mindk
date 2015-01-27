<?php
/**
 * File /framework/util/FormBuilder.php contains FormBuilder class
 * to build html forms.
 *
 * PHP version 5
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Util;

use Framework\Exception\FormBuilderException;
use Framework\Exception\ValidatorException;
use Framework\Validation\Validator;
use Framework\Validation\Constraint\InList;
use Framework\Validation\Constraint\True;
use Framework\Validation\Constraint\URL;
use Framework\Validation\Constraint\RegExp;

/**
 * Class FormBuilder is used to build html forms.
 *
 * Usage: ??????????????????? I'll fix it later ??????????????????????????
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.bakbo@gmail.com>
 */
class FormBuilder
{
    /**
     * @static
     * @var array $_formData Values for several form attributes and its elements: 'attributeName' => array of values
     */
    private static $_formData = array(

        'method'  => array('GET', 'POST'),
        'button'  => array('button', 'reset', 'submit'),
        'target'  => array('_blank', '_self', '_parent', '_top'),
        'enctype' => array(
            'application/x-www-form-urlencoded',
            'multipart/form-data',
            'text/plain'
        ),
        'type'    => array(
            'text',
            'email',
            'color',
            'date',
            'datetime',
            'datetime-local',
            'number',
            'range',
            'search',
            'tel',
            'time',
            'url',
            'month',
            'week',
            'button',
            'fieldset',
            'legend',
            'option',
            'select',
            'textarea',
            'checkbox',
            'file',
            'hidden',
            'image',
            'password',
            'radio',
            'reset',
            'submit'
        )
    );

    /**
     * @var array $_forms Array of html forms: 'formName' => html code of form
     */
    private $_forms = array();

    /**
     * @var null|string $_currentForm Name of current form to work with
     */
    private $_currentForm = null;

    /**
     * Method to get FormBuilder::_formData.
     *
     * @return array FormBuilder::_formData.
     */
    public static function getFormData()
    {
        return self::$_formData;
    }

    /**
     * Method to set FormBuilder::_formData.
     *
     * @param  array $formData Value for FormBuilder::_formData.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return void
     */
    public static function setFormData($formData = array())
    {
        if (is_array($formData)) {
            self::$_formData = $formData;
        } else {
            $parameterType = gettype($formData);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> parameter for FormBuilder::setFormData method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to get name of current form.
     *
     * @return string|null Name of current form.
     */
    public function getCurrentForm()
    {
        return $this->_currentForm;
    }

    /**
     * Method to start building form. It takes form name and array of attributes for 'form' tag.
     *
     * @param  string $name  Form name.
     * @param  array  $attrs Attributes for 'form' tag.
     *
     * @throws FormBuilderException FormBuilderException instance.
     * @throws ValidatorException   ValidatorException   instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function createForm($name, $attrs = array())
    {
        if (!is_string($name)) {
            $parameterType = gettype($name);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> first parameter for FormBuilder::createForm method must be 'string', '$parameterType' is given"
            );
        } elseif (Validator::validateValue($name, new InList(array_keys($this->_forms)))) {
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> form with name '$name' already exists"
            );
        } else {
            if (is_array($attrs)) {
                $this->_currentForm  = $name;
                $cleanAttrs          = FormBuilder::cleanAttributes($attrs);
                $this->_forms[$name] = "<form ";
                foreach ($cleanAttrs as $attr => $val) {
                    $this->_forms[$name] .= "$attr='$val' ";
                }
                $this->_forms[$name] .= ">\n";
                return $this;
            } else {
                $parameterType = gettype($attrs);
                throw new FormBuilderException(
                    500, "<strong>Internal server error:</strong> second parameter for FormBuilder::createForm method must be 'array', '$parameterType' is given"
                );
            }
        }
    }

    /**
     * Method to close form putting '</form>' tag for current form.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function closeForm()
    {
        if (isset($this->_currentForm)) {
            $this->_forms[$this->_currentForm] .= "</form>\n";
            return $this;
        } else {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        }
    }

    /**
     * Method to choose form to work with.
     *
     * @param  string $name Name of form to choose.
     *
     * @throws FormBuilderException FormBuilderException instance.
     * @throws ValidatorException   ValidatorException   instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function chooseForm($name)
    {
        if (!is_string($name)) {
            $parameterType = gettype($name);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> parameter for FormBuilder::chooseForm method must be 'string', '$parameterType' is given"
            );
        } elseif (!Validator::validateValue($name, new InList(array_keys($this->_forms)))) {
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> form with name '$name' does not exist"
            );
        } else {
            $this->_currentForm = $name;
            return $this;
        }
    }

    /**
     * Method to remove current form.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function removeForm()
    {
        if (isset($this->_currentForm)) {
            $this->_forms[$this->_currentForm] = null;
            $this->_currentForm                = null;
            return $this;
        } else {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        }
    }

    /**
     * Method to get all forms created by current FormBuilder object.
     *
     * @return array Array of forms.
     */
    public function getAllForms()
    {
        return $this->_forms;
    }

    /**
     * Method to get current form.
     *
     * @param  bool $echo Whether echo current form or just return?
     *
     * @throws FormBuilderException FormBuilderException instance.
     * @throws ValidatorException   ValidatorException   instance.
     *
     * @return string Current form.
     */
    public function getForm($echo = false)
    {
        if (!isset($this->_currentForm)) {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        } elseif (Validator::validateValue($echo, new True())) {
            echo $this->_forms[$this->_currentForm];
        } elseif (is_bool($echo)) {
            return $this->_forms[$this->_currentForm];
        } else {
            $parameterType = gettype($echo);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> parameter for FormBuilder::getForm method must be 'bool', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to validate attributes of 'form' tag and its element tags ('input', 'select', ...).
     *
     * @param  array $attrs Attributes to validate.
     *
     * @throws FormBuilderException FormBuilderException instance.
     * @throws ValidatorException   ValidatorException   instance.
     *
     * @return array Array of valid attributes.
     */
    public static function cleanAttributes($attrs = array())
    {
        $cleanAttrs = array();
        foreach ($attrs as $attrName => $attrValue) {
            switch ($attrName) {
                case "action":
                    if (Validator::validateValue($attrValue, new URL())) {
                        $cleanAttrs[$attrName] = $attrValue;
                    } else {
                        throw new FormBuilderException(
                            500, "<strong>Internal server error:</strong> invalid URL '$attrValue' is given for '$attrName' attribute"
                        );
                    }
                    break;
                case "type":
                case "method":
                case "target":
                case "enctype":
                    $list = FormBuilder::$_formData[$attrName];
                    if (Validator::validateValue($attrValue, new InList($list))) {
                        $cleanAttrs[$attrName] = $attrValue;
                    } else {
                        throw new FormBuilderException(
                            500, "<strong>Internal server error:</strong> invalid value '$attrValue' is given for '$attrName' attribute"
                        );
                    }
                    break;
                case "id":
                case "for":
                case "form":
                    if (!Validator::validateValue($attrValue, new RegExp("/[^a-zA-Z0-9-_]+/"))) {
                        $cleanAttrs[$attrName] = $attrValue;
                    } else {
                        throw new FormBuilderException(
                            500, "<strong>Internal server error:</strong> invalid value '$attrValue' is given for '$attrName' attribute"
                        );
                    }
                    break;
                case "class":
                    if (is_array($attrValue)) {
                        $classString = '';
                        $space       = '';
                        foreach ($attrValue as $className) {
                            if (Validator::validateValue($className, new RegExp("/[^a-zA-Z0-9-_]+/"))) {
                                $classString .= $space.$className;
                                $space = " ";
                            } else {
                                throw new FormBuilderException(
                                    500, "<strong>Internal server error:</strong> invalid value '$className' is given for '$attrName' attribute"
                                );
                            }
                        }
                        $attrValue             = $classString;
                        $cleanAttrs[$attrName] = $attrValue;
                    } elseif (Validator::validateValue($attrValue, new RegExp("/[^a-zA-Z0-9-_]+/"))) {
                        $cleanAttrs[$attrName] = $attrValue;
                    } else {
                        throw new FormBuilderException(
                            500, "<strong>Internal server error:</strong> invalid value '$attrValue' is given for '$attrName' attribute"
                        );
                    }
                    break;
                case "name":
                case "value":
                case "title":
                case "label":
                case "placeholder":
                    if (isset($attrValue)) {
                        $cleanAttrs[$attrName] = $attrValue;
                    } else {
                        throw new FormBuilderException(
                            500, "<strong>Internal server error:</strong> value for '$attrName' attribute has not been specified"
                        );
                    }
                    break;
                case "checked":
                case "multiple":
                case "disabled":
                case "readonly":
                case "required":
                case "selected":
                case "autofocus":
                case "novalidate":
                    if (Validator::validateValue($attrValue, new True())) {
                        $cleanAttrs[$attrName] = true;
                    } elseif (!is_bool($attrValue)) {
                        $valueType = gettype($attrValue);
                        throw new FormBuilderException(
                            500, "<strong>Internal server error:</strong> value for '$attrName' must be 'bool', '$valueType' is given"
                        );
                    }
                    break;
                default:
                    throw new FormBuilderException(
                        500, "<strong>Internal server error:</strong> unknown attribute '$attrName'"
                    );
            }
        }
        return $cleanAttrs;
    }

    /**
     * Method to add 'input' field to current form.
     *
     * @param  array       $attrs Attributes of 'input' tag: 'attrName' => attrValue.
     * @param  string|null $label Label for 'input' field.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function input($attrs = array(), $label = null)
    {
        if (!isset($this->_currentForm)) {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        } elseif (!is_array($attrs)) {
            $parameterType = gettype($attrs);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> first parameter for FormBuilder::input method must be 'array', '$parameterType' is given"
            );
        } else {
            $cleanAttrs = FormBuilder::cleanAttributes($attrs);
            $input      = "<input ";
            foreach ($cleanAttrs as $attr => $val) {
                $input .= "$attr='$val' ";
            }
            $input .= "/>";
            $input = is_string($label)?"\t<label>$label$input</label></br>":"\t$input</br>";
            $this->_forms[$this->_currentForm] .= $input;
            return $this;
        }
    }

    /**
     * Method to add 'select' element to current form.
     *
     * @param  array       $options Array of 'option' elements and its attributes: 'optionText' => option attributes.
     * @param  array       $attrs   Attributes of 'select' element: 'attrName' => attrValue.
     * @param  string|null $label   Label for 'select' element.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function select($options, $attrs = array(), $label = null)
    {
        if (!isset($this->_currentForm)) {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        } elseif (!isset($options) || empty($options)) {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> array of options for FormBuilder::select method must not be empty"
            );
        } elseif (!is_array($attrs)) {
            $parameterType = gettype($attrs);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> second parameter for FormBuilder::select method must be 'array', '$parameterType' is given"
            );
        } else {
            $cleanAttrs       = FormBuilder::cleanAttributes($attrs);
            $cleanOptionAttrs = array();
            foreach ($options as $text => $attrs) {
                $cleanOptionAttrs[$text] = FormBuilder::cleanAttributes($attrs);
            }

            $select = "<select ";
            foreach ($cleanAttrs as $attr => $val) {
                $select .= "$attr='$val' ";
            }
            $select .= ">\n";

            foreach ($cleanOptionAttrs as $text => $attrs) {
                $option = "<option ";
                foreach ($attrs as $attr => $val) {
                    $option .= "$attr='$val' ";
                }
                $option .= ">$text</option>\n";
                $select .= $option;
            }
            $select .= "</select>\n";
            if (is_string($label) && !isset($cleanAttrs['id'])) {
                throw new FormBuilderException(
                    500,
                    "<strong>Internal server error:</strong> if label for tag 'select' is specified then 'id' attribute also must be specified"
                );
            } else {
                $select = is_string(
                    $label
                )?"<label for='{$cleanAttrs['id']}'>$label</label>$select</br>":"$select</br>";
                $this->_forms[$this->_currentForm] .= $select;
                return $this;
            }
        }
    }

    /**
     * Method to add 'textarea' element to current form.
     *
     * @param  array       $attrs Attributes for 'textarea' element: 'attrName' => attrValue.
     * @param  string|null $label Label for 'textarea' element.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function textarea($attrs = array(), $label = null)
    {
        if (!isset($this->_currentForm)) {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        } elseif (!is_array($attrs)) {
            $parameterType = gettype($attrs);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> first parameter for FormBuilder::textarea method must be 'array', '$parameterType' is given"
            );
        } else {
            $cleanAttrs = FormBuilder::cleanAttributes($attrs);
            $textarea   = "<textarea ";
            foreach ($cleanAttrs as $attr => $val) {
                $textarea .= "$attr='$val' ";
            }
            $textarea .= "></textarea>";
            if (is_string($label) && !isset($cleanAttrs['id'])) {
                throw new FormBuilderException(
                    500,
                    "<strong>Internal server error:</strong> if label for tag 'textarea' is specified then 'id' attribute also must be specified"
                );
            } else {
                $textarea = is_string(
                    $label
                )?"<label for='{$cleanAttrs['id']}'>$label</label></br>$textarea</br>":"$textarea</br>";
                $this->_forms[$this->_currentForm] .= $textarea;
                return $this;
            }
        }
    }

    /**
     * Method to add 'fieldset' element to current form.
     *
     * @param  string|null $legend Legend for 'fieldset' element.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function fieldset($legend = null)
    {
        if (!isset($this->_currentForm)) {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        } elseif (is_string($legend)) {
            $this->_forms[$this->_currentForm] .= "<fieldset>\n<legend>$legend</legend>\n";
            return $this;
        } elseif (!isset($legend)) {
            $this->_forms[$this->_currentForm] .= "<fieldset>\n";
            return $this;
        } else {
            $parameterType = gettype($legend);
            throw new FormBuilderException(
                500, "<strong>Internal server error:</strong> 'Legend' parameter for FormBuilder::fieldset method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * Method to close 'fieldset' element of current form.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return FormBuilder FormBuilder object.
     */
    public function endFieldset()
    {
        if (isset($this->_currentForm)) {
            $this->_forms[$this->_currentForm] .= "</fieldset>\n";
            return $this;
        } else {
            throw new FormBuilderException(
                500,
                "<strong>Internal server error:</strong> form has not been specified (FormBuilder::_currentForm === NULL), use FormBuilder::chooseForm method to specify form"
            );
        }
    }
}