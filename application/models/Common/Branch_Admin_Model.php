<?php

class Branch_Admin_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - branch admin details

    /*  Get branches Info using status  */
    function getAllBranchDetailsByStatus($branch_status){
        $result = $this->db->query("SELECT * FROM branch_master WHERE branch_status = '".$branch_status."'")->result_array();

        return $result;
    }

    /*  Get branch Info from name  */
    function getBranchDetailsByName($branch_name){
        $result = $this->db->query("SELECT * FROM branch_master WHERE LOWER(branch_name) = '".strtolower($branch_name)."'")->row_array();

        return $result;
    }

    /*  Get branch Info from ID  */
    function getBranchAdminDetailsById($branch_admin_id){
        $result = $this->db->query("SELECT * FROM branch_admin_master WHERE admin_id = '".$branch_admin_id."'")->row_array();

        return $result;
    }

    /*  Get course category Info from multiple ID  */
    function getBranchDetailsByMultipleId($branch_id){
        $result = $this->db->query("SELECT * FROM branch_master WHERE branch_id IN($branch_id)")->result_array();

        return $result;
    }

    // count all branch admin from list
    function countAllBranchAdminList($where){
        // print_r($where);
        $sql = "SELECT COUNT(admin_id) AS total FROM branch_admin_master As bam
        LEFT JOIN branch_master AS bm ON bam.branch_id = bm.branch_id WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }

    // GET LIST OF ALL branch admin from list
    function listBranchAdminQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT * 
            FROM branch_admin_master As bam
            LEFT JOIN branch_master AS bm ON bam.branch_id = bm.branch_id
            LEFT JOIN student_status_master AS ssm ON bam.admin_status = ssm.status_id 
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

    /*  Get branch admin Info from name with branch id  */
    function getBranchAdminByNameAndBranch($admin_name, $branch_id){

        $this->db->select('*');
        $this->db->from('branch_admin_master');
        $this->db->where('LOWER(admin_name)', strtolower($admin_name));
        $this->db->where('branch_id =', $branch_id);
    
        $query = $this->db->get();
        $result = $query->row_array();

        return $result;
    }

    /*  Get Student Info from emailid & user id  */
    function getBranchAdminInfoFromEmailWithOtherAdminId($emailid, $admin_id){
        $result = $this->db->query("SELECT * FROM branch_admin_master WHERE admin_emailid = '".$emailid."' AND admin_id != $admin_id")->row_array();
        return $result;
    } 
}