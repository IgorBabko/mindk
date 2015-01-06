<?php
/**
 * File /framework/database/ActiveRecord.php contains ActiveRecord class
 * to represent data models.
 *
 * PHP version 5
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Database;

use Framework\Exception\ActiveRecordException;
use Framework\Validation\Constraint\Constraint;
use Framework\Sanitization\Filter\Filter;

/**
 * Class ActiveRecord is used to represent and work with data models.
 * Default implementation of {@link ActiveRecordInterface}.
 *
 * Class represents tables from database and its objects represent records from tables.
 *
 * Usage:
 *
 * SomeModel extends ActiveRecord;
 * $m = new SomeModel(__CLASS__);
 *
 *     - $m->load(array('field1' => 'value1', 'field2' => 'value2')) -
 *       loads record where 'field1' = 'value1' and 'field2' = 'value2' to ActiveRecord object;
 *     - $m->save() - insert data currently held in ActiveRecord object to the table;
 *     - $m->save(array('field1' => 'value1')) - update table record where 'field1' = 'value1';
 *     - $m->delete() - delete record from table represented by ActiveRecord object.
 *
 * @package Framework\Database
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ActiveRecord implements ActiveRecordInterface
{
    /**
     * @var string $_tableName Name of table which records (represented by objects of this class)
     *                         belong to
     */
    protected $_tableName;

    /**
     * @var string $_modelName Name of particular model
     */
    protected $_modelName;

    /**
     * @var array $_constraints validation constraints
     */
    protected $_constraints;

    /**
     * @var array $_filters sanitization filters
     */
    protected $_filters;

    /**
     * {@inheritdoc}
     */
    public static function query($rawQuery, $params)
    {
        if (is_string($rawQuery) && is_array($params)) {
            return Application::$dbConnection->safeQuery($rawQuery, $params);
        } else {
            throw new ActiveRecordException(
                "001",
                "Wrong parameters for ActiveRecord::query method, must be string and array."
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __set($field, $value)
    {
        $this->$field = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function __get($field)
    {
        return $this->$field;
    }

    /**
     * Constructor takes model name ( NameModel ) as a parameter
     * then by getting rid word "Model" and making first letter small in model name
     * it defines table name which current model represents.
     * Also it assigns validation constraints and sanitization filters
     * for current model if such has been passed.
     *
     * @param  string $modelName   Model name.
     * @param  array  $constraints validation constraints.
     * @param  array  $filters     sanitization filters.
     *
     * @return ActiveRecord ActiveRecord object.
     */
    public function __construct($modelName = null, $constraints = null, $filters = null)
    {
        $this->_constraints = isset($constraints) ? $constraints : array();
        $this->_filters     = isset($filters)     ? $filters     : array();

        if (is_string($modelName)) {
            $this->_modelName = $modelName;
            $this->_tableName = strtolower(preg_replace("/Model/", '', $modelName));
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getTable()
    {
        return $this->_tableName;
    }

    /**
     * {@inheritdoc}
     */
    public function setTable($tableName)
    {
        if (is_string($tableName)) {
            $this->_tableName = $tableName;
            return $this;
        } else {
            $parameterType = gettype($tableName);
            throw new ActiveRecordException(
                "001", "Parameter for ActiveRecord::setTable method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getModel()
    {
        return $this->_modelName;
    }

    /**
     * {@inheritdoc}
     */
    public function setModel($modelName)
    {
        if (is_string($modelName)) {
            $this->_modelName = $modelName;
            return $this;
        } else {
            $parameterType = gettype($modelName);
            throw new ActiveRecordException(
                "001", "Parameter for ActiveRecord::setModel method must be 'string', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function load($fields = array())
    {
        Application::$queryBuilder->createRawQuery('select');
        Application::$queryBuilder->select('*', $this->_tableName);
        if (!is_array($fields)) {
            throw new ActiveRecordException("001", "Wrong parameter for ActiveRecord::load method, must be an array.");
        } elseif (count($fields) > 1) {
            $fieldNames = array_keys($fields);
            $firstField = array($fieldNames[0] => $fields[$fieldNames[0]]);
            array_shift($fields);
            foreach ($firstField as $field => $value) {
                Application::$queryBuilder->where($field, '=', $value);
            }
            foreach ($fields as $field => $value) {
                Application::$queryBuilder->addAND($field, '=', $value);
            }
        } else {
            foreach ($fields as $field => $value) {
                Application::$queryBuilder->where($field, '=', $value);
            }
        }
        $resultSet = Application::$dbConnection->safeQuery(
            Application::$queryBuilder->getRawQuery(),
            Application::$queryBuilder->getBindParameters()
        );
        if (!empty($resultSet)) {
            $resultRow = $resultSet[0];
            if (isset($resultRow)) {
                foreach ($resultRow as $field => $value) {
                    if ($field !== 'id') {
                        $this->$field = $value;
                    }
                }
            }
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save($fields = array())
    {
        if (!is_array($fields)) {
            throw new ActiveRecordException("001", "Wrong parameter for ActiveRecord::save method, must be an array.");
        } else {
            $classInfo     = new ReflectionClass($this->_modelName);
            $newRecordData = array();
            if (empty($fields)) {
                foreach ($this as $field => $value) {
                    if ($classInfo->getProperty($field)->getDeclaringClass()->getName() !== "ActiveRecord") {
                        $newRecordData[$field] = $value;
                    }
                }
                Application::$queryBuilder->createRawQuery('insert');
                Application::$queryBuilder->insert($this->_tableName, $newRecordData);
                Application::$dbConnection->safeQuery(
                    Application::$queryBuilder->getRawQuery(),
                    Application::$queryBuilder->getBindParameters()
                );
                return $this;
            } else {
                foreach ($this as $field => $value) {
                    if ($classInfo->getProperty($field)->getDeclaringClass()->getName() !== "ActiveRecord") {
                        $newRecordData[$field] = $value;
                    }
                }
                Application::$queryBuilder->createRawQuery('update');
                Application::$queryBuilder->update($this->_tableName, $newRecordData);
                if (count($fields) > 1) {
                    $fieldNames = array_keys($fields);
                    $firstField = array($fieldNames[0] => $fields[$fieldNames[0]]);
                    array_shift($fields);
                    foreach ($firstField as $field => $value) {
                        Application::$queryBuilder->where($field, '=', $value);
                    }
                    foreach ($fields as $field => $value) {
                        Application::$queryBuilder->addAND($field, '=', $value);
                    }
                } else {
                    foreach ($fields as $field => $value) {
                        Application::$queryBuilder->where($field, '=', $value);
                    }
                }
                Application::$dbConnection->safeQuery(
                    Application::$queryBuilder->getRawQuery(),
                    Application::$queryBuilder->getBindParameters()
                );
                return $this;
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function remove()
    {
        $classInfo = new ReflectionClass($this->_modelName);
        foreach ($this as $field => $value) {
            if ($classInfo->getProperty($field)->getDeclaringClass()->getName() !== 'ActiveRecord') {
                $recordData[$field] = $value;
            }
        }
        Application::$queryBuilder->createRawQuery('delete');
        Application::$queryBuilder->delete($this->_tableName);
        $fieldNames = array_keys($recordData);
        $firstField = array($fieldNames[0] => $recordData[$fieldNames[0]]);
        array_shift($recordData);

        foreach ($firstField as $field => $value) {
            Application::$queryBuilder->where($field, '=', $value);
        }
        foreach ($recordData as $field => $value) {
            Application::$queryBuilder->addAND($field, '=', $value);
        }
        Application::$dbConnection->safeQuery(
            Application::$queryBuilder->getRawQuery(),
            Application::$queryBuilder->getBindParameters()
        );
        return $this;
    }

    /**
     * @{inheritdoc}
     */
    public function setConstraints($fieldName = null, $constraints = array())
    {
        if (is_array($constraints)) {
            if (is_string($fieldName)) {
                $this->_constraints[$fieldName] = $constraints;
            } else {
                $this->_constraints = $constraints;
            }
        } else {
            throw new ActiveRecordException(
                "003",
                "validation constraints must be given as array in form 'fieldName' => array(constraint1, constraint2, ...)"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getConstraints($fieldName = null)
    {
        if (is_string($fieldName)) {
            return $this->_constraints[$fieldName];
        } else {
            return $this->_constraints;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addConstraint($fieldName, Constraint $constraint)
    {
        if (is_string($fieldName)) {
            $this->_constraints[$fieldName][] = $constraint;
        } else {
            throw new ActiveRecordException("004", "Field name to add constraint to has not been specified");
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setFilters($fieldName = null, $filters = array())
    {
        if (is_array($filters)) {
            if (is_string($fieldName)) {
                $this->_filters[$fieldName] = $filters;
            } else {
                $this->_filters = $filters;
            }
        } else {
            throw new ActiveRecordException(
                "003",
                "sanitization filters must be given as array in form 'fieldName' => array(filter1, filter2, ...)"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFilters($fieldName = null)
    {
        if (is_string($fieldName)) {
            return $this->_filters[$fieldName];
        } else {
            return $this->_filters;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addFilter($fieldName, Filter $filter)
    {
        if (is_string($fieldName)) {
            $this->_filters[$fieldName][] = $filter;
        } else {
            throw new ActiveRecordException("004", "Field name to add filter to has not been specified");
        }
    }
}