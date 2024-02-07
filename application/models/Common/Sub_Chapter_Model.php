<?php

class Sub_Chapter_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - sub chapter details

    /*  Get sub chapter Info using status  */
    function getAllSubChapterDetailsByStatus($sub_chapter_status){
        $result = $this->db->query("SELECT * FROM sub_chapter_master WHERE sub_chapter_status = '".$sub_chapter_status."'")->result_array();

        return $result;
    }

    /*  Get sub chapter Info from name  */
    function getSubChapterDetailsByNameWithCategoryAndCourseAndChapter($course_category_id, $course_master_id, $chapter_master_id, $sub_chapter_name){
        $result = $this->db->query("SELECT * FROM sub_chapter_master WHERE  course_category_id=$course_category_id AND course_master_id=$course_master_id AND chapter_master_id=$chapter_master_id AND LOWER(sub_chapter_name) = '".strtolower($sub_chapter_name)."'")->row_array();

        return $result;
    }

    /*  Get sub chapter Info from ID  */
    function getSubChapterDetailsById($sub_chapter_master_id){
        $result = $this->db->query("SELECT * FROM sub_chapter_master WHERE sub_chapter_master_id = $sub_chapter_master_id.")->row_array();

        return $result;
    }

    // count all sub chapter from list
    function countAllSubChapterList($where){
        $sql = "SELECT COUNT(sub_chapter_master.sub_chapter_master_id) AS total 
            FROM sub_chapter_master 
            LEFT JOIN course_master ON sub_chapter_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON sub_chapter_master.course_category_id = course_category_master.course_category_id
            LEFT JOIN chapter_master ON sub_chapter_master.chapter_master_id = chapter_master.chapter_master_id 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL sub chapter from list
    function listSubChapterQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT sub_chapter_master.*, course_master.course_name, course_category_master.course_category_name, chapter_master.chapter_name 
            FROM sub_chapter_master 
            LEFT JOIN course_master ON sub_chapter_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON sub_chapter_master.course_category_id = course_category_master.course_category_id
            LEFT JOIN chapter_master ON sub_chapter_master.chapter_master_id = chapter_master.chapter_master_id 
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

    /*  Get sub chapter Info from name with other id  */
    function getSubChapterDetailsByNameWithCategoryAndCourseAndChapterForOtherId($course_category_id, $course_master_id, $chapter_master_id, $sub_chapter_master_id, $sub_chapter_name){
        $result = $this->db->query("SELECT * FROM sub_chapter_master WHERE (LOWER(sub_chapter_name) = '".strtolower($sub_chapter_name)."' AND course_category_id = $course_category_id AND course_master_id = $course_master_id AND chapter_master_id = $chapter_master_id) AND sub_chapter_master_id != ".$sub_chapter_master_id)->row_array();

        return $result;
    }

}