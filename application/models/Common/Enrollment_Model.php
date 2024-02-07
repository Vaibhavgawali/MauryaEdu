<?php

class Enrollment_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - Enrollment details

    /*  Get Enrollment Info from ID  */
    function getEnrollmentDetailsById($enrollment_master_id){
        $result = $this->db->query("SELECT * FROM enrollment_master WHERE enrollment_master_id = '".$enrollment_master_id."'")->row_array();

        return $result;
    }

    /*  Get All Enrollment Info from Student ID  */
    function getEnrollmentDetailsByStudentId($student_id){
        $result = $this->db->query("SELECT * FROM enrollment_master WHERE student_id = $student_id")->result_array();

        return $result;
    }

    /*  Get All Valid Enrollment Info from Student ID  */
    function getValidEnrollmentDetailsByStudentId($student_id){
        $today = date('Y-m-d H:i:s');

        $sql = "SELECT enrollment_master.*,course_master.*,course_category_master.* 
        FROM enrollment_master 
        LEFT JOIN course_master ON enrollment_master.course_master_id = course_master.course_master_id
        LEFT JOIN course_category_master ON course_master.course_category_id = course_category_master.course_category_id
        WHERE enrollment_master.student_id = $student_id AND enrollment_master.valid_upto >= '".$today."' ";

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    /*  Get All Enrollment Info from course category id  */
    function getEnrollmentDetailsByCourseCategoryId($course_category_id){
        
        $sql = "SELECT DISTINCT(student_master.student_id)
        FROM student_master 
        LEFT JOIN enrollment_master ON student_master.student_id = enrollment_master.student_id
        LEFT JOIN course_master ON enrollment_master.course_master_id = course_master.course_master_id 
        WHERE course_master.course_category_id IN(".$course_category_id.")";

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    /*  Delete Contacts Info by ID  */
    function deleteEnrollmentById($enrollment_id){
        $result = $this->db->query("Delete FROM enrollment_master WHERE enrollment_master_id = $enrollment_id");
        return $result;
    }

    /*  Update Enrollment Info from ID  */
    // function updateEnrollmentDetailsById($enrollment_master_id){
    //     $result = $this->db->query("SELECT * FROM enrollment_master WHERE enrollment_master_id = $enrollment_master_id")->row_array();

    //     return $result;
    // }

}