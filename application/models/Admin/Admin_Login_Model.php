<?php

class Admin_Login_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*  check email id exists or not  */ 
    function checkEmailIdExistsOrNot($emailid){
        $result = $this->db->query("SELECT * FROM userinfo WHERE emailid = '" . $emailid ."'")->row_array();

        // return @$result['emailid'];
        return $result;
    }

    /*  check user login  */ 
    function checkAdminLogin($emailid,$password){
        $result = $this->db->query("SELECT * FROM userinfo WHERE emailid = '" . $emailid ."' AND password='".$password."'")->row_array();

        return $result;
    }

    /*  add user login data  */ 
    function addAdminLoginData($checkLogin){
        $login_detail = array_merge($checkLogin);
        $login_detail['is_logged_in'] = true; // check if pos code avais_allowed_for_businessilable
        $login_detail['login_status'] = true;

        $role = $checkLogin['role'];

        $session_data = array(
            "login_detail" => $login_detail
        );

        $this->session->set_userdata($session_data);
    }

    /*  Get branch Info from ID  */
    function getAdminDetailsById($userinfo_id){
        $result = $this->db->query("SELECT * FROM userinfo WHERE userinfo_id = '".$userinfo_id."'")->row_array();

        return $result;
    }


    /*  Get Admin Info from emailid & user id  */
    function getAdminInfoFromEmailWithOtherAdminId($emailid, $userinfo_id){
        $result = $this->db->query("SELECT * FROM userinfo WHERE emailid = '".$emailid."' AND userinfo_id != $userinfo_id")->row_array();
        return $result;
    } 
}

?>