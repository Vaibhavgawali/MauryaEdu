<?php

class Test_Records_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - test records details

    /*  Get test records Info using status  */
    function getAllTestRecordsDetailsByStatus($test_records_status){
        $result = $this->db->query("SELECT * FROM test_records_master WHERE test_records_status = '".$test_records_status."'")->result_array();

        return $result;
    }

    /*  Get test records Info from ID  */
    function getTestRecordsById($test_records_master_id){
        $result = $this->db->query("SELECT * FROM test_records_master WHERE test_records_master_id = $test_records_master_id")->row_array();

        return $result;
    }

    // count all test records from list
    function countAllTestRecordsList($where){
        $sql = "SELECT COUNT(test_records_master.test_records_master_id) AS total 
            FROM test_records_master 
            LEFT JOIN student_master ON test_records_master.student_id = student_master.student_id
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL test records from list
    function listTestRecordsQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT test_records_master.*, student_master.* 
            FROM test_records_master 
            LEFT JOIN student_master ON test_records_master.student_id = student_master.student_id 
            WHERE $where 
            ORDER BY $order_by $order_dir LIMIT $start, $length";
        
        $result = $this->db->query($sql)->result_array();
        $result_total = $this->db->query($sql)->num_rows();
        $array = array(
            "Result" => $result,
            "Result_total_filter" => $result_total,
        );
        return $array;
    }

    /*  Get test records Info from student id & test rec status  */
    function getTestRecordsByStudentIdAndTestRecordsStatus($student_id=NULL, $test_records_status=NULL){

        $sql = "SELECT * FROM test_records_master WHERE 1=1 ";

        if($student_id != NULL){
            $sql .= " AND student_id=$student_id ";
        }

        if($test_records_status != NULL){
            $sql .= " AND test_records_status='".$test_records_status."'";
        }

        $result = $this->db->query($sql)->row_array();

        return $result;
    }

}