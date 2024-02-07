<?php

class Student_List_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    // count all students from list
    function countAllStudentList($where){
        $sql = "SELECT COUNT(sm.student_id) AS total FROM student_master AS sm LEFT JOIN branch_master AS bm ON bm.branch_id = sm.branch_id WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }

    // GET LIST OF ALL students from list
    function listStudentQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT sm.*, ssm.* ,bm.branch_name,bm.branch_id
            FROM student_master AS sm 
            LEFT JOIN student_status_master AS ssm ON sm.status = ssm.status_id 
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

    // count all enrollments from list
    function countAllEnrolledStudentList($where){
        $sql = "SELECT COUNT(*) AS total 
                FROM enrollment_master AS em 
                INNER JOIN student_master as sm ON sm.student_id = em.student_id
                INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id
                INNER JOIN razor_payment_master as pm ON pm.razor_payment_master_id = em.payment_master_id
                LEFT JOIN branch_master AS bm ON bm.branch_id = sm.branch_id
                WHERE $where";
        
        $result = $this->db->query($sql);
        return $result->row();
    }

    // GET LIST OF ALL Enrolled students from list
    function listEnrolledStudentQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT em.*, sm.full_name, sm.emailid, sm.contact,sm.branch_id,bm.branch_name, cm.course_name, pm.course_actual_price 
            FROM enrollment_master AS em 
            INNER JOIN student_master as sm ON sm.student_id = em.student_id
            INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id
            INNER JOIN razor_payment_master as pm ON pm.razor_payment_master_id = em.payment_master_id
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

}