<?php

class Certificate_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - Enrollment details

    /*  Get Enrollment Info from ID  */
    function getCertificateDetailsById($certificate_master_id){
        $result = $this->db->query("SELECT * FROM certificate_master WHERE certificate_master_id = '".$certificate_master_id."'")->row_array();

        return $result;
    }
}