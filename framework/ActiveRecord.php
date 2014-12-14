<?php

class ActiveRecord
{
    protected $columnCount;
    protected $id;
    protected $table;
    protected $dbo;

    public function __construct($dbo)
    {
        $this->dbo         = $dbo;
        $this->columnCount = $this->dbo->connection->query("SHOW COLUMNS FROM {$this->table}")->rowCount();
    }

    function __set($field, $value)
    {
        $this->$field = $value;
    }

    function __get($field)
    {
        return $this->$field;
    }

    public function load($filter = array())
    {
        $resultSetSQL = $this->dbo->select($filter, $this->table);
        info($resultSetSQL);
        $resultSet = $resultSetSQL->fetch(PDO::FETCH_ASSOC);

        if (isset($resultSet) && is_array($resultSet)) {
            foreach ($resultSet as $field => $value) {
                $this->$field = $value;
            }
        }
    }

    public function save()
    {
        $classInfo = new ReflectionClass('User');
        foreach ($this as $field => $value) {
            if ($classInfo->getProperty($field)->getDeclaringClass()->getName() == 'User') {
                $data[$field] = $value;
            }
        }
        //info($data);
        $this->dbo->insert($data, $this->table);
    }


    public function change($filter = null)
    {
        $classInfo = new ReflectionClass('User');
        foreach ($this as $field => $value) {
            if ($classInfo->getProperty($field)->getDeclaringClass()->getName() == 'User') {
                $data[$field] = $value;
            }
        }
        $this->dbo->update($data, $filter, $this->table);
    }


    function store()
    {
        $dbc = Database::getInstance();
        $sql = $this->buildQuery('store');
        $dbc->doQuery($sql);
    }
}

























