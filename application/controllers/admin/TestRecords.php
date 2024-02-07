<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestRecords extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Test_Records_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index(){
        checkAdminLoginSession();

        addJs(array("admin/test-records.js",));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $student_list = $this->Student_Details_Model->getStudentDetailsByStatus(2);
        $this->data['student_list'] = $student_list;

        $this->load->admintemplate('test-records', $this->data);
    }

    public function AddTestRecords()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $student_id = filter_smart($post_data['student_id']);
        $test_date = filter_smart($post_data['test_date']);
        $is_attempted = filter_smart($post_data['is_attempted']);
        $marks_obtained = filter_smart($post_data['marks_obtained']);
        $total_marks = filter_smart($post_data['total_marks']);
        $no_of_right_questions = filter_smart($post_data['no_of_right_questions']);
        $no_of_wrong_questions = filter_smart($post_data['no_of_wrong_questions']);

        $test_date = date('Y-m-d',strtotime($test_date));
        
        $get_student_Details = $this->Student_Details_Model->getStudentDetailsById($student_id);
        
        if(!empty($get_student_Details)){

            $table_name = "test_records_master";

            $insert_array = array(
                "student_id"                => $student_id,
                "test_date"                 => $test_date,
                "is_attempted"              => $is_attempted,
                "marks_obtained"            => $marks_obtained,
                "total_marks"               => $total_marks,
                "no_of_right_questions"     => $no_of_right_questions,
                "no_of_wrong_questions"     => $no_of_wrong_questions,
                "created_date"              => date('Y-m-d H:i:s'),
                "created_by"                => $userinfo_id,
            );

            $test_records_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($test_records_master_id > 0){
                $status = true;
                $res_message = "Student test record added successfully.";
                
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Student details not found in records...";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function TestRecordsListAjax()
    {
        $login_detail = $this->session->userdata('login_detail');
        //print_r_custom($login_detail,1);

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
            0=>'test_records_master.test_records_master_id',
            1=>'student_master.full_name',
            2=>'test_records_master.test_date',
            3=>'test_records_master.is_attempted',
            4=>'test_records_master.marks_obtained',
            5=>'test_records_master.total_marks',
            6=>'test_records_master.no_of_right_questions',
            7=>'test_records_master.no_of_wrong_questions',
            8=>'test_records_master.test_records_status',
            9=>'test_records_master.created_date',
            10=>'test_records_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " student_master.full_name like '%$searchTerm%'  or  test_records_master.marks_obtained like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Test_Records_Model->countAllTestRecordsList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Test_Records_Model->listTestRecordsQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['test_records_master_id'] = $start;
            $nestedData['full_name'] = $main['full_name'];
            $nestedData['test_date'] = date('d-m-Y', strtotime($main['test_date']));
            $nestedData['marks_obtained'] = $main['marks_obtained'];
            $nestedData['total_marks'] = $main['total_marks'];
            $nestedData['no_of_right_questions'] = $main['no_of_right_questions'];
            $nestedData['no_of_wrong_questions'] = $main['no_of_wrong_questions'];
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $test_records_master_id = $main['test_records_master_id'];
            
            $test_records_status = $main['test_records_status'];
            $status_display = "";

            if($test_records_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['test_records_status'] = $status_display;

            $is_attempted = $main['is_attempted'];
            $is_attempted_display = "";

            if($is_attempted == 1){
                $is_attempted_display = "<span class='badge badge-success'>Yes</span>";
            }
            else{
                $is_attempted_display = "<span class='badge badge-danger'>No</span>";
            }

            $nestedData['is_attempted'] = $is_attempted_display;

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_test_records' id='".$test_records_master_id."' student_id='".$main['student_id']."' test_date='".date('m/d/Y', strtotime($main['test_date']))."' is_attempted='".$main['is_attempted']."' marks_obtained='".$main['marks_obtained']."' total_marks='".$main['total_marks']."' no_of_right_questions='".$main['no_of_right_questions']."' no_of_wrong_questions='".$main['no_of_wrong_questions']."' test_records_status='".$main['test_records_status']."'><i class='fa fa-pencil'></i> Edit</a>";
            
            $notification_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm send_notification' id='".$test_records_master_id."' student_id='".$main['student_id']."'><i class='fa fa-envelope'></i> Send Notification</a>";

            $action = "";
            $action .= $edit_button."&nbsp;&nbsp;&nbsp;".$notification_button;

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

    public function UpdateTestRecords()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $test_records_master_id = filter_smart($post_data['test_records_master_id']);
        $student_id = filter_smart($post_data['student_id']);
        $test_date = filter_smart($post_data['test_date']);
        $is_attempted = filter_smart($post_data['is_attempted']);
        $marks_obtained = filter_smart($post_data['marks_obtained']);
        $total_marks = filter_smart($post_data['total_marks']);
        $no_of_right_questions = filter_smart($post_data['no_of_right_questions']);
        $no_of_wrong_questions = filter_smart($post_data['no_of_wrong_questions']);
        $test_records_status = filter_smart($post_data['test_records_status']);

        $test_date = date('Y-m-d',strtotime($test_date));

        $get_test_record_Details = $this->Test_Records_Model->getTestRecordsById($test_records_master_id);
        
        if(!empty($get_test_record_Details)){

            $get_student_Details = $this->Student_Details_Model->getStudentDetailsById($student_id);
        
            if(!empty($get_student_Details)){

                $table_name = "test_records_master";

                $where = array("test_records_master_id" => $test_records_master_id);

                $update_array = array(
                    "student_id"                => $student_id,
                    "test_date"                 => $test_date,
                    "is_attempted"              => $is_attempted,
                    "marks_obtained"            => $marks_obtained,
                    "total_marks"               => $total_marks,
                    "no_of_right_questions"     => $no_of_right_questions,
                    "no_of_wrong_questions"     => $no_of_wrong_questions,
                    "test_records_status"       => $test_records_status,
                    "updated_date"              => date('Y-m-d H:i:s'),
                    "updated_by"                => $userinfo_id,
                );

                $this->Common_Model->updateTable($table_name, $update_array, $where);

                $status = true;
                $res_message = "Student test record updated successfully.";
                
            }
            else{
                $status = false;
                $res_message = "Student details not found in records...";
            }
        }
        else{
            $status = false;
            $res_message = "Test records details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function SendTestResultNotification()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $test_records_master_id = filter_smart($post_data['test_records_master_id']);
        $student_id = filter_smart($post_data['student_id']);

        $get_test_record_Details = $this->Test_Records_Model->getTestRecordsById($test_records_master_id);
        
        if(!empty($get_test_record_Details)){

            $test_date = $get_test_record_Details['test_date'];
            $is_attempted = $get_test_record_Details['is_attempted'];
            $marks_obtained = $get_test_record_Details['marks_obtained'];
            $total_marks = $get_test_record_Details['total_marks'];
            $no_of_right_questions = $get_test_record_Details['no_of_right_questions'];
            $no_of_wrong_questions = $get_test_record_Details['no_of_wrong_questions'];

            $test_date = date('d M Y',strtotime($test_date));

            $is_attempted_text = "";
            if($is_attempted == '1' || $is_attempted == 1){
                $is_attempted_text = "<b style='color:green;'>Yes</b>";
            }
            else{
                $is_attempted_text = "<b style='color:red;'>No</b>";
            }
            
            $get_student_Details = $this->Student_Details_Model->getStudentDetailsById($student_id);

            if(!empty($get_student_Details)){

                $full_name = $get_student_Details['full_name'];
                $emailid = $get_student_Details['emailid'];
                $contact = $get_student_Details['contact'];

                //--- sms notification
                if(IS_LIVE){
                    sendTestResultSMS($full_name, $contact, $marks_obtained."/".$total_marks, $test_date);
                }

                //--- email notification
                $message = "Dear ".$full_name.",<br><br>";
                $message .= "You have scored ".$marks_obtained."/".$total_marks." in a TEST conducted on ".$test_date."<br><br>";
                $message .= "Please find below test result.<br><br>";
                $message .= "<br><br>";
                $message .= "<table border='1' cellpadding='5' cellspacing='0'>";
                $message .="<tr><th colspan='9' align='center' bgcolor='#d9e6f0'>Test Result Details</th></tr>";
                $message .="<tr><th align='left'>Test Date</th><td colspan='8'>".$test_date."</td></tr>";
                $message .="<tr><th align='left'>Test Attempted</th><td colspan='8'>".$is_attempted_text."</td></tr>";
                $message .="<tr><th align='left'>Marks Obtained</th><td colspan='8'>".$marks_obtained."</td></tr>";
                $message .="<tr><th align='left'>Total Marks</th><td colspan='8'>".$total_marks."</td></tr>";
                $message .="<tr><th align='left'>Total Right Questions</th><td colspan='8'>".$no_of_right_questions."</td></tr>";
                $message .="<tr><th align='left'>Total Wrong Questions</th><td colspan='8'>".$no_of_wrong_questions."</td></tr>";
                $message .= "</table><br><br><br>";
                $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                $message .= "Thanks,<br> ChemCaliba";

                if(IS_LIVE){
                    sendEmail($emailid, 'Test Result - '.COMPANY_NAME, $message, "", "", '', '','');
                }

                $status = true;
                $res_message = "Student test result notification sent successfully.";
                
            }
            else{
                $status = false;
                $res_message = "Student details not found in records...";
            }
        }
        else{
            $status = false;
            $res_message = "Test records details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}