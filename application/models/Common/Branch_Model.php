<?php

class Branch_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - course category details

    /*  Get branch Info using status  */
    function getAllBranchDetailsByStatus($branch_status){
        $result = $this->db->query("SELECT * FROM branch_master WHERE branch_status = '".$branch_status."'")->result_array();

        return $result;
    }

    /*  Get branchy Info from name  */
    function getBranchDetailsByName($branch_name){
        $result = $this->db->query("SELECT * FROM branch_master WHERE LOWER(branch_name) = '".strtolower($branch_name)."'")->row_array();

        return $result;
    }

    /*  Get branch Info from ID  */
    function getBranchDetailsById($branch_id){
        $result = $this->db->query("SELECT * FROM branch_master WHERE branch_id = '".$branch_id."'")->row_array();

        return $result;
    }

    /*  Get branch Info from multiple ID  */
    function getBranchDetailsByMultipleId($branch_id){
        $result = $this->db->query("SELECT * FROM branch_master WHERE branch_id IN($branch_id)")->result_array();
        return $result;
    }

    // count branch from list
    function countAllBranchList($where){
        // print_r($where);
        $sql = "SELECT COUNT(branch_id) AS total FROM branch_master AS sm WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }

    // GET LIST OF ALL branch from list
    function listBranchQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT * 
            FROM branch_master As sm
            WHERE $where 
            ORDER BY $order_by $order_dir LIMIT $start, $length";
        // print_r($sql);
        $result = $this->db->query($sql)->result_array();
        // print_r($result);
        $result_total = $this->db->query($sql)->num_rows();
        $array = array(
            "Result" => $result,
            "Result_total_filter" => $result_total,
        );
        return $array;
    }

    /*  Get branch Info from name with other id  */
    function getBranchDetailsByNameWithOtherId($branch_name, $branch_id){
        $result = $this->db->query("SELECT * FROM branch_master WHERE LOWER(branch_name) = '".strtolower($branch_name)."' AND branch_id != ".$branch_id)->row_array();

        return $result;
    }

}