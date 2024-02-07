<?php
defined('BASEPATH') or exit('No direct script access allowed');

class PtMeetings extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Pt_Meetings_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index(){
        checkAdminLoginSession();

        addJs(array("admin/pt-meetings.js",));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $course_category_list = $this->Course_Category_Model->getAllCourseCategoryDetailsByStatus(1);
        $this->data['course_category_list'] = $course_category_list;

        $this->load->admintemplate('pt-meetings', $this->data);
    }

    public function AddPtMeetings()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $pt_meetings_title = filter_smart($post_data['pt_meetings_title']);
        $pt_meetings_description = filter_smart($post_data['pt_meetings_description']);
        $pt_meetings_date = filter_smart($post_data['pt_meetings_date']);
        $pt_meetings_time = filter_smart($post_data['pt_meetings_time']);

        $pt_meetings_date_time = date('Y-m-d H:i:s',strtotime($pt_meetings_date.' '.$pt_meetings_time));
        
        $table_name = "pt_meetings_master";

        $insert_array = array(
            "course_category_id"        => $course_category_id,
            "pt_meetings_title"         => $pt_meetings_title,
            "pt_meetings_description"   => $pt_meetings_description,
            "pt_meetings_date_time"     => $pt_meetings_date_time,
            "created_date"              => date('Y-m-d H:i:s'),
            "created_by"                => $userinfo_id,
        );

        $pt_meetings_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

        if($pt_meetings_master_id > 0){
            $status = true;
            $res_message = "Parent teacher meeting added successfully.";
            
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

    public function PtMeetingsListAjax()
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
            0=>'pt_meetings_master.pt_meetings_master_id',
            1=>'pt_meetings_master.course_category_id',
            2=>'pt_meetings_master.pt_meetings_title',
            3=>'pt_meetings_master.pt_meetings_date_time',
            4=>'pt_meetings_master.pt_meetings_status',
            5=>'pt_meetings_master.created_date',
            6=>'pt_meetings_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "  pt_meetings_master.pt_meetings_title like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Pt_Meetings_Model->countAllPtMeetingsList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Pt_Meetings_Model->listPtMeetingsQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['pt_meetings_master_id'] = $start;
            $nestedData['pt_meetings_title'] = $main['pt_meetings_title'];
            $nestedData['pt_meetings_date_time'] = date('d-m-Y h:ia', strtotime($main['pt_meetings_date_time']));
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $pt_meetings_master_id = $main['pt_meetings_master_id'];

            $pt_meetings_status = $main['pt_meetings_status'];
            $status_display = "";

            if($pt_meetings_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['pt_meetings_status'] = $status_display;

            $pt_meetings_date_time = $main['pt_meetings_date_time'];

            $pt_meetings_date = date('m/d/Y', strtotime($main['pt_meetings_date_time']));
            $pt_meetings_time = date('h:ia', strtotime($main['pt_meetings_date_time']));

            $course_category_id = $main['course_category_id'];
            $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsByMultipleId($course_category_id);
            $course_category_array = array();
            
            for($i=0; $i<count($course_category_list); $i++){
                array_push($course_category_array, $course_category_list[$i]['course_category_name']);
            }
            $nestedData['course_category_name'] = implode(', ',$course_category_array);

            $pt_meetings_description = $main['pt_meetings_description'];

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_pt_meetings' id='".$pt_meetings_master_id."' course_category_id='".$course_category_id."' pt_meetings_title='".$main['pt_meetings_title']."' pt_meetings_description='".$pt_meetings_description."' pt_meetings_date='".$pt_meetings_date."' pt_meetings_time='".$pt_meetings_time."'  pt_meetings_status='".$main['pt_meetings_status']."'><i class='fa fa-pencil'></i> Edit</a>";

            $notification_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm send_notification_pt_meetings' id='".$pt_meetings_master_id."' course_category_id='".$course_category_id."'><i class='fa fa-envelope'></i> Send Notification</a>";

            $action = "";
            $action .= $edit_button;

            if($pt_meetings_date_time >= date('Y-m-d H:i:s')){
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

    public function UpdatePtMeetings()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $pt_meetings_master_id = filter_smart($post_data['pt_meetings_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $pt_meetings_title = filter_smart($post_data['pt_meetings_title']);
        $pt_meetings_description = filter_smart($post_data['pt_meetings_description']);
        $pt_meetings_date = filter_smart($post_data['pt_meetings_date']);
        $pt_meetings_time = filter_smart($post_data['pt_meetings_time']);
        $pt_meetings_status = filter_smart($post_data['pt_meetings_status']);

        $pt_meetings_date_time = date('Y-m-d H:i:s',strtotime($pt_meetings_date.' '.$pt_meetings_time));

        $get_pt_meetings_Details = $this->Pt_Meetings_Model->getPtMeetingsById($pt_meetings_master_id);
        
        if(!empty($get_pt_meetings_Details)){

            $table_name = "pt_meetings_master";

            $where = array("pt_meetings_master_id" => $pt_meetings_master_id);

            $update_array = array(
                "course_category_id"        => $course_category_id,
                "pt_meetings_title"         => $pt_meetings_title,
                "pt_meetings_description"   => $pt_meetings_description,
                "pt_meetings_date_time"     => $pt_meetings_date_time,
                "pt_meetings_status"        => $pt_meetings_status,
                "updated_date"              => date('Y-m-d H:i:s'),
                "updated_by"                => $userinfo_id,
            );
            
            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $status = true;
            $res_message = "Parent teacher meeting details updated successfully.";
        }
        else{
            $status = false;
            $res_message = "Parent teacher meeting details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function PtMeetingsSendNotification()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $pt_meetings_master_id = filter_smart($post_data['pt_meetings_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);

        $pt_meetings_Details = $this->Pt_Meetings_Model->getPtMeetingsById($pt_meetings_master_id);
        
        if(!empty($pt_meetings_Details)){

            $pt_meetings_date_time = $pt_meetings_Details['pt_meetings_date_time'];
            $pt_meetings_date = date('d-m-Y', strtotime($pt_meetings_date_time));
            $pt_meetings_time = date('h:ia', strtotime($pt_meetings_date_time));

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
                            sendParentTeachersMeetingSMS($full_name, $contact, $pt_meetings_date, $pt_meetings_time);
                        }

                        //--- email notification
                        $message = "Dear ".$full_name.",<br><br>";
                        $message .= "A 'Parent-Teacher Meeting' has been scheduled for ".$pt_meetings_date." at ".$pt_meetings_time.".<br><br>";
                        $message .= "Requesting your parent(s) to attend this meeting.<br><br>";
                        $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                        $message .= "Thanks,<br> ChemCaliba";

                        if(IS_LIVE){
                            sendEmail($emailid, 'Parent Teacher Meeting - '.COMPANY_NAME, $message, "", "", '', '','');
                        }
                    }
                }

            }

            $status = true;
            $res_message = "Parent teacher meeting notification sent successfully.";
        }
        else{
            $status = false;
            $res_message = "Parent teacher meeting details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}