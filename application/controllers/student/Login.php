<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Student/Login_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        $login_detail = $this->session->userdata('student_login_detail');

        if(!empty($login_detail) && $login_detail['student_is_logged_in']=='1' && $login_detail['student_id'] > 0)
        {
            redirect(base_url() . 'student/dashboard');
            exit;
        }
        else
        {
            $this->load->view('student/login', $this->data);
        }
    }

    public function LoginProcess()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $emailid = filter_smart($post_data['emailid']);
        $password = filter_smart($post_data['password']);
        // print_r_custom($password,1);
        $password = hash('sha512', $password);

        $student_info = $this->Login_Model->checkEmailIdExistsOrNot($emailid);

        if(!empty($student_info))
        {
            $full_name = $student_info['full_name'];
            $student_id = $student_info['student_id'];
            $branch_id = $student_info['branch_id'];
            $status = $student_info['status'];
            
            if($status == '1')
            {
                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>VERIFY! </b>Email Verification Pending. <br><br>You can write query to <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
            }
            else
            if($status == '3')
            {
                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>ERROR! </b>Your account is inactive.<br> Please contact <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
            }
            else{
                $check_student_login = $this->Login_Model->checkStudentLogin($emailid, $password);
                
                if(!empty($check_student_login))
                {
                    $this->data['result']['status'] = true;
                    $this->data['result']['message'] = "Successfully Login";

                    $this->Login_Model->addStudentLoginData($check_student_login);  //set shop session
                }
                else{
                    $check_student_login_temp = $this->Login_Model->checkStudentLoginWithTempPassword($emailid, $password);
                    
                    if(!empty($check_student_login_temp))
                    {
                        $temp_password_created_on = $check_student_login_temp['temp_password_created_on'];

                        if( strtotime($temp_password_created_on) >= strtotime(date('Y-m-d H:i:s')) ){

                            $this->data['result']['status'] = true;
                            $this->data['result']['message'] = "Successfully Login";

                            $this->Login_Model->addStudentLoginData($check_student_login_temp);  //set shop session
                        }
                        else{
                            $this->data['result']['status'] = false;
                            $this->data['result']['message'] = "<b>ERROR! </b>Your temporary password was expired. Try forgot password now.";
                        }
                    }
                    else{
                        $this->data['result']['status'] = false;
                        $this->data['result']['message'] = "<b>ERROR! </b>Invalid Login";
                    }
                }
            }
            
        }
        else
        {
            $this->data['result']['status'] = false;
            $this->data['result']['message'] = "<b>INVALID LOGIN! </b>Please try again";
        }

        echo json_encode($this->data['result']);
        exit;
        
    }

    public function Logout()
    {
        $this->session->unset_userdata('student_login_detail');
        $this->session->unset_userdata('student_cart_details');

        redirect(base_url().'student/login');
    }
    
    public function ForgotPassword()
    {
        $login_detail = $this->session->userdata('student_login_detail');

        if(!empty($login_detail) && $login_detail['student_is_logged_in']=='1' && $login_detail['student_id'] > 0)
        {
            redirect(base_url() . 'student/dashboard');
            exit;
        }
        else
        {
            $this->load->view('student/forgot-password', $this->data);
        }
    }

    public function ForgotPasswordProcess()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $emailid = filter_smart($post_data['emailid']);

        $student_info = $this->Login_Model->checkEmailIdExistsOrNot($emailid);

        if(!empty($student_info))
        {
            $full_name = $student_info['full_name'];
            $student_id = $student_info['student_id'];
            $status = $student_info['status'];
            
            if($status == '1')
            {
                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>VERIFY! </b>Email Verification Pending. <br><br>You can write query to <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
            }
            else
            if($status == '3')
            {
                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>ERROR! </b>Your account is inactive.<br> Please contact <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
            }
            else{
                $temp_password = GeneratePassword();
                $PASSWORD = hash('sha512',$temp_password);

                $temp_password_created_on = date("Y-m-d H:i:s",strtotime ( '+1 day' , strtotime(date('Y-m-d H:i:s')) )) ;
                
                $update_array = array(
                    'temp_password' => $PASSWORD,
                    'temp_password_created_on' => $temp_password_created_on,
                    'updated_date' => date("Y-m-d H:i:s"),
                    'ip_address' => $_SERVER['REMOTE_ADDR']
                );

                $where = array('student_id' => $student_id, 'emailid' => $emailid);

                $update_status = $this->Common_Model->updateTable('student_master', $update_array, $where);

                if($update_status){
                    $message = "Dear ".$full_name.",<br><br>";
                    $message .= "<hr><br>";
                    $message .= "Please find below temporary password generated to login your student account.<br><br>";
                    $message .= "This password is valid for 24 hours.<br>";
                    $message .= "<br><hr><br><br>";
                    $message .= "Please use below details to login to your account.<br><br><br>";
                    $message .= "<b>Email ID: </b>".$emailid." <br>";
                    $message .= "<b>Temporary Password : </b>".$temp_password." <br>";
                    $message .= "<b>Password Valid Till: </b>".date('d-m-Y H:i:s', strtotime($temp_password_created_on))." <br><br><br>";
                    $message .= "<span style='background-color:red; color:yellow;'><b>Please change your password once you login to your student account </b></span> <br><br><br>";
                    $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";

                    if(IS_LIVE){
                        sendEmail($emailid, 'Forgot Password - '.COMPANY_NAME, $message, "", "", '', '','');
                    }
                }

                $this->data['result']['status'] = true;
                $this->data['result']['message'] = "Temporary paasword generated successfully & sent to your email id.<br>Now you can login to your account using the temporary password sent on your email id.<br><span style='background-color:red; color:yellow;'><b>Please change your password once you login to your student account </b></span> ";
            }
            
        }
        else
        {
            $this->data['result']['status'] = false;
            $this->data['result']['message'] = "<b>INVALID PARAMETER! </b>Please try again";
        }

        echo json_encode($this->data['result']);
        exit;
        
    }
}

?>