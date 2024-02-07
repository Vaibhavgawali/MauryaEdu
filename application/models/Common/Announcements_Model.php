<?php

class Announcements_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - Announcements details

    /*  Get Announcements Info using status  */
    function getAllAnnouncementsByStatus($announcement_status=NULL){
        $sql = "SELECT * FROM announcement_master WHERE 1=1 ";

        if($announcement_status != NULL){
            $sql .= " AND announcement_status=$announcement_status ";
        }

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    /*  Get Announcements Info from ID  */
    function getAnnouncementsById($announcement_master_id){
        $result = $this->db->query("SELECT * FROM announcement_master WHERE announcement_master_id = $announcement_master_id.")->row_array();

        return $result;
    }

    // count all Announcements from list
    function countAllAnnouncementsList($where){
        $sql = "SELECT COUNT(announcement_master.announcement_master_id) AS total 
            FROM announcement_master 
            WHERE $where";
            
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL Announcements from list
    function listAnnouncementsQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT announcement_master.* 
            FROM announcement_master 
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