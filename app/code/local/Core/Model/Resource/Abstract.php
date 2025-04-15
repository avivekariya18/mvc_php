<?php
class Core_Model_Resource_Abstract
{
    protected $_tableName = "";
    protected $_primaryKey = "";

    public function __construct()
    {
        $this->_construct();
    }

    public function _construct()
    {
        //print_r($this);
        return $this;
    }
    public function init($tableName, $primaryKey)
    {
        $this->_tableName = $tableName;
        $this->_primaryKey = $primaryKey;
    }

    public function getTableName()
    {
        return $this->_tableName;
    }

    public function getAdapter()
    {
        return new Core_Model_DB_Adapter();
    }

    public function load($value, $field = null)
    {
        if (is_null($field)) {
            $field = $this->_primaryKey;
        } else {
            $field = $field;
        }
        $sql = "SELECT * FROM `{$this->_tableName}` WHERE {$field} = '$value' LIMIT 1";
        // print($sql);

        return $this->getAdapter()->fetchRow($sql);
    }

    

    public function save($model)
    {
        //print("in save ");
        $dbColumns = $this->_getDbColumns();
        //print_r($dbColumns);

        $data = $model->getData();
        // print_r($data);

        //     $fileKeys = array_keys($_FILES[$this->_tableName]['name']); 
        //    // $type = str_replace("catlog_", "", $this->_tablename); 
        //     $fileKey = $fileKeys[0];

        //     if (isset($_FILES[$this->_tableName]["name"][$fileKey]) && $_FILES[$this->_tableName]["error"][$fileKey] == 0) {
        //         $target_dir = "media/product/";
        //         $target_file = $target_dir . basename($_FILES[$this->_tableName]["name"][$fileKey]);

        //         // Move the uploaded file to the target directory
        //         if (move_uploaded_file($_FILES[$this->_tableName]["tmp_name"][$fileKey], $target_file)) {
        //             echo "File uploaded successfully!";
        //             echo "<br><img src='" . $target_file . "' alt='Uploaded Image' style='max-width: 200px;'>";

        //             // Add the image path to $data before inserting/updating
        //             $data[$fileKey] = $target_file;
        //         } else {
        //             echo "File upload failed!";
        //         }
        //     }

        // print_r($data);

        $primaryId = 0;
        if (isset($data[$this->_primaryKey]) &&  $data[$this->_primaryKey]) {
            $primaryId = $data[$this->_primaryKey];
        }

        if ($primaryId) {
            // $sql ="UPDATE {$this->_tablename} SET ";
            // echo "this is:" .$primaryId;
            // die();
            $columns = [];
            unset($data[$this->_primaryKey]);

            // print_r($data);

            foreach ($data as $key => $value) {
                if (in_array($key, $dbColumns)) {
                    $value = ($value != null) ? $value : "";
                    $columns[] = sprintf("`{$key}` = '%s'", addslashes($value));
                }
            }


            $columns = implode(",", $columns);
            $sql = sprintf(
                "UPDATE `%s` SET %s WHERE %s = %d",
                $this->_tableName,
                $columns,
                $this->_primaryKey,
                $primaryId
            );

            //   echo $sql;

            $this->getAdapter()->query($sql);
        } else {
            // echo "Insert";
            //  echo "<pre>";
            $values = [];
            $columns = [];
            //unset($data[$this->_primarykey]);
            //  print_r($data);
            foreach ($data as $key => $value) {
                if (in_array($key, $dbColumns)) {
                    $values[] = ($value != null) ? $value : "";
                    $columns[] = sprintf("%s", addslashes($key));
                }
            }
            $columns = "(" . implode(",", $columns) . ")";
            $values = implode("','", $values);
            $sql = sprintf(
                "INSERT INTO `%s` %s VALUES ('%s')",
                $this->_tableName,
                $columns,
                $values
            );
            //  echo $sql;
            $id = $this->getAdapter()->insert($sql);
            // print_r($id);
            // print("the id is ".$id);


            $model->{$this->_primaryKey} = $id;
            return $id;
        }

        // echo get_class($model);
    }

    protected function _getDbColumns()
    {
        $sql = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = N'{$this->_tableName}'";
        // print($sql);
        $adapter = $this->getAdapter()->fetchCol($sql);
        return $adapter;
    }


    public function delete($model)
    {

        $data = $model->getData();
        // $img = $data['image'];

        $primaryId = 0;
        if (isset($data[$this->_primaryKey]) && $data[$this->_primaryKey]) {
            $primaryId = $data[$this->_primaryKey];
        }

        if ($primaryId) {

            $sql = sprintf(
                "DELETE FROM %s WHERE %s = %d",
                $this->_tableName,
                $this->_primaryKey,
                $data[$this->_primaryKey]
            );

            // unlink($img);
            print($sql);
            if ($this->getAdapter()->query($sql)) {
                $model->setData(null);
            }
        }
    }
}
