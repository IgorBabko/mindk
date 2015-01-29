<?php
/**
 * File /framework/model/FormInterface.php contains FormInterface interface.
 *
 * PHP version 5
 *
 * @package Framework\models
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Model;

/**
 * Interface FormInterface is used to be implemented by Form class.
 *
 * @api
 *
 * @package Framework\models
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
interface FormInterface
{
    /**
     * Method to set model (ActiveRecord) to current Form object.
     *
     * @param  ActiveRecord $model models that current Form object will represent.
     *
     * @throws \Framework\Exception\FormException FormException instance.
     *
     * @return object Form.
     */
    public function setModel(ActiveRecord $model);

    /**
     * Method to get model that current Form object represents.
     *
     * @return object|null ActiveRecord.
     */
    public function getModel();

    /**
     * Method to get object of data that has come from form.
     *
     * @return object|null Object of data.
     */
    public function getData();

    /**
     * Method to get validation constraints of current form.
     *
     * @return array|null Validation constraints.
     */
    public function getConstraints();

    /**
     * Method to set validation constraints for current form.
     *
     * @param  array $constraints Validation constraints to set.
     *
     * @throws \Framework\Exception\FormException FormException instance.
     *
     * @return object Form.
     */
    public function setConstraints($constraints);

    /**
     * Method to check whether current for is valid or not.
     *
     * @throws \Framework\Exception\FormException FormException instance.
     *
     * @return bool Is current for valid or not?
     */
    public function isValid();

    /**
     * Method to bind data come from form to model that current form represents.
     *
     * @throws \Framework\Exception\FormException FormException instance.
     *
     * @return object Form.
     */
    public function bindDataToModel();

    /**
     * Method to set html code for current form.
     *
     * @param  string $view Html code of current form.
     *
     * @throws \Framework\Exception\FormException FormException instance.
     *
     * @return object Form.
     */
    public function setView($view);

    /**
     * Method to get html code of current form.
     *
     * @return string Html code of current form.
     */
    public function getView();
}