<?php

class Course_Videos_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - course video details

    /*  Get course video Info using status  */
    function getAllCourseVideosDetailsByStatus($video_status){
        $result = $this->db->query("SELECT * FROM course_video_master WHERE video_status = '".$video_status."'")->result_array();

        return $result;
    }

    /*  Get course video Info from ID  */
    function getCourseVideosDetailsById($course_video_master_id){
        $result = $this->db->query("SELECT * FROM course_video_master WHERE course_video_master_id = $course_video_master_id.")->row_array();

        return $result;
    }

    // count all course video from list
    function countAllCourseVideosList($where){
        $sql = "SELECT COUNT(course_video_master.course_video_master_id) AS total 
            FROM course_video_master 
            LEFT JOIN course_master ON course_video_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON course_video_master.course_category_id = course_category_master.course_category_id 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL course video from list
    function listCourseVideosQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT course_video_master.*, course_master.course_name, course_category_master.course_category_name, course_category_master.course_category_info 
            FROM course_video_master 
            LEFT JOIN course_master ON course_video_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON course_video_master.course_category_id = course_category_master.course_category_id 
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

}