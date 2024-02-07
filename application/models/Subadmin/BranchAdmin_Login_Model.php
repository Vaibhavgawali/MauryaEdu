<?php

class BranchAdmin_Login_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*  check email id exists or not  */ 
    function checkEmailIdExistsOrNot($emailid){
        $result = $this->db->query("SELECT emailid FROM userinfo WHERE emailid = '" . $emailid ."'")->row_array();

        return @$result['emailid'];
    }

    /*  check user login  */ 
    function checkBranchAdminLogin($emailid,$password){
        $result = $this->db->query("SELECT * FROM branch_admin_master WHERE admin_emailid = '" . $emailid ."' AND password='".$password."'")->row_array();

        return $result;
    }

    /*  add user login data  */ 
    function addBranchAdminLoginData($checkLogin){
        $login_detail = array_merge($checkLogin);
        $login_detail['is_logged_in'] = true; 
        $login_detail['login_status'] = true;

        $role = $checkLogin['role'];

        $session_data = array(
            "login_detail" => $login_detail
        );

        $this->session->set_userdata($session_data);
    }

}

?>