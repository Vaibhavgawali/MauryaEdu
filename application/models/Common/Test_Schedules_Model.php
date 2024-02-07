<?php

class Test_Schedules_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - test Schedules details

    /*  Get test Schedules Info using status  */
    function getAllTestSchedulesDetailsByStatus($test_schedule_status){
        $result = $this->db->query("SELECT * FROM test_schedule_master WHERE test_schedule_status = '".$test_schedule_status."'")->result_array();

        return $result;
    }

    /*  Get test Schedules Info from ID  */
    function getTestSchedulesById($test_schedule_master_id){
        $result = $this->db->query("SELECT * FROM test_schedule_master WHERE test_schedule_master_id = $test_schedule_master_id.")->row_array();

        return $result;
    }

    // count all test Schedules from list
    function countAllTestSchedulesList($where){
        $sql = "SELECT COUNT(test_schedule_master.test_schedule_master_id) AS total 
            FROM test_schedule_master 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL test Schedules from list
    function listTestSchedulesQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT test_schedule_master.*
            FROM test_schedule_master 
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
    function getTestSchedulesByCourseCategoryIdAndTestSchedulesStatus($course_category_id=NULL, $test_schedule_status=NULL){

        $sql = "SELECT * FROM test_schedule_master WHERE 1=1 ";

        if($course_category_id != NULL){
            $sql .= " AND course_category_id=$course_category_id ";
        }

        if($test_schedule_status != NULL){
            $sql .= " AND test_schedule_status='".$test_schedule_status."'";
        }

        $result = $this->db->query($sql)->row_array();

        return $result;
    }

}