<?php

class Certificate_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*  Get Enrollment Info from ID  */
    function getCertificateDetailsById($certificate_master_id){
        $result = $this->db->query("SELECT * FROM certificate_master WHERE certificate_master_id = '".$certificate_master_id."'")->row_array();

        return $result;
    }

    /* Get all certificates by student id */
    public function loadCertificates($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT em.*, ctm.* ,cm.*
                FROM enrollment_master as em
                INNER JOIN certificate_master ctm ON em.certificate_master_id = ctm.certificate_master_id
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

    public function totalCertificates($where){
        $result = $this->db->query("SELECT COUNT(*) as total 
                            FROM enrollment_master as em 
                            INNER JOIN certificate_master ctm ON em.certificate_master_id = ctm.certificate_master_id
                            WHERE ".$where."")->row_array();

        return $result;
    }

}