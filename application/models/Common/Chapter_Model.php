<?php

class Chapter_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - chapter details

    /*  Get chapter Info using status  */
    function getAllChapterDetailsByStatus($chapter_status){
        $result = $this->db->query("SELECT * FROM chapter_master WHERE chapter_status = '".$chapter_status."'")->result_array();

        return $result;
    }

    /*  Get chapter Info from name  */
    function getChapterDetailsByNameWithCategoryAndCourse($course_category_id, $course_master_id, $chapter_name){
        $result = $this->db->query("SELECT * FROM chapter_master WHERE  course_category_id=$course_category_id AND course_master_id=$course_master_id AND LOWER(chapter_name) = '".strtolower($chapter_name)."'")->row_array();

        return $result;
    }

    /*  Get chapter Info from ID  */
    function getChapterDetailsById($chapter_master_id){
        $result = $this->db->query("SELECT * FROM chapter_master WHERE chapter_master_id = $chapter_master_id.")->row_array();

        return $result;
    }

    // count all chapter from list
    function countAllChapterList($where){
        $sql = "SELECT COUNT(chapter_master.chapter_master_id) AS total 
            FROM chapter_master 
            LEFT JOIN course_master ON chapter_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON course_master.course_category_id = course_category_master.course_category_id 
            LEFT JOIN branch_master ON branch_master.branch_id = chapter_master.branch_id 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL chapter from list
    function listChapterQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT chapter_master.*, course_master.course_name, course_category_master.course_category_name, course_category_master.course_category_info,branch_master.branch_name  
            FROM chapter_master 
            LEFT JOIN course_master ON chapter_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON course_master.course_category_id = course_category_master.course_category_id 
            LEFT JOIN branch_master ON branch_master.branch_id = chapter_master.branch_id
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

    /*  Get chapter Info from name with other id  */
    function getChapterDetailsByNameWithCategoryAndCourseForOtherId($course_category_id, $course_master_id, $chapter_master_id, $chapter_name){
        $result = $this->db->query("SELECT * FROM chapter_master WHERE (LOWER(chapter_name) = '".strtolower($chapter_name)."' AND course_category_id = $course_category_id AND course_master_id = $course_master_id) AND chapter_master_id != ".$chapter_master_id)->row_array();

        return $result;
    }

    /*  Get chapter list using course  */
    function getChapterDetailsByCourseId($course_master_id){
        $result = $this->db->query("SELECT * FROM chapter_master WHERE course_master_id = '".$course_master_id."'")->result_array();

        return $result;
    }

}