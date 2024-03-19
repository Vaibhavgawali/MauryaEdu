<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HolidayInformation extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Holiday_Information_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index(){
        checkAdminLoginSession();

        addJs(array("admin/holiday-information.js",));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $course_category_list = $this->Course_Category_Model->getAllCourseCategoryDetailsByStatus(1);
        $this->data['course_category_list'] = $course_category_list;

        $this->load->admintemplate('holiday-information', $this->data);
    }

    public function AddHolidayInformation()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $holiday_information_title = filter_smart($post_data['holiday_information_title']);
        $holiday_information_description = filter_smart($post_data['holiday_information_description']);
        $holiday_information_from_date = filter_smart($post_data['holiday_information_from_date']);
        $holiday_information_to_date = filter_smart($post_data['holiday_information_to_date']);

        $holiday_information_from_date = date('Y-m-d', strtotime($holiday_information_from_date));
        $holiday_information_to_date = date('Y-m-d', strtotime($holiday_information_to_date));

        $table_name = "holiday_information_master";

        $insert_array = array(
            "course_category_id"                => $course_category_id,
            "holiday_information_title"         => $holiday_information_title,
            "holiday_information_description"   => $holiday_information_description,
            "holiday_information_from_date"     => $holiday_information_from_date,
            "holiday_information_to_date"       => $holiday_information_to_date,
            "created_date"                      => date('Y-m-d H:i:s'),
            "created_by"                        => $userinfo_id,
        );

        $holiday_information_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

        if($holiday_information_master_id > 0){
            $status = true;
            $res_message = "Holiday information added successfully.";
            
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

    public function HolidayInformationListAjax()
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
            0=>'holiday_information_master.holiday_information_master_id',
            1=>'holiday_information_master.course_category_id',
            2=>'holiday_information_master.holiday_information_title',
            3=>'holiday_information_master.holiday_information_from_date',
            3=>'holiday_information_master.holiday_information_to_date',
            4=>'holiday_information_master.holiday_information_status',
            5=>'holiday_information_master.created_date',
            6=>'holiday_information_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "  holiday_information_master.holiday_information_title like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Holiday_Information_Model->countAllHolidayInformationList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Holiday_Information_Model->listHolidayInformationQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['holiday_information_master_id'] = $start;
            $nestedData['holiday_information_title'] = $main['holiday_information_title'];
            $nestedData['holiday_information_from_date'] = date('d-m-Y', strtotime($main['holiday_information_from_date']));
            $nestedData['holiday_information_to_date'] = date('d-m-Y', strtotime($main['holiday_information_to_date']));
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $holiday_information_master_id = $main['holiday_information_master_id'];

            $holiday_information_status = $main['holiday_information_status'];
            $status_display = "";

            if($holiday_information_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['holiday_information_status'] = $status_display;

            $holiday_information_from_date_db = $main['holiday_information_from_date'];
            $holiday_information_to_date_db = $main['holiday_information_to_date'];

            $holiday_information_from_date = date('m/d/Y', strtotime($main['holiday_information_from_date']));
            $holiday_information_to_date = date('m/d/Y', strtotime($main['holiday_information_to_date']));
            

            $course_category_id = $main['course_category_id'];
            $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsByMultipleId($course_category_id);
            $course_category_array = array();
            
            for($i=0; $i<count($course_category_list); $i++){
                array_push($course_category_array, $course_category_list[$i]['course_category_name']);
            }
            $nestedData['course_category_name'] = implode(', ',$course_category_array);

            $holiday_information_description = $main['holiday_information_description'];

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_holiday_information' id='".$holiday_information_master_id."' course_category_id='".$course_category_id."' holiday_information_title='".$main['holiday_information_title']."' holiday_information_description='".$holiday_information_description."' holiday_information_from_date='".$holiday_information_from_date."' holiday_information_to_date='".$holiday_information_to_date."'  holiday_information_status='".$main['holiday_information_status']."'><i class='fa fa-pencil'></i> Edit</a>";

            $notification_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm send_notification_holiday_information' id='".$holiday_information_master_id."' course_category_id='".$course_category_id."'><i class='fa fa-envelope'></i> Send Notification</a>";

            $action = "";
            $action .= $edit_button;

            if($holiday_information_from_date_db >= date('Y-m-d')){
                $action .= " &nbsp;&nbsp;".$notification_button;
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

    public function UpdateHolidayInformation()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $holiday_information_master_id = filter_smart($post_data['holiday_information_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $holiday_information_title = filter_smart($post_data['holiday_information_title']);
        $holiday_information_description = filter_smart($post_data['holiday_information_description']);
        $holiday_information_from_date = filter_smart($post_data['holiday_information_from_date']);
        $holiday_information_to_date = filter_smart($post_data['holiday_information_to_date']);
        $holiday_information_status = filter_smart($post_data['holiday_information_status']);

        $holiday_information_from_date = date('Y-m-d', strtotime($holiday_information_from_date));
        $holiday_information_to_date = date('Y-m-d', strtotime($holiday_information_to_date));

        $get_holiday_information_Details = $this->Holiday_Information_Model->getHolidayInformationById($holiday_information_master_id);
        
        if(!empty($get_holiday_information_Details)){

            $table_name = "holiday_information_master";

            $where = array("holiday_information_master_id" => $holiday_information_master_id);

            $update_array = array(
                "course_category_id"                => $course_category_id,
                "holiday_information_title"         => $holiday_information_title,
                "holiday_information_description"   => $holiday_information_description,
                "holiday_information_from_date"     => $holiday_information_from_date,
                "holiday_information_to_date"       => $holiday_information_to_date,
                "holiday_information_status"        => $holiday_information_status,
                "updated_date"                      => date('Y-m-d H:i:s'),
                "updated_by"                        => $userinfo_id,
            );
            
            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $status = true;
            $res_message = "Holiday information details updated successfully.";
        }
        else{
            $status = false;
            $res_message = "Holiday information details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function HolidayInformationSendNotification()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $holiday_information_master_id = filter_smart($post_data['holiday_information_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);

        $holiday_information_Details = $this->Holiday_Information_Model->getHolidayInformationById($holiday_information_master_id);
        
        if(!empty($holiday_information_Details)){

            $holiday_information_title = $holiday_information_Details['holiday_information_title'];
            
            $holiday_information_from_date = $holiday_information_Details['holiday_information_from_date'];
            $holiday_information_from_date = date('d-m-Y', strtotime($holiday_information_from_date));

            $holiday_information_to_date = $holiday_information_Details['holiday_information_to_date'];
            $holiday_information_to_date = date('d-m-Y', strtotime($holiday_information_to_date));

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
                            sendHolidayInformationSMS($full_name, $contact, $holiday_information_from_date, $holiday_information_to_date, $holiday_information_title);
                        }

                        //--- email notification
                        $message = "Dear ".$full_name.",<br><br>";

                        if($holiday_information_from_date == $holiday_information_to_date){
                            $message .= "On account of ".$holiday_information_title." , Live Classes will remain off on ".$holiday_information_from_date."...<br><br>";
                        }
                        else{
                            $message .= "On account of ".$holiday_information_title." , Live Classes will remain off from ".$holiday_information_from_date." to ".$holiday_information_to_date."...<br><br>";
                        }
                        
                        $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                        $message .= "Thanks,<br> MauryaEdu";

                        if(IS_LIVE){
                            sendEmail($emailid, 'Holiday Information - '.COMPANY_NAME, $message, "", "", '', '','');
                        }
                    }
                }

            }

            $status = true;
            $res_message = "Holiday information notification sent successfully.";
        }
        else{
            $status = false;
            $res_message = "Holiday information details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}