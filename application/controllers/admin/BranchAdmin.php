<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BranchAdmin extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Branch_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Branch_Admin_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkAdminLoginSession();

        addJs(array("admin/branch-admin-list.js"));

        $branch_list = $this->Branch_Model->getAllBranchDetailsByStatus(1);
        //print_r_custom($course_category_list,1);

        $login_detail = $this->session->userdata('login_detail');
        
        $this->data['login_detail'] = $login_detail;
        $this->data['branch_list'] = $branch_list;

        $student_status_master = $this->Student_Details_Model->getStudentStatusMasterList();
        $this->data['student_status_master'] = $student_status_master;

        $this->load->admintemplate('branch-admin-list', $this->data);
    }

    public function BranchAdminAddProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);

        $admin_name = filter_smart($post_data['admin_name']);
        $branch_id = filter_smart($post_data['branch_id']);
        $admin_emailid = filter_smart($post_data['admin_emailid']);
        $admin_contact = filter_smart($post_data['admin_contact']);

        $get_Branch_Details = $this->Branch_Admin_Model->getBranchAdminByNameAndBranch($admin_name, $branch_id);
        // print_r_custom($get_Branch_Details,1);

        if(empty($get_Branch_Details)){

            // $password_text = GeneratePassword();
            $password_text = "password";
            $password = hash('sha512',$password_text);

            $table_name = "branch_admin_master";

            $verificationCode = md5(ENCRIPTION_KEY.$admin_emailid.ENCRIPTION_KEY);
            $verificationLink = base_url()."verifyBranchAdminEmailAddress?email=".$admin_emailid."&auth_code=".$verificationCode;

            $insert_array = array(
                "admin_name"    => $admin_name,
                "branch_id"      => $branch_id,
                "admin_emailid"   => $admin_emailid,
                "admin_contact"   => $admin_contact,
                "password"        => $password,
                "admin_status"    => '1',
                "created_date"     => date('Y-m-d H:i:s'),
                "created_by"       => $userinfo_id,
                "ip_address"        => $_SERVER['REMOTE_ADDR'],
                "verification_link" => $verificationLink,
                "ADD_REQUEST"       => json_encode($post_data, TRUE)
            );

            $branch_admin_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($branch_admin_id > 0){

                //--- sms notification
                // if(IS_LIVE){
                //     sendNewRegistrationSMS($admin_name, $admin_contact, $admin_emailid, $password_text);
                // }

                //--- email notification
                $message = "Dear ".$admin_name.",<br><br>";
                $message .= "Your registration is successful !<br><br>";
                $message .= "<hr><br>";

                $message .= "Please use below details to login to your account.<br><br><br>";
                $message .= "Login Url: <a href=".base_url()."subadmin/login>".base_url()."subadmin/login</a> <br>";
                $message .= "Email ID: ".$admin_emailid." <br>";
                $message .= "Password : ".$password_text." <br><br><br>";
                $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                $message .= "Thanks,<br>MouryaEdu";

                if(IS_LIVE){
                    sendEmail($admin_emailid, 'Registration Details - '.COMPANY_NAME, $message, "", "", '', '','');
                }

                $status = true;
                $res_message = "Branch admin added successfully.<br><br>Login details & login details email sent on email. Kindly check your email address to login to your account.";

            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Branch admin already exists in records, Please choose different Branch.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function BranchAdminListAjax()
    {
        $login_detail = $this->session->userdata('login_detail');
        // print_r_custom($login_detail,1);die;

        $requestData = $_REQUEST;
        $draw = $requestData['draw'];
        $start = $requestData['start']; /*start length*/
        $length = $requestData['length']; /*End length*/
        $order = $requestData['order']; /*Order by col index*/
        $search = $requestData['search']; /*search */
        // echo "<pre>";
        // print_r($search);
        /*Search value single search*/
        $searchTerm = $search['value'];
        /*order by colum value*/
        $colums = array(
            0=>'admin_id',
            1=>'admin_name',
            2=>'branch_name',
            3=>'admin_emailid',
            4=>'admin_contact',
            5=>'admin_status',
            6=>'created_date',
            7=>'updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "bam.admin_name like '%$searchTerm%' OR bm.branch_name like '%$searchTerm%' ";
            $where .= ") ";
        }
        
        /*Count Table result*/
        $total_count_array = $this->Branch_Admin_Model->countAllBranchAdminList($where);
        $totalData = $total_count_array->total;

        /*Total Filter Record and fetch data*/
        $list_array = $this->Branch_Admin_Model->listBranchAdminQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();
        // print_r_custom($list_array,1);die;

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['admin_id'] = $start;
            $nestedData['admin_name'] = $main['admin_name'];
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $nestedData['branch_name']=$main['branch_name'];
            $nestedData['admin_emailid']=$main['admin_emailid'];
            $nestedData['admin_contact']=$main['admin_contact'];

            $admin_status = $main['admin_status'];
            $status_display = "";

            $status_text = $main['status_text'];
            $status_alert = $main['status_alert'];

            $status_display = "<span class='badge badge-".$status_alert."'>".$status_text."</span>";

            $nestedData['status'] = $status_display;

            $admin_id = $main['admin_id'];
            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_branch_admin' id='".$admin_id."'><i class='fa fa-eye'></i> View</a>";
            $reset_password_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm reset_password_admin' id='".$admin_id."'><i class='fa fa-lock'></i> Reset Password</a>";

            $action = "";
            $action .= $edit_button."&nbsp;&nbsp;".$reset_password_button;
            
            $nestedData['action'] = $action;

            $data[] = $nestedData;
        }
        // print_r_custom($data,1);die;

        $json_data = array(
            "draw" => $draw,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

    //get branch details
    public function GetBranchAdminDetails()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $branch_details = array();
        $message = "Branch admin details fetch successfully";

        $post_data = $this->input->post();
        // print_r_custom( $post_data,1);

        //extract($post_data);
        $branch_admin_id = filter_smart($post_data['branch_admin_id']);

        $get_branch_admin_Details = $this->Branch_Admin_Model->getBranchAdminDetailsById($branch_admin_id);
        // print_r_custom( $get_Branch_Admin_Details,1);

        if(count($get_branch_admin_Details) == 0){
            $status = false;
            $branch_details = array();
            $message = "Branch details not found";
        }
        else{
            $status_html = null;

            $admin_status = $get_branch_admin_Details['admin_status'];

            // if($admin_status=="1"){
            //     $status_html .= "<option value='1' selected>Active</option>";
            //     $status_html .= "<option value='0'>In-Active</option>";
            // }
            // else
            // if($admin_status=="0"){
            //     $status_html .= "<option value='1'>Active</option>";
            //     $status_html .= "<option value='0' selected>In-Active</option>";
            // }
            // else{
            //     $status_html .= "<option value='1'>Active</option>";
            //     $status_html .= "<option value='0'>In-Active</option>";
            // }

            $branch_admin_details = array(
                'admin_name' => $get_branch_admin_Details['admin_name'],
                'branch_id' => $get_branch_admin_Details['branch_id'],
                "admin_emailid" => $get_branch_admin_Details['admin_emailid'],
                "admin_contact" => $get_branch_admin_Details['admin_contact'],
                // 'admin_status_html' => $status_html,
                'admin_status' => $get_branch_admin_Details['admin_status']
            );
        }

        $response = array(
            'status'    => $status,
            'branch_admin_details'  => $branch_admin_details,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    // update branch
    public function BranchAdminUpdateProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        //extract($post_data);
        $branch_admin_id = filter_smart($post_data['branch_admin_id']); 
        $branch_id = filter_smart($post_data['branch_id']); 
        $admin_name = filter_smart($post_data['admin_name']);
        $admin_emailid = filter_smart($post_data['admin_emailid']);
        $admin_contact = filter_smart($post_data['admin_contact']);
        $admin_status = filter_smart($post_data['admin_status']);

        $get_branch_Details = $this->Branch_Admin_Model->getBranchAdminDetailsById($branch_admin_id);

        if(!empty($get_branch_Details)){

            $table_name = "branch_admin_master";

            $where = array( "admin_id" => $branch_admin_id);

            $update_array = array(
                "admin_name"      => $admin_name,
                "branch_id"      => $branch_id,
                "admin_emailid"   => $admin_emailid,
                "admin_contact"   => $admin_contact,
                "admin_status"    => $admin_status,
                "updated_date"     => date('Y-m-d H:i:s'),
                "updated_by"       => $userinfo_id,
            );

            $this->Common_Model->updateTable("$table_name", $update_array, $where);

            $status = true;
            $res_message = "Branch admin details updated successfully.";
            
        }
        else{
            $status = false;
            $res_message = "Branch admin doesn't exists in records, Please choose different Branch admin.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function ResetBranchAdminPassword()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];

        $status = true;
        $message = "Branch admin password reset successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $admin_id = filter_smart($post_data['branch_admin_id']);

        $get_admin_Details = $this->Branch_Admin_Model->getBranchAdminDetailsById($admin_id);

        if(count($get_admin_Details) == 0){
            $status = false;
            $message = "Branch admin details not found";
        }
        else{
            $password = hash('sha512', RESET_DEFAULT_PASSWORD);

            $table_name = "branch_admin_master";

            $where = array('admin_id' => $admin_id);

            $update_array = array(
                "password"          => $password,
                "updated_date"      => date('Y-m-d H:i:s'),
                "updated_by"        => $userinfo_id,
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $res_status = true;
            $res_message = "Branch admin password reset successfully.";
        }

        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }   

    public function verifyBranchAdminEmailAddress()
    {
        $email = filter_smart($_GET['email']);
        $auth_code = filter_smart($_GET['auth_code']);
       
        $verificationCode = md5(ENCRIPTION_KEY.$email.ENCRIPTION_KEY);

        $status = true;
        $message = "";

        if($auth_code == $verificationCode){
            $adminInfo = $this-> Branch_Admin_Model->getBranchAdminDetailsByEmail($email);

            if(!empty($adminInfo)){
                if($adminInfo['admin_status']=='1'){
                    $update_data = array(
                        "status"        => '2',
                        "updated_date"  => date('Y-m-d H:i:s'),
                        "ip_address"    => $_SERVER['REMOTE_ADDR']
                    );

                    $admin_id = $adminInfo['admin_id'];
                    //--- Update status of student
                    $this->Common_Model->updateTable("branch_admin_master",$update_data,array("admin_id" => $admin_id));

                    $status = true;
                    $message = "<b>Success!!</b> Email id verified successfully.<br>Please login to your account by clicking below login button.<br><br><center><a href='".base_url()."subadmin/login' class='btn btn-primary'>Login</a></center>";

                }
                else{
                    $status = true;
                    $message = "<b>Already Verified!!</b> Your Email id already verified.<br>Please login to your account by clicking below login button.<br><br><center><a href='".base_url()."subadmin/login' class='btn btn-primary btn-sm'>Login</a></center>";
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

        $this->load->view('subadmin/verify-email',$this->data);

        exit;

    }
}