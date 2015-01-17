<?php
/**
 * File /framework/model/ActiveRecord.php contains ActiveRecord class
 * to represent data models.
 *
 * PHP version 5
 *
 * @package Framework\Model
 * @author  Igor Babko <i.i.babko@gmail.com>
 */

namespace Framework\Model;

use Framework\Database\SafeSQL;
use Framework\Exception\ActiveRecordException;
use Framework\Util\QueryBuilder;

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
 *     - $m->load(array('column1' => 'value1', 'column2' => 'value2')) -
 *       loads record where 'column1' = 'value1' and 'column2' = 'value2' to ActiveRecord object;
 *     - $m->save() - insert data currently held in ActiveRecord object to the table;
 *     - $m->save(array('column1' => 'value1')) - update table record where 'column1' = 'value1';
 *     - $m->delete() - delete record from table represented by ActiveRecord object.
 *
 * @package Framework\Model
 * @author  Igor Babko <i.i.babko@gmail.com>
 */
abstract class ActiveRecord implements ActiveRecordInterface
{
    /**
     * @var SafeSql $_dbConnection SafeSql object to work with database safely
     */
    private static $_dbConnection;

    /**
     * @var QueryBuilder $_safeSql QueryBuilder object to create sql queries
     */
    private static $_queryBuilder;

    /**
     * {@inheritdoc}
     */
    public static function getDbConnection()
    {
        return self::$_dbConnection;
    }

    /**
     * {@inheritdoc}
     */
    public static function getQueryBuilder()
    {
        return self::$_queryBuilder;
    }

    /**
     * {@inheritdoc}
     */
    public static function setDbConnection($dbConnection)
    {
        if (is_object($dbConnection)) {
            self::$_dbConnection = $dbConnection;
        } else {
            $parameterType = gettype($dbConnection);
            throw new ActiveRecordException(
                "001", "Parameter for ActiveRecord::setDbConnection method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function setQueryBuilder($queryBuilder)
    {
        if (is_object($queryBuilder)) {
            self::$_queryBuilder = $queryBuilder;
        } else {
            $parameterType = gettype($queryBuilder);
            throw new ActiveRecordException(
                "001", "Parameter for ActiveRecord::setQueryBuilder method must be 'object', '$parameterType' is given"
            );
        }
    }

    /**
     * {@inheritdoc}
     */
    public static function query($rawQuery, $params)
    {
        if (is_string($rawQuery) && is_array($params)) {
            return self::$_dbConnection->safeQuery($rawQuery, $params);
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
    public function __set($fieldName, $value)
    {
        $this->$fieldName = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function __get($fieldName)
    {
        return $this->$fieldName;
    }

    /**
     * {@inheritdoc}
     */
    public static function getTable()
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public static function getColumns()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function load($columns = array())
    {
        self::$_queryBuilder->createRawQuery('select');
        self::$_queryBuilder->select('*', static::getTable());
        if (!is_array($columns)) {
            $parameterType = gettype($columns);
            throw new ActiveRecordException(
                "001", "Parameter for ActiveRecord::load method must be 'array', '$parameterType' is given"
            );
        } elseif (count($columns) > 1) {
            $columnNames = array_keys($columns);
            $firstColumn = array($columnNames[0] => $columns[$columnNames[0]]);
            array_shift($columns);
            foreach ($firstColumn as $columnName => $value) {
                self::$_queryBuilder->where($columnName, '=', $value);
            }
            foreach ($columns as $columnName => $value) {
                self::$_queryBuilder->addAND($columnName, '=', $value);
            }
        } else {
            foreach ($columns as $columnName => $value) {
                self::$_queryBuilder->where($columnName, '=', $value);
            }
        }
        $resultSet = self::$_dbConnection->safeQuery(
            self::$_queryBuilder->getRawQuery(),
            self::$_queryBuilder->getBindParameters()
        );
        if (!empty($resultSet)) {
            $resultRow = $resultSet[0];
            if (isset($resultRow)) {
                $columnNames = static::getColumns();
                foreach ($resultRow as $columnName => $value) {
                    $fieldName        = array_search($columnName, $columnNames);
                    $this->$fieldName = $value;
                }
            }
        }
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function save($columns = array())
    {
        $model = get_class($this);
        if (!is_array($columns)) {
            throw new ActiveRecordException("001", "Wrong parameter for ActiveRecord::save method, must be an array.");
        } else {
            $classInfo     = new \ReflectionClass($model);
            $newRecordData = array();
            $columnNames   = static::getColumns();
            if (empty($columns)) {
                foreach ($this as $fieldName => $value) {
                    echo $fieldName.'<br />';
                    if ($classInfo->getProperty($fieldName)->getDeclaringClass()->getName() !== "ActiveRecord") {
                        $columnName                 = $columnNames[$fieldName];
                        $newRecordData[$columnName] = $value;
                    }
                }
                self::$_queryBuilder->createRawQuery('insert');
                self::$_queryBuilder->insert(static::getTable()/*$this->_tableName*/, $newRecordData);
                self::$_dbConnection->safeQuery(
                    self::$_queryBuilder->getRawQuery(),
                    self::$_queryBuilder->getBindParameters()
                );
                return $this;
            } else {
                foreach ($this as $fieldName => $value) {
                    if ($classInfo->getProperty($fieldName)->getDeclaringClass()->getName() !== "ActiveRecord") {
                        $columnName                 = $columnNames[$fieldName];
                        $newRecordData[$columnName] = $value;
                    }
                }
                self::$_queryBuilder->createRawQuery('update');
                self::$_queryBuilder->update(static::getTable(), $newRecordData);
                if (count($columns) > 1) {
                    $columnNames = array_keys($columns);
                    $firstColumn = array($columnNames[0] => $columns[$columnNames[0]]);
                    array_shift($columns);
                    foreach ($firstColumn as $columnName => $value) {
                        self::$_queryBuilder->where($columnName, '=', $value);
                    }
                    foreach ($columns as $columnName => $value) {
                        self::$_queryBuilder->addAND($columnName, '=', $value);
                    }
                } else {
                    foreach ($columns as $columnName => $value) {
                        self::$_queryBuilder->where($columnName, '=', $value);
                    }
                }
                self::$_dbConnection->safeQuery(
                    self::$_queryBuilder->getRawQuery(),
                    self::$_queryBuilder->getBindParameters()
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
        $model      = get_class($this);
        $classInfo  = new \ReflectionClass($model);
        $recordData = array();
        foreach ($this as $field => $value) {
            if ($classInfo->getProperty($field)->getDeclaringClass()->getName() !== 'ActiveRecord') {
                $recordData[$field] = $value;
            }
        }
        self::$_queryBuilder->createRawQuery('delete');
        self::$_queryBuilder->delete(static::getTable());
        $fieldNames = array_keys($recordData);
        $firstField = array($fieldNames[0] => $recordData[$fieldNames[0]]);
        array_shift($recordData);

        $columnNames = static::getColumns();
        foreach ($firstField as $field => $value) {
            self::$_queryBuilder->where($columnNames[$field], '=', $value);
        }
        foreach ($recordData as $field => $value) {
            self::$_queryBuilder->addAND($columnNames[$field], '=', $value);
        }
        self::$_dbConnection->safeQuery(
            self::$_queryBuilder->getRawQuery(),
            self::$_queryBuilder->getBindParameters()
        );
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public static function getConstraints($context = null)
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public static function getFilters()
    {
        return array();
    }
}