<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestSchedules extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Test_Schedules_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index(){
        checkAdminLoginSession();

        addJs(array("admin/test-schedules.js",));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $course_category_list = $this->Course_Category_Model->getAllCourseCategoryDetailsByStatus(1);
        $this->data['course_category_list'] = $course_category_list;

        $this->load->admintemplate('test-schedules', $this->data);
    }

    public function AddTestSchedules()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $test_schedule_title = filter_smart($post_data['test_schedule_title']);
        $test_schedule_link = filter_smart($post_data['test_schedule_link']);
        $test_schedule_date = filter_smart($post_data['test_schedule_date']);
        $test_schedule_time = filter_smart($post_data['test_schedule_time']);

        $test_schedule_date_time = date('Y-m-d H:i:s',strtotime($test_schedule_date.' '.$test_schedule_time));
        
        $table_name = "test_schedule_master";

        $insert_array = array(
            "course_category_id"        => $course_category_id,
            "test_schedule_title"       => $test_schedule_title,
            "test_schedule_link"        => $test_schedule_link,
            "test_schedule_date_time"   => $test_schedule_date_time,
            "created_date"              => date('Y-m-d H:i:s'),
            "created_by"                => $userinfo_id,
        );

        $test_schedule_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

        if($test_schedule_master_id > 0){
            $status = true;
            $res_message = "Test schedule added successfully.";
            
        }
        else{
            $status = false;
            $res_message = "Something went wrong! Please try again... ";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function TestSchedulesListAjax()
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
            0=>'test_schedule_master.test_schedule_master_id',
            1=>'test_schedule_master.course_category_id',
            2=>'test_schedule_master.test_schedule_title',
            3=>'test_schedule_master.test_schedule_link',
            4=>'test_schedule_master.test_schedule_date_time',
            5=>'test_schedule_master.test_schedule_status',
            6=>'test_schedule_master.created_date',
            7=>'test_schedule_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "  test_schedule_master.test_schedule_title like '%$searchTerm%'  or  test_schedule_master.test_schedule_link like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Test_Schedules_Model->countAllTestSchedulesList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Test_Schedules_Model->listTestSchedulesQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['test_schedule_master_id'] = $start;
            $nestedData['test_schedule_title'] = $main['test_schedule_title'];
            $nestedData['test_schedule_link'] = $main['test_schedule_link'];
            $nestedData['test_schedule_date_time'] = date('d-m-Y h:ia', strtotime($main['test_schedule_date_time']));
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $test_schedule_master_id = $main['test_schedule_master_id'];

            $test_schedule_link = $main['test_schedule_link'];
            $test_schedule_link_display = "<a href='".$test_schedule_link."' target='_blank'>".$test_schedule_link."</a>";
            $nestedData['test_schedule_link'] = $test_schedule_link_display;
            
            $test_schedule_status = $main['test_schedule_status'];
            $status_display = "";

            if($test_schedule_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['test_schedule_status'] = $status_display;

            $test_schedule_date_time = $main['test_schedule_date_time'];

            $test_schedule_date = date('m/d/Y', strtotime($main['test_schedule_date_time']));
            $test_schedule_time = date('h:ia', strtotime($main['test_schedule_date_time']));

            $course_category_id = $main['course_category_id'];
            $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsByMultipleId($course_category_id);
            $course_category_array = array();
            
            for($i=0; $i<count($course_category_list); $i++){
                array_push($course_category_array, $course_category_list[$i]['course_category_name']);
            }
            $nestedData['course_category_name'] = implode(', ',$course_category_array);

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_test_schedules' id='".$test_schedule_master_id."' course_category_id='".$course_category_id."' test_schedule_title='".$main['test_schedule_title']."' test_schedule_link='".$main['test_schedule_link']."' test_schedule_date='".$test_schedule_date."' test_schedule_time='".$test_schedule_time."'  test_schedule_status='".$main['test_schedule_status']."'><i class='fa fa-pencil'></i> Edit</a>";

            $notification_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm send_notification_test_schedule' id='".$test_schedule_master_id."' course_category_id='".$course_category_id."'><i class='fa fa-envelope'></i> Send Notification</a>";

            $action = "";
            $action .= $edit_button." &nbsp;&nbsp;".$notification_button;

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

    public function UpdateTestSchedules()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $test_schedule_master_id = filter_smart($post_data['test_schedule_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $test_schedule_title = filter_smart($post_data['test_schedule_title']);
        $test_schedule_link = filter_smart($post_data['test_schedule_link']);
        $test_schedule_date = filter_smart($post_data['test_schedule_date']);
        $test_schedule_time = filter_smart($post_data['test_schedule_time']);
        $test_schedule_status = filter_smart($post_data['test_schedule_status']);

        $test_schedule_date_time = date('Y-m-d H:i:s',strtotime($test_schedule_date.' '.$test_schedule_time));

        $get_test_schedule_Details = $this->Test_Schedules_Model->getTestSchedulesById($test_schedule_master_id);
        
        if(!empty($get_test_schedule_Details)){

            $table_name = "test_schedule_master";

            $where = array("test_schedule_master_id" => $test_schedule_master_id);

            $update_array = array(
                "course_category_id"        => $course_category_id,
                "test_schedule_title"       => $test_schedule_title,
                "test_schedule_link"        => $test_schedule_link,
                "test_schedule_date_time"   => $test_schedule_date_time,
                "test_schedule_status"      => $test_schedule_status,
                "updated_date"              => date('Y-m-d H:i:s'),
                "updated_by"                => $userinfo_id,
            );
            
            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $status = true;
            $res_message = "Test schedule updated successfully.";
        }
        else{
            $status = false;
            $res_message = "Test schedule details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function TestSchedulesSendNotification()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $test_schedule_master_id = filter_smart($post_data['test_schedule_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);

        $Test_schedule_Details = $this->Test_Schedules_Model->getTestSchedulesById($test_schedule_master_id);
        
        if(!empty($Test_schedule_Details)){

            $test_schedule_date_time = $Test_schedule_Details['test_schedule_date_time'];
            $test_schedule_date_time = date('d-m-Y H:ia', strtotime($test_schedule_date_time));
            
            $Enrolled_Students = $this->Enrollment_Model->getEnrollmentDetailsByCourseCategoryId($course_category_id);
            
            if(count($Enrolled_Students)>0){
                
                for($i=0; $i<count($Enrolled_Students); $i++){
                    $student_details = $this->Student_Details_Model->getStudentDetailsById($Enrolled_Students[$i]['student_id']);

                    if($student_details){
                        $full_name = "";
                        $emailid = "";
                        $contact = "";

                        $full_name = $student_details['full_name'];
                        $emailid = $student_details['emailid'];
                        $contact = $student_details['contact'];

                        //--- sms notification
                        if(IS_LIVE){
                            sendTestScheduleSMS($full_name, $contact, $test_schedule_date_time);
                        }

                        //--- email notification
                        $message = "Dear ".$full_name.",<br><br>";

                        $message .= "Your TEST has been scheduled for ".$test_schedule_date_time." !<br><br>";

                        $message .= "Please login to your dashboard for further details.<br><br>";
                        
                        $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                        $message .= "Thanks,<br> MauryaEdu";

                        if(IS_LIVE){
                            sendEmail($emailid, 'Test Schedule - '.COMPANY_NAME, $message, "", "", '', '','');
                        }
                    }
                }

            }

            $status = true;
            $res_message = "Test schedule notification sent successfully.";
        }
        else{
            $status = false;
            $res_message = "Test schedule details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}