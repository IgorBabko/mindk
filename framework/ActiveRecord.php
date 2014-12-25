<?php
/**
 * File /Framework/ActiveRecord.php contains ActiveRecord class
 * to represent data models.
 *
 * PHP version 5
 *
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework;

use Framework\Application;
use Framework\Exception\ActiveRecordException;

/**
 * Class ActiveRecord is used to represent and work with data models.
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
 * @package Framework
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
class ActiveRecord
{
    /**
     * @var string $tableName Name of table which records (represented by objects of this class)
     *                        belong to
     */
    protected $tableName;

    /**
     * @var string $modelName Name of particular model
     */
    protected $modelName;

    /**
     * Method to make query to database.
     *
     * @param string $rawQuery Raw query string (with placeholders).
     * @param string $params   Parameters to replace placeholders in $rawQuery.
     *
     * @throws ActiveRecordException ActiveRecordException instance.
     * @return int|array Result set from database or count of affected rows depending on query type.
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
     * Magic setter.
     *
     * @param $field Field name to set new value to.
     * @param $value New value to assign to $field.
     *
     * @return void
     */
    function __set($field, $value)
    {
        $this->$field = $value;
    }

    /**
     * Magic getter.
     *
     * @param $field Field name to get value from.
     *
     * @return mixed
     */
    function __get($field)
    {
        return $this->$field;
    }

    /**
     * Constructor takes model name ( NameModel ) as a parameter
     * then by getting rid word "Model" and making first letter small in model name
     * it defines table name which current model represents.
     *
     * @param $modelName
     *
     * @return ActiveRecord ActiveRecord instance.
     */
    public function __construct($modelName)
    {
        $this->modelName = $modelName;
        $this->tableName = strtolower(preg_replace("/Model/", '', $modelName));
    }

    /**
     * Method loads data from particular record of table ActiveRecord::tableName
     * to ActiveRecord object depending on $fields array which stands for condition
     * what record must be loaded.
     *
     * @param array $fields (Fields => Values) array for query condition to specify record to load.
     *
     * @return \Framework\ActiveRecord ActiveRecord object.
     * @throws ActiveRecordException ActiveRecordException instance.
     */
    public function load($fields = array())
    {
        Application::$queryBuilder->createRawQuery('select');
        Application::$queryBuilder->select('*', $this->tableName);
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
     * Method to insert data currently held in ActiveRecord object
     * to ActiveRecord::tableName table or update existing record.
     * $fields array is     empty => insert data.
     * $fields array is not empty => update data.
     *
     * @param array $fields Array to specify the record which is needed to update.
     *
     * @return \Framework\ActiveRecord ActiveRecord object.
     * @throws ActiveRecordException   ActiveRecord instance.
     */
    public function save($fields = array())
    {
        if (!is_array($fields)) {
            throw new ActiveRecordException("001", "Wrong parameter for ActiveRecord::save method, must be an array.");
        } else {
            $classInfo     = new ReflectionClass($this->modelName);
            $newRecordData = array();
            if (empty($fields)) {
                foreach ($this as $field => $value) {
                    if ($classInfo->getProperty($field)->getDeclaringClass()->getName() !== "ActiveRecord") {
                        $newRecordData[$field] = $value;
                    }
                }
                Application::$queryBuilder->createRawQuery('insert');
                Application::$queryBuilder->insert($this->tableName, $newRecordData);
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
                Application::$queryBuilder->update($this->tableName, $newRecordData);
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
     * Method to remove record from ActiveRecord::tableName table
     * represented by current ActiveRecord object.
     *
     * @return \Framework\ActiveRecord ActiveRecord object.
     */
    public function remove()
    {
        $classInfo = new ReflectionClass($this->modelName);
        foreach ($this as $field => $value) {
            if ($classInfo->getProperty($field)->getDeclaringClass()->getName() !== 'ActiveRecord') {
                $recordData[$field] = $value;
            }
        }
        Application::$queryBuilder->createRawQuery('delete');
        Application::$queryBuilder->delete($this->tableName);
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
}