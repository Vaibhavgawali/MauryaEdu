<?php

class Contacts_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - Contact details

    /*  Delete Contacts Info by ID  */
    function deleteContactsById($contact_id){
        $result = $this->db->query("Delete FROM contacts WHERE id = $contact_id");
        return $result;
    }

    // count all Contacts from list
    function countAllContactsList($where){
        $sql = "SELECT COUNT(contacts.id) AS total 
            FROM contacts 
            WHERE $where";
            
        $result = $this->db->query($sql);
        return $result->row();
    }

    // GET LIST OF ALL Contacts from list
    function listContactsQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT contacts.* 
            FROM contacts 
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

    // GET LIST OF ALL Contacts from list without constraints
    function getAllContactsList(){
        $sql = "SELECT * FROM contacts" ;

        $result = $this->db->query($sql)->result_array();
        return $result;
    }    

}