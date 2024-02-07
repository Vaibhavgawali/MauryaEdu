<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Student extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Admin/Student_List_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkAdminLoginSession();

        addJs(array("admin/student-list.js"));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $student_status_master = $this->Student_Details_Model->getStudentStatusMasterList();
        $this->data['student_status_master'] = $student_status_master;

        //print_r_custom($login_detail,1);
        $this->load->admintemplate('student-list', $this->data);
    }

    public function StudentListAjax()
    {
        $login_detail = $this->session->userdata('login_detail');
        //print_r_custom($login_detail,1);

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
            0=>'sm.student_id',
            1=>'sm.full_name',
            2=>'sm.emailid',
            3=>'sm.contact',
            4=>'sm.status_text',
            5=>'bm.branch_name',
            6=>'sm.created_date',
            7=>'sm.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "sm.full_name like '%$searchTerm%'  or  sm.emailid like '%$searchTerm%' or sm.contact like '%$searchTerm%' or bm.branch_name like '%$searchTerm%' ";
            $where .= ") ";
        }
        // print_r_custom("ok",1);

        /*Count Table result*/
        $total_count_array = $this->Student_List_Model->countAllStudentList($where);
        $totalData = $total_count_array->total;
        
        /*Total Filter Record and fetch data*/
        $list_array = $this->Student_List_Model->listStudentQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();
        
        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['student_id'] = $start;
            $nestedData['full_name'] = $main['full_name'];
            $nestedData['emailid'] = $main['emailid'];
            $nestedData['contact'] = $main['contact'];
            $nestedData['branch'] = $main['branch_name'];
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $student_id = $main['student_id'];
            $SHOP_STATUS = $SHOP_STATUS_ALERT = null;

            $status_text = $main['status_text'];
            $status_alert = $main['status_alert'];

            $status_display = "<span class='badge badge-".$status_alert."'>".$status_text."</span>";

            $nestedData['status'] = $status_display;

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_student' id='".$student_id."'><i class='fa fa-eye'></i> View</a>";

            $reset_password_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm reset_password_student' id='".$student_id."'><i class='fa fa-lock'></i> Reset Password</a>";

            $delete_button = "<a href='javascript:void(0);' class='btn btn-danger btn-sm delete_student' id='".$student_id."'><i class='fa fa-trash'></i> Delete</a>";

            $action = "";
            $action .= $edit_button."&nbsp;&nbsp;".$reset_password_button."&nbsp;&nbsp;".$delete_button;

            if($main['status'] == '1' || $main['status'] == 1){
                $resend_verfication_link_btn = "";
                $resend_verfication_link_btn = "<a href='javascript:void(0);' class='btn btn-warning btn-sm resend_verification_link' id='".$student_id."'><i class='fa fa-envelope'></i> Send Verification Link</a>";

                $action .= "&nbsp;&nbsp;".$resend_verfication_link_btn;
            }
            
            $nestedData['action'] = $action;


            $data[] = $nestedData;
        }

        $json_data = array(
            "draw" => $draw,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

    public function GetStudentDetails()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $student_details = array();
        $message = "Student details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $student_id = filter_smart($post_data['student_id']);

        $get_Student_Details = $this->Student_Details_Model->getStudentDetailsById($student_id);

        if(count($get_Student_Details) == 0){
            $status = false;
            $student_details = array();
            $message = "Course details not found";
        }
        else{
            $student_details = array(
                'student_id' => $get_Student_Details['student_id'],
                'full_name' => $get_Student_Details['full_name'],
                'emailid' => $get_Student_Details['emailid'],
                'contact' => $get_Student_Details['contact'],
                'aadhar_number' => $get_Student_Details['aadhar_number'],
                'address' => $get_Student_Details['address'],
                'status' => $get_Student_Details['status']
            );
        }

        $response = array(
            'status'    => $status,
            'student_details'  => $student_details,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    public function StudentUpdateProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $res_status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $student_id = filter_smart($post_data['student_id']);
        $full_name = filter_smart($post_data['full_name']);
        $emailid = filter_smart($post_data['emailid']);
        $contact = filter_smart($post_data['contact']);
        $aadhar_number = filter_smart($post_data['aadhar_number']);
        $address = filter_smart($post_data['address']);
        $status = filter_smart($post_data['status']);
        
        $get_Student_Details = $this->Student_Details_Model->getStudentsInfoFromEmailWithOtherUserId($emailid, $student_id);
        
        if(empty($get_Student_Details)){

            $table_name = "student_master";

            $where = array('student_id' => $student_id);

            $update_array = array(
                "full_name"         => $full_name,
                "emailid"           => $emailid,
                "contact"           => $contact,
                "aadhar_number"     => $aadhar_number,
                "address"           => $address,
                "status"            => $status,
                "updated_date"      => date('Y-m-d H:i:s'),
                "updated_by"        => $userinfo_id,
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $res_status = true;
            $res_message = "Student details updated successfully.";
        }
        else{
            $res_status = false;
            $res_message = "Student email already exists in records, Please choose different email.";
        }
        
        $response = array(
            'status'    => $res_status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function ResetStudentPassword()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];

        $status = true;
        $message = "Student password reset successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $student_id = filter_smart($post_data['student_id']);

        $get_Student_Details = $this->Student_Details_Model->getStudentDetailsById($student_id);

        if(count($get_Student_Details) == 0){
            $status = false;
            $message = "Course details not found";
        }
        else{
            $password = hash('sha512', RESET_DEFAULT_PASSWORD);

            $table_name = "student_master";

            $where = array('student_id' => $student_id);

            $update_array = array(
                "password"          => $password,
                "updated_date"      => date('Y-m-d H:i:s'),
                "updated_by"        => $userinfo_id,
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $res_status = true;
            $res_message = "Student password reset successfully.";
        }

        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }
   
    public function DeleteStudent()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];

        $status = true;
        $message = "Student deleted successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $student_id = filter_smart($post_data['student_id']);

        $del_student = $this->Student_Details_Model->deleteStudentById($student_id);

        if($del_student == false){
            $status = false;
            $message = "Something went wrong !";
        }

        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }
}