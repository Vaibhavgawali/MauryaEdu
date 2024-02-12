<?php

class Id_Card_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - Enrollment details

    /*  Get Enrollment Info from ID  */
    function getIdCardDetailsById($id_card_master_id){
        $result = $this->db->query("SELECT * FROM id_card_master WHERE id_card_master_id = '".$id_card_master_id."'")->row_array();

        return $result;
    }
}