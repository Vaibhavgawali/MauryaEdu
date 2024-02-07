<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Student/Register_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index()
    {
        $login_detail = $this->session->userdata('login_detail_student');

        if(isset($login_detail) && $login_detail['is_logged_in_student'])
        {
            redirect(base_url() . 'student/dashboard');
            exit;
        }
        else
        {
            $this->load->view('student/register', $this->data);
        }
    }

    public function RegisterProcess()
    {
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);  
        $full_name = filter_smart($post_data['full_name']);
        $emailid = filter_smart($post_data['emailid']);
        $contact = filter_smart($post_data['contact']);

        $get_Student_Details = $this->Student_Details_Model->getStudentDetailsByEmail($emailid);

        if(empty($get_Student_Details)){

            $password_text = GeneratePassword();
            $password = hash('sha512',$password_text);

            $table_name = "student_master";

            $verificationCode = md5(ENCRIPTION_KEY.$emailid.ENCRIPTION_KEY);
            $verificationLink = base_url()."verifyStudentEmailAddress?email=".$emailid."&auth_code=".$verificationCode;

            $insert_array = array(
                "role"              => 1,
                "full_name"         => $full_name,
                "emailid"           => $emailid,
                "contact"           => $contact,
                "password"          => $password,
                "terms_and_policy"  => '1',
                "status"            => '2',
                "created_date"      => date('Y-m-d H:i:s'),
                "created_by"        => 0,
                "ip_address"        => $_SERVER['REMOTE_ADDR'],
                "verification_link" => $verificationLink,
                "ADD_REQUEST"       => json_encode($post_data, TRUE)
            );

            $student_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($student_id > 0){

                //--- sms notification
                if(IS_LIVE){
                    sendNewRegistrationSMS($full_name, $contact, $emailid, $password_text);
                }

                //--- email notification
                $message = "Dear ".$full_name.",<br><br>";
                $message .= "Your registration is successful !<br><br>";
                $message .= "<hr><br>";
                //$message .= "Please click the below link & get the access, <br><br>";
                //$message .= $verificationLink;
                // $message .= "<br><br>If you are unable to click on above link then just copy above link & paste it in your browser.<br>";
                // $message .= "<br><hr><br><br>";
                $message .= "Please use below details to login to your account.<br><br><br>";
                $message .= "Login Url: <a href=".base_url()."student/login>".base_url()."student/login</a> <br>";
                $message .= "Email ID: ".$emailid." <br>";
                $message .= "Password : ".$password_text." <br><br><br>";
                $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                $message .= "Thanks,<br>ChemCaliba";

                if(IS_LIVE){
                    sendEmail($emailid, 'Registration Details - '.COMPANY_NAME, $message, "", "", '', '','');
                }

                $status = true;
                // $res_message = "Registered successfully.<br><br>Login details & Verification email sent on your email & contact number. Kindly verify your email address to login to your account.";
                $res_message = "Registered successfully.<br><br>Login details & login details email sent on your email & contact number. Kindly check your email address to login to your account.";

            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Email already exists in records, Please choose different email for registration.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function verifyStudentEmailAddress()
    {
        $email = filter_smart($_GET['email']);
        $auth_code = filter_smart($_GET['auth_code']);
       
        $verificationCode = md5(ENCRIPTION_KEY.$email.ENCRIPTION_KEY);

        $status = true;
        $message = "";

        if($auth_code == $verificationCode){
            $studentInfo = $this->Student_Details_Model->getStudentDetailsByEmail($email);

            if(!empty($studentInfo)){
                if($studentInfo['status']=='1'){
                    $update_data = array(
                        "status"        => '2',
                        "updated_date"  => date('Y-m-d H:i:s'),
                        "ip_address"    => $_SERVER['REMOTE_ADDR']
                    );

                    $student_id = $studentInfo['student_id'];
                    //--- Update status of student
                    $this->Common_Model->updateTable("student_master",$update_data,array("student_id" => $student_id));

                    $status = true;
                    $message = "<b>Success!!</b> Email id verified successfully.<br>Please login to your account by clicking below login button.<br><br><center><a href='".base_url()."student/login' class='btn btn-primary'>Login</a></center>";

                }
                else{
                    $status = true;
                    $message = "<b>Already Verified!!</b> Your Email id already verified.<br>Please login to your account by clicking below login button.<br><br><center><a href='".base_url()."student/login' class='btn btn-primary btn-sm'>Login</a></center>";
                }
            }
            else{
                $status = false;
                $message = "<b>Invalid Parameter!!</b> Please try again.";
            }
            
        }
        else{
            $status = false;
            $message = "<b>Invalid Parameter!!</b> Please try again.";
        }
        
        $this->data['status'] = $status;
        $this->data['message'] = $message;

        $this->load->view('student/verify-email',$this->data);

        exit;

    }

}