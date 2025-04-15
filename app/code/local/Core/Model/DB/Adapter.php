<?php
class Core_Model_DB_Adapter
{
    protected $_config = [
        'hostname' => 'localhost',
        'dbname' => "catalog_mvc",
        'username' => "root",
        "password" => ""
    ];
    public  $connect = null;
    public function connect()
    {
        if ($this->connect == null) {
            $this->connect = mysqli_connect(
                $this->_config['hostname'],
                $this->_config['username'],
                $this->_config['password'],
                $this->_config['dbname']
            );
        }
        return $this->connect;
    }

    public function fetchAll($query)
    {
        // print($query);
        
        $result = mysqli_query($this->connect(), $query);
        $data=[];
        while ($row = $result->fetch_assoc()) 
        {
            // print("the row is :");
            // print_r($row);
            
            $data[] = $row;
        }
        return $data;
    }
    public function fetchRow($query) {
        $result = mysqli_query($this->connect(), $query);
        while ($row = $result->fetch_assoc()) 
        {
            return $row;
        }
       
    }
    // public function fetchCol($query)
    // {
    //     // print($query);
        
    //     $result = mysqli_query($this->connect(), $query);
    //     $data=[];
    //     while ($row = $result->fetch_column()) 
    //     {
    //         // print("the row is :");
    //         // print_r($row);
            
    //         $data[] = $row;
    //     }
    //     return $data;
    // }

    public function fetchCol($query)
{
    $result = mysqli_query($this->connect(), $query);
    $data = [];
    while ($row = mysqli_fetch_row($result)) {
        $data[] = $row[0]; // Only fetch the first column value
    }
    return $data;
}

   


    public function insert($query) {
        $result = mysqli_query($this->connect(), $query);
        while ($result) 
        {
            return mysqli_insert_id($this->connect());
        }
        return false;
    }

    public function query($query) {
        $result = mysqli_query($this->connect(), $query);
        return $result;
    }
}
