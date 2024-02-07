<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Enrollments extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Admin/Student_List_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkBranchAdminLoginSession();

        addJs(array("subadmin/enrollment-list.js"));
        
        $login_detail = $this->session->userdata('login_detail');
        // print_r_custom($login_detail,1);
        $this->data['login_detail'] = $login_detail;
        $this->load->subadmintemplate('enrollment-list', $this->data);
    }

    public function StudentListAjax()
    {
        $login_detail = $this->session->userdata('login_detail');
        // print_r_custom($login_detail,1);

        $requestData = $_REQUEST;
        $draw = $requestData['draw'];
        $start = $requestData['start']; /*start length*/
        $length = $requestData['length']; /*End length*/
        $order = $requestData['order']; /*Order by col index*/
        $search = $requestData['search']; /*search */
        
        /*Search value single search*/
        $searchTerm = $search['value'];
        
        /*order by colum value*/
        $colums = array(
            0=>'em.student_id',
            1=>'sm.full_name',
            2=>'sm.emailid',
            3=>'sm.contact',
            4=>'cm.course_name',
            5=>'pm.course_actual_price',
            6=>'cm.paid_price',
            7=>'em.valid_upto',
            8=>'em.created_date',
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";
        $where .= " AND sm.branch_id = " . $login_detail['branch_id'];

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= " AND (";
            $where .= "sm.full_name like '%".$searchTerm."%'  OR  
                       sm.emailid like '%".$searchTerm."%' OR 
                       sm.contact like '%".$searchTerm."%' OR
                       cm.course_name like '%".$searchTerm."%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Student_List_Model->countAllEnrolledStudentList($where);
        $totalData = $total_count_array->total;

        /*Total Filter Record and fetch data*/
        $list_array = $this->Student_List_Model->listEnrolledStudentQuery($where, $order_by, $start, $length, $order_dir);
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
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['course_actual_price'] = $main['course_actual_price'];
            $nestedData['paid_price'] = $main['paid_price'];
            $nestedData['valid_upto'] = date('d-m-Y H:i:s', strtotime($main['valid_upto']));
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));;

            $enrollment_id = $main['enrollment_master_id'];

            $current_date = date('Y-m-d H:i:s');
            $today = new Datetime($current_date);
            $validity_date = new Datetime($main['valid_upto']);

            if($today > $validity_date)
            {
                $nestedData['validity_status'] = "<span class='badge badge-danger'>Expired</span>";
            }
            else
            {
                $nestedData['validity_status'] = "<span class='badge badge-success'>Active</span>";
            }

            // course status for particular student
            $student_course_status=$main['enrollment_status'];
            if($student_course_status == 1)
            {
                $nestedData['status'] = "<span class='badge badge-success'>Active</span>";
            }
            else
            {
                $nestedData['status'] = "<span class='badge badge-danger'>Inactive</span>";
            }

            // $student_id = $main['student_id'];
            // $SHOP_STATUS = $SHOP_STATUS_ALERT = null;

            // $status_text = $main['status_text'];
            // $status_alert = $main['status_alert'];

            // $status_display = "<span class='badge badge-".$status_alert."'>".$status_text."</span>";

            // $nestedData['status'] = $status_display;

            

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_student_status' id='".$enrollment_id."'><i class='fa fa-eye'></i> View</a>";

            $delete_button = "<a href='javascript:void(0);' class='btn btn-danger btn-sm delete_student_enrollment' id='".$enrollment_id."'><i class='fa fa-trash'></i> Delete</a>";

            $action = "";
            $action .= $edit_button."&nbsp;&nbsp;&nbsp;".$delete_button;
            
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
        // print_r_custom($json_data);
    }

    //get enrollment details of student
    public function GetEnrollmentStudentsDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $enrollment_student_details = array();
        $message = "Student details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);
        $get_Enrolllment_Student_Details = $this->Enrollment_Model->getEnrollmentDetailsById($enrollment_id);

        if(count($get_Enrolllment_Student_Details) == 0){
            $status = false;
            $enrollment_student_details = array();
            $message = "Course category details not found";
        }
        else{
            $status_html = null;

            $student_course_status = $get_Enrolllment_Student_Details['enrollment_status'];

            if($student_course_status == "1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($student_course_status == "0" ){
                $status_html .= "<option value='0' selected>In-Active</option>";
                $status_html .= "<option value='1'>Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
        // print_r_custom($status_html);

            $enrollment_student_details = array(
                'enrollment_id' => $get_Enrolllment_Student_Details['enrollment_master_id'],
                'enrollment_student_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'enrollment_student_details' => $enrollment_student_details,
            'message'   => $message
        );

        echo json_encode($response);
        // exit;
    }
   
    // update enrollment details of student
    public function EnrollmentStudentUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['admin_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);
        $enrollment_student_status = filter_smart($post_data['enrollment_student_status']);

        // print_r_custom($enrollment_student_status);

        $get_Enrolllment_Student_Details = $this->Enrollment_Model->getEnrollmentDetailsById($enrollment_id);

        // print_r_custom($get_Enrolllment_Student_Details);

        if(count($get_Enrolllment_Student_Details)){
            // if(empty($get_Enrolllment_Student_Details)){

            $table_name = "enrollment_master";

            $where = array( "enrollment_master_id" => $enrollment_id);

            $update_array = array(     
                "enrollment_status" => $enrollment_student_status,
            );

        $result= $this->Common_Model->updateTable("$table_name", $update_array, $where);
        
            if($result){
                $status = true;
                $res_message = "Student Enrollment details updated successfully.";
            }else{
                $status = false;
                $res_message = "Something went wrong!";
            }
        }
        else{
            $status = false;
            $res_message = "Student Enrollment does exists in records.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message,
            // 'data'=>$update_array,
            // 'id'=>$where
        );

        echo json_encode($response);
        exit;
    }

    // delete enrollment details of student
    public function DeleteEnrollmentStudent()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['admin_id'];

        $status = true;
        $message = "Enrollment of Student deleted successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);

        $del_enrollment = $this->Enrollment_Model->deleteEnrollmentById($enrollment_id);

        if($del_enrollment == false){
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