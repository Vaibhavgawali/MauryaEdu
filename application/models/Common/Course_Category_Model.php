<?php

class Course_Category_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - course category details

    /*  Get course category Info using status  */
        // function getAllCourseCategoryDetailsByStatus($course_category_status){
        //     $result = $this->db->query("SELECT * FROM course_category_master WHERE course_category_status = '".$course_category_status."'")->result_array();

        //     return $result;
        // }

    function getAllCourseCategoryDetailsByStatus($course_category_status,$additional_where = NULL){
        $sql = "SELECT * FROM course_category_master WHERE course_category_status = '".$course_category_status."'";

        if (!empty($additional_where)) {
            $sql .= $additional_where;
        }

        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    /*  Get course category Info from name  */
    function getCourseCategoryDetailsByName($course_category_name){
        $result = $this->db->query("SELECT * FROM course_category_master WHERE LOWER(course_category_name) = '".strtolower($course_category_name)."'")->row_array();

        return $result;
    }

    /*  Get course category Info from ID  */
    function getCourseCategoryDetailsById($course_category_id){
        $result = $this->db->query("SELECT * FROM course_category_master WHERE course_category_id = '".$course_category_id."'")->row_array();

        return $result;
    }

    /*  Get course category Info from multiple ID  */
    function getCourseCategoryDetailsByMultipleId($course_category_id){
        $result = $this->db->query("SELECT * FROM course_category_master WHERE course_category_id IN($course_category_id)")->result_array();

        return $result;
    }

    // count all course category from list
    function countAllCourseCategoryList($where){
        $sql = "SELECT COUNT(course_category_id) AS total FROM course_category_master AS sm LEFT JOIN branch_master AS bm ON bm.branch_id = sm.branch_id WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL course category from list
    function listCourseCategoryQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT sm.* ,bm.branch_name
            FROM course_category_master AS sm
            LEFT JOIN branch_master AS bm ON bm.branch_id = sm.branch_id
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

    /*  Get course category Info from name with other id  */
    function getCourseCategoryDetailsByNameWithOtherId($course_category_name, $course_category_id){
        $result = $this->db->query("SELECT * FROM course_category_master WHERE LOWER(course_category_name) = '".strtolower($course_category_name)."' AND course_category_id != ".$course_category_id)->row_array();

        return $result;
    }

}