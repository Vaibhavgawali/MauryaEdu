<?php
class Common_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    
    /*  Get table content  */
    function getTableContent($table_name,$where=NULL){
        $result = $this->db->query("SELECT * FROM $table_name $where")->result_array();

        return $result;
    }
    
    /*  Get table next auto increment value  */
    function getNextAutoIncrementValue($db_name,$table_name){
        $result = $this->db->query("SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '".$db_name."' AND TABLE_NAME = '".$table_name."'")->row_array();

        return $result['AUTO_INCREMENT'];
    }

    /*  Get data from table  */
    function getDataFromTable($table_name = null, $where = null) {
        if ($where != null) {
            $this->db->where($where);
        }
        return $result = $this->db
                ->from($table_name)
                ->get()
                ->result_array();
    }

    /*  Insert data into table  */
    function insertIntoTable($table_name, $data) {
        foreach ($data as $i => $value) {
            if ($value === "") $data[$i] = NULL;
        }

        if ($this->db->insert($table_name, $data)) {
            return $this->db->insert_id();
        } else {
            return 0;
        }
    }

    /*  Update table  */
    function updateTable($table, $data, $where) {

        foreach ($data as $i => $value) {
            if ($value === "") $data[$i] = NULL;
        }

        $this->db->where($where);
        $this->db->set($data);

        if ($this->db->update($table)) {
            return true;
        } else {
            return false;
        }
    }

}//end of class

?>