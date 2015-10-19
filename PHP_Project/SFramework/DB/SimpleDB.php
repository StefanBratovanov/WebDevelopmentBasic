<?php

namespace SF\DB;

use SF\App;

class SimpleDB
{
    protected $connection = 'default';
    private $db = null;
    /**
     * @var \PDOStatement
     */
    private $stmt = null;
    private $params = array();
    private $sql;


    public function __construct($connection = null)
    {
        if ($connection instanceof \PDO) {
            $this->db = $connection;

        } else if ($connection != null) {
            $this->db = App::getInstance()->getDBConnection($connection);
            $this->connection = $connection;

        } else {
            $this->db = App::getInstance()->getDbConnection($this->connection);
        }
    }


    /**
     * @param $sql
     * @param array $params
     * @param array $pdoOptions
     * @return $this
     */
    public function prepare($sql, $params = array(), $pdoOptions = array())
    {
        $this->stmt = $this->db->prepare($sql, $pdoOptions);
        $this->params = $params;
        $this->sql = $sql;

        //can make chain commands
        return $this;
    }

    /**
     * @param array $params
     * @return $this
     */
    public function execute($params = array())
    {
        if ($params) {
            $this->params = $params;
        }

        $this->stmt->execute($this->params);

        return $this;
    }


    public function fetchAllAssoc()
    {
        return $this->stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function fetchRowAssoc()
    {
        return $this->stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function fetchAllNum()
    {
        return $this->stmt->fetchAll(\PDO::FETCH_NUM);
    }

    public function fetchRowNum()
    {
        return $this->stmt->fetch(\PDO::FETCH_NUM);
    }

    public function fetchAllObj()
    {
        return $this->stmt->fetchAll(\PDO::FETCH_OBJ);
    }

    public function fetchRowObj()
    {
        return $this->stmt->fetch(\PDO::FETCH_OBJ);
    }

    public function fetchAllClass($class)
    {
        return $this->stmt->fetchAll(\PDO::FETCH_CLASS, $class);
    }

    public function fetchRowClass($class)
    {
        return $this->stmt->fetch(\PDO::FETCH_CLASS, $class);
    }

    public function getLastInsertId()
    {
        return $this->db->lastInsertId();
    }

    public function getAffectRows()
    {
        return $this->stmt->rowCount();
    }

    public function getStatement()
    {
        return $this->stmt;
    }

}