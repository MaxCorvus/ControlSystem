<?php
namespace Db;
use PDO;

class Db
{
    public const TABLE = 'users';
    public const DB_HOST = 'localhost';
    public const DB_NAME = 'controlsystem_db';
    public const DB_USER = 'root';
    public const DB_PASSWORD = 'root';
    public $db;

    public function __construct() {
        $this->db = new PDO(
            'mysql:host=' . self::DB_HOST . ';dbname=' . self::DB_NAME,
            self::DB_USER, self::DB_PASSWORD,
            [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
    public function select($sql, $data =[], $fetchMode = PDO::FETCH_ASSOC) {
        $sth = $this->db->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindValue($key, $value);
        }
        $sth->execute($data);
        return $sth->fetchAll($fetchMode);
    }

    public function insert($data)
    {
        ksort($data);

        $fieldNames = implode('`, `', array_keys($data));
        $fieldValues = ':' . implode(', :', array_keys($data));

        $sth = $this->db->prepare("INSERT INTO " . self::TABLE .  "(`$fieldNames`) VALUES ($fieldValues)");

        foreach ($data as $key => $value) {
            $value = is_bool($value) ? ($value == true ? 1 : 0) : $value;
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();

    }
    public function delete($where)
    {
        return $this->db->exec("DELETE FROM " . self::TABLE . " WHERE $where");
    }
    public function update($data, $where)
    {
        ksort($data);

        $fieldDetails = null;
        foreach($data as $key=> $value) {
            $fieldDetails .= "`$key`=:$key,";
        }
        $fieldDetails = rtrim($fieldDetails, ',');
        $sth = $this->db->prepare("UPDATE " . self::TABLE . " SET $fieldDetails WHERE $where");

        foreach ($data as $key => $value) {
            $sth->bindValue(":$key", $value);
        }
        $sth->execute();
    }
}

