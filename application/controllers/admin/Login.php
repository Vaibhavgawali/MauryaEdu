<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Admin/Admin_Login_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        $login_detail = $this->session->userdata('login_detail');        
        if(isset($login_detail) && $login_detail['is_logged_in']){
            redirect(base_url() . 'admin/dashboard');
            exit;
        }
        else{
            $this->load->view('admin/login');
        }
    }

    public function LoginProcess()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $emailid = filter_smart($post_data['emailid']);
        $password = filter_smart($post_data['password']);
        
        $password = hash('sha512', $password);
            
        $checkLogin = $this->Admin_Login_Model->checkAdminLogin($emailid,$password);

        if(!empty($checkLogin)){
            $this->data['result']['login_status'] = $checkLogin['status'];

            if($checkLogin['status']=='1'){

                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>ERROR! </b>Your email is not verified yet.<br> For more details Please contact <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
                $this->data['result']['user_status'] = "";

            }
            else
            if($checkLogin['status']=='2'){

                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>ERROR! </b>Your account is inactive.<br> Please contact <b style='color:#f6a002;'>".COMPANY_EMAIL."</b>";
                $this->data['result']['user_status'] = "";

            }
            else
            if($checkLogin['status']=='3'){

                $this->data['result']['status'] = true;
                $this->data['result']['message'] = "Successfully Login";
                $this->data['result']['user_status'] = "";

                $this->Admin_Login_Model->addAdminLoginData($checkLogin);  //set admin session
                
            }
            else
            if($checkLogin['status']=='4'){

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

        redirect(base_url().'admin/login');
    }
}
