<?php
/**
 * File /framework/model/Form.php contains Form class
 * to represent all data come from forms as objects (form models).
 *
 * PHP version 5
 *
 * @package Framework\models
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Model;

use Framework\Exception\FormException;
use Framework\Validation\Validator;

/**
 * Class Form is used to represent all data come from forms as objects (form models).
 * Default implementation of {@link FormInterface}.
 *
 * @package Framework\models
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class Form implements FormInterface
{
    /**
     * @var object|null $_model models that current form object represents
     */
    private $_model = null;

    /**
     * @var array|null $_constraints Array of validation constraints for current form
     *                               (the same as model constraints that current form object represents)
     */
    private $_constraints = null;

    /**
     * @var object|null $_data Object of data that has come from form
     */
    private $_data = null;

    /**
     * @var bool $_valid Defines whether current form is valid or not
     */
    private $_valid = false;

    /**
     * @var string $_view Html code of current form
     */
    private $_view = '';

    /**
     * Form constructor takes model (ActiveRecord) that current Form object will represent.
     *
     * @param  ActiveRecord|null $model Model that current Form object will represent.
     * @param  string|null $context Context for form validation.
     *
     * @return object Form.
     */
    public function __construct(ActiveRecord $model = null, $context = null)
    {
        $this->_model = $model;
        $this->_constraints = $model->getConstraints($context);
    }

    /**
     * {@inheritdoc}
     */
    public function setModel(ActiveRecord $model)
    {
        if (is_object($model)) {
            $this->_model = $model;
            $this->_constraints = $model->getConstraints();
            return $this;
        } else {
            $parameterType = gettype($model);
            throw new FormException(
                500, "<strong>Internal server error:</strong> parameter for Form::setModel method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraints()
    {
        return $this->_constraints;
    }

    /**
     * {@inheritdoc}
     */
    public function setConstraints($constraints)
    {
        if (is_array($constraints)) {
            $this->_constraints = $constraints;
            return $this;
        } else {
            $parameterType = gettype($constraints);
            throw new FormException(
                500, "<strong>Internal server error:</strong> parameter for Form::setRules method must be 'array', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function isValid()
    {
        if (isset($this->_model)) {
            $this->_data = (object)$_POST;
            $this->_valid = Validator::validate($this);
            return ($this->_valid === true) ? true : false;
        } else {
            throw new FormException(500, "<strong>Internal server error:</strong> model for the form has not been set");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function bindDataToModel()
    {
        if (!isset($this->_model)) {
            throw new FormException(500, "<strong>Internal server error:</strong> model for the form has not been set");
        } elseif ($this->_valid !== true) {
            throw new FormException(
                500,
                "<strong>Internal server error:</strong> to bind form data to the model form must be valid"
            );
        } else {
            foreach ($this->_data as $field => $value) {
                if (property_exists($this->_model, $field)) {
                    $this->_model->$field = $value;
                }
            }
            return $this;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setView($view)
    {
        if (is_string($view)) {
            $this->_view = $view;
            return $this;
        } else {
            $parameterType = gettype($view);
            throw new FormException(
                500, "<strong>Internal server error:</strong> parameter for Form::setView method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getView()
    {
        return $this->_view;
    }
}