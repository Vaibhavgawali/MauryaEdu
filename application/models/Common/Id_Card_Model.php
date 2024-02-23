<?php

class Id_Card_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*  Get Enrollment Info from ID  */
    function getIdCardDetailsById($id_card_master_id){
        $result = $this->db->query("SELECT * FROM id_card_master WHERE id_card_master_id = '".$id_card_master_id."'")->row_array();

        return $result;
    }


    function getIdCardsByStudentId($student_id){
        $result = $this->db->query("SELECT icm.*,em.*
                FROM enrollment_master em
                JOIN id_card_master icm ON em.id_card_master_id = icm.id_card_master_id
                WHERE em.student_id = '".$student_id."'")->row_array();

        return $result;
    }

    /* Get all id card by student id */
    public function loadIdCards($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT em.*, icm.* ,cm.*
                FROM enrollment_master as em
                INNER JOIN id_card_master icm ON em.id_card_master_id = icm.id_card_master_id
                INNER JOIN course_master cm ON cm.course_master_id = em.course_master_id
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

    public function totalIdCards($where){
        $result = $this->db->query("SELECT COUNT(*) as total 
                            FROM enrollment_master as em 
                            INNER JOIN id_card_master icm ON em.id_card_master_id = icm.id_card_master_id
                            WHERE ".$where."   ")->row_array();

        return $result;
    }
}