<?php

class Login_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    /*  check email id exists or not  */ 
    function checkEmailIdExistsOrNot($emailid){
        $result = $this->db->query("SELECT * FROM student_master WHERE emailid = '" . $emailid ."'")->row_array();

        return $result;
    }

    /*  check user login  */ 
    function checkStudentLogin($emailid, $password){
        $result = $this->db->query("SELECT * FROM student_master WHERE emailid = '" . $emailid ."' AND password='".$password."'")->row_array();

        return $result;
    }

    /*  check user login  */ 
    function checkStudentLoginWithTempPassword($emailid, $password){
        $result = $this->db->query("SELECT * FROM student_master WHERE emailid = '" . $emailid ."' AND temp_password='".$password."'")->row_array();

        return $result;
    }

    /*  add user login data  */ 
    function addStudentLoginData($checkLogin){
        $login_detail = array_merge($checkLogin);
        $login_detail['student_is_logged_in'] = true;
        $login_detail['student_login_status'] = true;

        $role = $checkLogin['role'];

        $session_data = array(
            "student_login_detail" => $login_detail
        );

        $this->session->set_userdata($session_data);
    }

}

?>