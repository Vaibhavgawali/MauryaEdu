<?php

class Pt_Meetings_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - pt meetings details

    /*  Get pt meetings Info using status  */
    function getAllPtMeetingsDetailsByStatus($pt_meetings_status){
        $result = $this->db->query("SELECT * FROM pt_meetings_master WHERE pt_meetings_status = '".$pt_meetings_status."'")->result_array();

        return $result;
    }

    /*  Get pt meetings Info from ID  */
    function getPtMeetingsById($pt_meetings_master_id){
        $result = $this->db->query("SELECT * FROM pt_meetings_master WHERE pt_meetings_master_id = $pt_meetings_master_id.")->row_array();

        return $result;
    }

    // count all pt meetings from list
    function countAllPtMeetingsList($where){
        $sql = "SELECT COUNT(pt_meetings_master.pt_meetings_master_id) AS total 
            FROM pt_meetings_master 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL pt meetings from list
    function listPtMeetingsQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT pt_meetings_master.*
            FROM pt_meetings_master 
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
    function getPtMeetingsByCourseCategoryIdAndPtMeetingsStatus($course_category_id=NULL, $pt_meetings_status=NULL){

        $sql = "SELECT * FROM pt_meetings_master WHERE 1=1 ";

        if($course_category_id != NULL){
            $sql .= " AND course_category_id=$course_category_id ";
        }

        if($pt_meetings_status != NULL){
            $sql .= " AND pt_meetings_status='".$pt_meetings_status."'";
        }

        $result = $this->db->query($sql)->row_array();

        return $result;
    }

}