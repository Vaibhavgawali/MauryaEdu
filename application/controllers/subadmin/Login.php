<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Subadmin/BranchAdmin_Login_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        $login_detail = $this->session->userdata('login_detail');        
        if(isset($login_detail) && $login_detail['is_logged_in']){
            redirect(base_url() . 'subadmin/dashboard');
            exit;
        }
        else{
            $this->load->view('subadmin/login');
        }
    }

    public function LoginProcess()
    {
        $post_data = $this->input->post();

        // extract($post_data);
        $emailid = filter_smart($post_data['emailid']);
        $password = filter_smart($post_data['password']);
        
        $password = hash('sha512', $password);
            
        $checkLogin = $this->BranchAdmin_Login_Model->checkBranchAdminLogin($emailid,$password);

        if(!empty($checkLogin)){
            $this->data['result']['login_status'] = $checkLogin['admin_status'];

            if($checkLogin['admin_status']=='1'){

                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>ERROR! </b>Your email is not verified yet.<br> For more details Please contact <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
                $this->data['result']['user_status'] = "";

            }
            else
            if($checkLogin['admin_status']=='3'){

                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>ERROR! </b>Your account is inactive.<br> Please contact <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
                $this->data['result']['user_status'] = "";

            }
            else
            if($checkLogin['admin_status']=='2'){

                $this->data['result']['status'] = true;
                $this->data['result']['message'] = "Successfully Login";
                $this->data['result']['user_status'] = "";

                $this->BranchAdmin_Login_Model->addBranchAdminLoginData($checkLogin);  
                
            }
            else
            if($checkLogin['admin_status']=='4'){

                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>ERROR! </b>Your account is suspended.<br> Please contact <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
                $this->data['result']['user_status'] = "";

            }
        }
        else{

            $this->data['result']['status'] = false;
            $this->data['result']['message'] = "<b>ERROR! </b>Invalid Login";
            $this->data['result']['user_status'] = "";

        }

        echo json_encode($this->data['result']);
        exit;
    }

    public function Logout()
    {
        $this->session->unset_userdata('login_detail');
        //print_r_custom($this->session->userdata,1);

        redirect(base_url().'subadmin/login');
    }

    public function ForgotPassword()
    {
        $login_detail = $this->session->userdata('login_detail');

        if(!empty($login_detail) && $login_detail['is_logged_in']=='1' && $login_detail['admin_id'] > 0)
        {
            redirect(base_url() . 'subadmin/dashboard');
            exit;
        }
        else
        {
            $this->load->view('subadmin/forgot-password', $this->data);
        }
    }

    public function ForgotPasswordProcess()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $emailid = filter_smart($post_data['emailid']);

        $admin_info = $this->BranchAdmin_Login_Model->checkEmailIdExistsOrNot($emailid);

        if(!empty($admin_info))
        {
            $admin_name = $admin_info['admin_name'];
            $admin_id = $admin_info['admin_id'];
            $status = $admin_info['admin_status'];
            
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

                $where = array('admin_id' => $admin_id, 'admin_emailid' => $emailid);

                $update_status = $this->Common_Model->updateTable('branch_admin_master', $update_array, $where);

                if($update_status){
                    $message = "Dear ".$admin_name.",<br><br>";
                    $message .= "<hr><br>";
                    $message .= "Please find below temporary password generated to login your branch account.<br><br>";
                    $message .= "This password is valid for 24 hours.<br>";
                    $message .= "<br><hr><br><br>";
                    $message .= "Please use below details to login to your account.<br><br><br>";
                    $message .= "<b>Email ID: </b>".$emailid." <br>";
                    $message .= "<b>Temporary Password : </b>".$temp_password." <br>";
                    $message .= "<b>Password Valid Till: </b>".date('d-m-Y H:i:s', strtotime($temp_password_created_on))." <br><br><br>";
                    $message .= "<span style='background-color:red; color:yellow;'><b>Please change your password once you login to your branch account </b></span> <br><br><br>";
                    $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";

                    if(IS_LIVE){
                        sendEmail($emailid, 'Forgot Password - '.COMPANY_NAME, $message, "", "", '', '','');
                    }
                }

                $this->data['result']['status'] = true;
                $this->data['result']['message'] = "Temporary paasword generated successfully & sent to your email id.<br>Now you can login to your account using the temporary password sent on your email id.<br><span style='background-color:red; color:yellow;'><b>Please change your password once you login to your branch account </b></span> ";
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
