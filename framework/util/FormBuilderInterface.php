<?php
/**
 * File /framework/util/FormBuilderInterface.php contains
 * FormBuilderInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Util;

use Framework\Exception\FormBuilderException;
use Framework\Exception\ValidatorException;

/**
 * Interface FormBuilderInterface is used to be implemented by FormBuilder class.
 *
 * @api
 *
 * @package Framework\Util
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface FormBuilderInterface
{
    /**
     * Method to get FormBuilder::_formData.
     *
     * @return array FormBuilder::_formData.
     */
    public static function getFormData();

    /**
     * Method to set FormBuilder::_formData.
     *
     * @param  array $formData Value for FormBuilder::_formData.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return void
     */
    public static function setFormData($formData);

    /**
     * Method to get name of current form.
     *
     * @return string|null Name of current form.
     */
    public function getCurrentForm();

    /**
     * Method to start building form. It takes form name and array of attributes for 'form' tag.
     *
     * @param  string $name Form name.
     * @param  array $attrs Attributes for 'form' tag.
     *
     * @throws FormBuilderException FormBuilderException instance.
     * @throws ValidatorException   ValidatorException   instance.
     *
     * @return object FormBuilder.
     */
    public function createForm($name, $attrs);

    /**
     * Method to close form putting '</form>' tag for current form.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return object FormBuilder.
     */
    public function closeForm();

    /**
     * Method to choose form to work with.
     *
     * @param  string $name Name of form to choose.
     *
     * @throws FormBuilderException FormBuilderException instance.
     * @throws ValidatorException   ValidatorException   instance.
     *
     * @return object FormBuilder.
     */
    public function chooseForm($name);

    /**
     * Method to remove current form.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return object FormBuilder.
     */
    public function removeForm();

    /**
     * Method to get all forms created by current FormBuilder object.
     *
     * @return array Array of forms.
     */
    public function getAllForms();

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
    public function getForm($echo);

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
    public static function cleanAttributes($attrs);

    /**
     * Method to add 'input' field to current form.
     *
     * @param  array $attrs Attributes of 'input' tag: 'attrName' => attrValue.
     * @param  string|null $label Label for 'input' field.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return object FormBuilder.
     */
    public function input($attrs, $label);

    /**
     * Method to add 'select' element to current form.
     *
     * @param  array $options Array of 'option' elements and its attributes: 'optionText' => option attributes.
     * @param  array $attrs Attributes of 'select' element: 'attrName' => attrValue.
     * @param  string|null $label Label for 'select' element.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return object FormBuilder.
     */
    public function select($options, $attrs, $label);

    /**
     * Method to add 'textarea' element to current form.
     *
     * @param  array $attrs Attributes for 'textarea' element: 'attrName' => attrValue.
     * @param  string|null $label Label for 'textarea' element.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return object FormBuilder.
     */
    public function textarea($attrs, $label);

    /**
     * Method to add 'fieldset' element to current form.
     *
     * @param  string|null $legend Legend for 'fieldset' element.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return object FormBuilder.
     */
    public function fieldset($legend);

    /**
     * Method to close 'fieldset' element of current form.
     *
     * @throws FormBuilderException FormBuilderException instance.
     *
     * @return object FormBuilder.
     */
    public function endFieldset();
}