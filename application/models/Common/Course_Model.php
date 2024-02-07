<?php

class Course_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - course details

    /*  Get course Info using status  */
    function getAllCourseDetailsByStatus($course_status){
        $result = $this->db->query("SELECT * FROM course_master WHERE course_status = '".$course_status."'")->result_array();

        return $result;
    }

    /*  Get course Info from name  */
    function getCourseDetailsByNameAndCategory($course_name, $course_category_id){
        $result = $this->db->query("SELECT * FROM course_master WHERE LOWER(course_name) = '".strtolower($course_name)."' AND course_category_id=".$course_category_id)->row_array();

        return $result;
    }

    /*  Get course Info from ID  */
    function getCourseDetailsById($course_master_id){
        $result = $this->db->query("SELECT * FROM course_master WHERE course_master_id = '".$course_master_id."'")->row_array();

        return $result;
    }

    // count all course from list
    function countAllCourseList($where){
        $sql = "SELECT COUNT(cm.course_master_id) AS total 
            FROM course_master AS cm 
            LEFT JOIN course_category_master AS ccm ON cm.course_category_id = ccm.course_category_id 
            LEFT JOIN branch_master AS bm ON bm.branch_id = cm.branch_id 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }

    // GET LIST OF ALL course from list
    function listCourseQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT cm.*, ccm.course_category_name, ccm.course_category_info ,bm.branch_name
            FROM course_master AS cm 
            LEFT JOIN course_category_master AS ccm ON cm.course_category_id = ccm.course_category_id 
            LEFT JOIN branch_master AS bm ON bm.branch_id = cm.branch_id 
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

    /*  Get course Info from name with other id  */
    function getCourseDetailsByNameAndCategoryForOtherId($course_name, $course_category_id, $course_master_id){
        $result = $this->db->query("SELECT * FROM course_master WHERE (LOWER(course_name) = '".strtolower($course_name)."' AND course_category_id = $course_category_id) AND course_master_id != ".$course_master_id)->row_array();

        return $result;
    }

    /*  Get course list using category  */
    function getCourseDetailsByCategoryId($course_category_id){
        $result = $this->db->query("SELECT * FROM course_master WHERE course_category_id = '".$course_category_id."'")->result_array();

        return $result;
    }

    /*  Get course , chapter and documents Info with Course id  */
    function getCourseAndChapterAndDocumentsDetailsByCourseId($course_master_id){

        $sql = "SELECT course_master.course_image,chapter_document_master.*
                FROM course_master 
                LEFT JOIN chapter_master ON course_master.course_master_id = chapter_master.course_master_id 
                LEFT JOIN chapter_document_master ON chapter_document_master.chapter_master_id = chapter_master.chapter_master_id 
                LEFT JOIN course_video_master ON chapter_document_master.course_master_id = course_video_master.course_master_id 
                WHERE course_master.course_master_id = '".$course_master_id."'";
        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    /*  Delete course , chapter and documents Info with Course id  */
    function deleteCourseAndChapterAndDocumentsDetailsByCourseId($course_master_id){

        $sql = "DELETE course_master.*,chapter_document_master.*, chapter_master.*,course_video_master.*
                FROM course_master 
                LEFT JOIN chapter_master ON course_master.course_master_id = chapter_master.course_master_id 
                LEFT JOIN chapter_document_master ON chapter_document_master.chapter_master_id = chapter_master.chapter_master_id 
                LEFT JOIN course_video_master ON chapter_document_master.course_master_id = course_video_master.course_master_id 
                WHERE course_master.course_master_id = '".$course_master_id."'";
                
        $result = $this->db->query($sql);

        return $result;
    }
}