<?php
namespace Repository;
class DbConnection {
    private  $db;
    public $results;
    public function __construct()
    {
        $this->db = mysqli_connect('localhost', 'root',
            'root', 'simpleblog_db');
    }
    public function query(string $sql){
       $this->results = mysqli_query($this->db, $sql);
       return $this;
    }
    public function loadObjectList()
    {
        $obj = [];

        foreach ($this->results as $value)
        {
            $obj[] = $value;

        }
        return $obj;
    }
    public function loadObject() {

        if ($this->results) {
            return mysqli_fetch_assoc($this->results);
        }
    }


}



