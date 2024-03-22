<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Student/Register_Model');
        $this->load->model('Student/Login_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
        $this->load->model('Course_Model');
        $this->load->model('Common/Test_Records_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->model('Common/Test_Schedules_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Announcements_Model');
        $this->load->model('Common/Pt_Meetings_Model');
        $this->load->model('Common/Holiday_Information_Model');
        $this->load->model('RazorPay_Modal');
    }

    public function register()
    {
        $status = false;
        $res_message = "Something went wrong. Please try again.";

        $post_data = $this->input->post();

        //extract($post_data);
        $full_name = isset($post_data['full_name']) ? filter_smart($post_data['full_name']) : '';
        $emailid = isset($post_data['emailid']) ? filter_smart($post_data['emailid']) : '';
        $contact = isset($post_data['contact']) ? filter_smart($post_data['contact']) : '';

        if($full_name != '' && $emailid != '' && $contact != '')
        {        
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
                    $message .= "Please click the below link & get the access, <br><br>";
                    $message .= $verificationLink;
                    $message .= "<br><br>If you are unable to click on above link then just copy above link & paste it in your browser.<br>";
                    $message .= "<br><hr><br><br>";
                    $message .= "Please use below details to login to your account.<br><br><br>";
                    $message .= "Login Url: <a href=".base_url()."student/login>".base_url()."student/login</a> <br>";
                    $message .= "Email ID: ".$emailid." <br>";
                    $message .= "Password : ".$password_text." <br><br><br>";
                    $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                    $message .= "Thanks,<br>MauryaEdu";

                    if(IS_LIVE){
                        sendEmail($emailid, 'Registration Details - '.COMPANY_NAME, $message, "", "", '', '','');
                    }

                    $status = true;
                    $res_message = "Registered successfully.<br><br>Login details & Verification email sent on your email & contact number. Kindly verify your email address to login to your account.";

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
        }
        else
        {
            $status = false;
            $res_message = "Please enter full name, emailid & contact number.";
        }    
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function login()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $emailid = isset($post_data['emailid']) ?  filter_smart($post_data['emailid']): '' ;
        $password = isset($post_data['password']) ?  filter_smart($post_data['password']): '' ;
        
        if($emailid != '' && $password != '')
        {
            $password = hash('sha512', $password);

            $student_info = $this->Login_Model->checkEmailIdExistsOrNot($emailid);

            if(!empty($student_info))
            {
                $full_name = $student_info['full_name'];
                $student_id = $student_info['student_id'];
                $contact = $student_info['contact'];
                $status = $student_info['status'];
                
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
                    $check_student_login = $this->Login_Model->checkStudentLogin($emailid, $password);
                    
                    if(!empty($check_student_login))
                    {
                        $this->data['result']['status'] = true;
                        $this->data['result']['message'] = "Successfully Login";
                        $this->data['result']['student_id'] = $student_id ;
                        $this->data['result']['full_name'] = $full_name ;
                        $this->data['result']['emailid'] = $emailid ;
                        $this->data['result']['contact'] = $contact ;

                        // $this->Login_Model->addStudentLoginData($check_student_login);  //set shop session
                    }
                    else{
                        $check_student_login_temp = $this->Login_Model->checkStudentLoginWithTempPassword($emailid, $password);
                        
                        if(!empty($check_student_login_temp))
                        {
                            $temp_password_created_on = $check_student_login_temp['temp_password_created_on'];

                            if( strtotime($temp_password_created_on) >= strtotime(date('Y-m-d H:i:s')) ){

                                $this->data['result']['status'] = true;
                                $this->data['result']['message'] = "Successfully Login";
                                $this->data['result']['student_id'] = $student_id ;
                                $this->data['result']['full_name'] = $full_name ;
                                $this->data['result']['emailid'] = $emailid ;
                                $this->data['result']['contact'] = $contact ;

                                // $this->Login_Model->addStudentLoginData($check_student_login_temp);  //set shop session
                            }
                            else{
                                $this->data['result']['status'] = false;
                                $this->data['result']['message'] = "<b>ERROR! </b>Your temporary password was expired. Try forgot password now.";
                            }
                        }
                        else{
                            $this->data['result']['status'] = false;
                            $this->data['result']['message'] = "<b>ERROR! </b>Invalid Login";
                        }
                    }
                }
                
            }
            else
            {
                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>INVALID LOGIN! </b>Please try again.";
            }    
        }
        else
        {
            $this->data['result']['status'] = false;
            $this->data['result']['message'] = "Email id & password is mandatory.";
        }

        echo json_encode($this->data['result']);
    }

    public function courses_list()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : '';
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : '';
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : 10;
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : 1;
        $offset = ($page_num - 1) * $limit;

        if($student_id != '' && $emailid != '')
        {
            // $courseData = array();
            $pagination = array('offset' => $offset, 'limit' => $limit );

            $courses = $this->Course_Model->loadCourses($pagination);

            // $login_detail = $this->session->userdata('student_login_detail');
            $login_detail = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($login_detail)
            {    
                for($i=0;$i<count($courses);$i++)
                {
                    $check_if_already_bought = $this->Course_Model->CheckCourseIfAlreadyBought($student_id, $courses[$i]['course_master_id']);
                    
                    if(count($check_if_already_bought) > 0)
                    {
                        $courses[$i]['is_already_bought'] = true;
                    }
                    else
                    {
                        $courses[$i]['is_already_bought'] = false;
                    }

                    //---- check course is expired or not
                    $course_end_date = $courses[$i]['course_end_date'];
                    $courses[$i]['is_course_expired'] = false;

                    if($course_end_date==NULL || $course_end_date=='0000-00-00'){
                        $courses[$i]['is_course_expired'] = true;
                    }
                    else
                    if(strtotime(date('Y-m-d')) > strtotime($course_end_date)){
                        $courses[$i]['is_course_expired'] = true;
                    }
                }

                $totalCourses =  $this->Course_Model->totalCourses();
                $totalCourses = $totalCourses['total'];
                // print_r($totalCourses);

                if($courses)
                {
                    $response = array(
                                'status' => true,
                                'courseData' => $courses,
                                'remaining_course' => $totalCourses - $limit * $page_num, 
                                'message' => 'Course data found',
                                'is_logged_in' => 'Yes'
                            );
                }
                else
                {
                    $response = array('status' => false, 'message' => 'Course data not found', 'remaining_course' => 0);
                }
            }
            else
            {
                $response = array('status' => false, 'message' => 'Student details not found.');
            }
        }
        else
        {
            $response = array('status' => false, 'message' => 'Student id or email id is missing.');
        }

        echo json_encode($response);
    }

    public function enrolled_course_list()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : '' ; 
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : '' ; 
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : '' ; 
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : '1' ; 
        $offset = ($page_num - 1) * $limit;

        if($student_id != '' && $emailid != '')
        {   
            // $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);
            $studentInfo =  $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($studentInfo)
            {
                $where = " 1=1 AND em.student_id = '".$student_id."' ";

                // $courseData = array();
                $pagination = array('offset' => $offset, 'limit' => $limit );

                $courses = $this->Course_Model->loadEnrolledCourses($pagination,$where);
                $totalCourses =  $this->Course_Model->totalEnrolledCourses($where);
                // print_r_custom($courses,1);
                $totalCourses = $totalCourses['total'];

                if($courses)
                {
                    for($i=0; $i<count($courses); $i++)
                    {
                        $valid_upto = "";
                        $valid_upto = $courses[$i]['valid_upto'];
                        $validity = date('d-m-Y H:i', strtotime($valid_upto));

                        $courses[$i]['course_validity'] = $validity;

                        $created_date = "";
                        $created_date = $courses[$i]['enrollment_date'];
                        $created_date = date('d-m-Y H:i', strtotime($created_date));

                        $courses[$i]['course_enrollment_date'] = $created_date;
                    }
                    $response = array(
                                'status' => true,
                                'courseData' => $courses,
                                'remaining_course' => $totalCourses - $limit * $page_num, 
                                'message' => 'Course data found'
                            );
                }
                else
                {
                    $response = array('status' => false, 'message' => 'Course data not found', 'remaining_course' => 0);
                }
            }
            else
            {
                $response = array('status' => false, 'message' => 'Student details not found.');
            }   
        }
        else
        {
            $response = array('status' => false, 'message' => 'Student id or email id is missing.');
        }     

        echo json_encode($response);
    }

    public function view_course_details()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : '';
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : '';
        $course_id  = isset($requestData['course_id']) ? $requestData['course_id'] : '';
        $is_bought  = isset($requestData['is_bought']) ? $requestData['is_bought'] : 0;


        if($student_id != '' && $emailid != '' && $course_id != '' && $is_bought != '')
        {
            $studentInfo =  $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();
            
            if($studentInfo)
            {
                $response['studentInfo'] = $studentInfo;

                if($is_bought)
                {
                    $course_details = $this->Course_Model->getEnrolledCourseDetailsById($student_id,$course_id);
                }
                else
                {
                    $course_details = $this->Course_Model->getCourseDetailsById($course_id);  
                }

                if($course_details)
                {
                    //---- check course is expired or not
                    $course_end_date = $course_details['course_end_date'];
                    $course_details['is_course_expired'] = false;
                    $course_details['course_img_url'] = base_url()."uploads/course/".$course_id."/course-image/".$course_details['course_image'];

                    if($course_end_date==NULL || $course_end_date=='0000-00-00'){
                        $course_details['is_course_expired'] = true;
                    }
                    else
                    if(strtotime(date('Y-m-d')) > strtotime($course_end_date)){
                        $course_details['is_course_expired'] = true;
                    }

                    $response['course_details'] = $course_details;

                    //course videos
                    $course_video_details = $this->Course_Model->getCourseVideoDetails($course_details['course_master_id']);
                    $response['course_video_details'] = count($course_video_details) > 0 ? $course_video_details : array();

                    //course chapters
                    $course_chapter_details = $this->Course_Model->getCourseChapterDetails($course_details['course_master_id']);
                    
                    //chapter documents
                    if(count($course_chapter_details)>0)
                    {
                        for($i=0;$i<count($course_chapter_details);$i++)
                        {
                            //chapter documents
                            $course_chapter_doc_details = $this->Course_Model->getCourseChapterDocDetails($course_chapter_details[$i]->chapter_master_id);

                            $course_chapter_details[$i]->chapter_doc = count($course_chapter_doc_details) > 0 ? $course_chapter_doc_details : array();                            

                            //sub chapter
                            $course_subchapter_details = $this->Course_Model->getCourseSubChapterDetails($course_chapter_details[$i]->chapter_master_id);
                            $course_chapter_details[$i]->sub_chapters = count($course_subchapter_details) > 0 ? $course_subchapter_details : array();

                            //sub chapter documents
                            if(count($course_subchapter_details) > 0)
                            {
                                for($p=0;$p<count($course_subchapter_details);$p++)
                                {
                                    $course_sub_chapter_doc_details = $this->Course_Model->getCourseSubChapterDocDetails($course_subchapter_details[$p]->sub_chapter_master_id);
                                    $course_subchapter_details[$p]->sub_chapter_doc = count($course_sub_chapter_doc_details) > 0 ? $course_sub_chapter_doc_details : array();   
                                }
                            }
                        }                        
                    }
                    $response['course_chapter_details'] = count($course_chapter_details) > 0 ? $course_chapter_details : array();

                    $response = array(
                                    'status' => true, 
                                    'message' => 'Course details found',
                                    'student_info' => $studentInfo,
                                    'course_details' => $course_details,
                                    'course_video_details' => $course_video_details,
                                    'course_chapter_details' => $course_chapter_details,
                                    'chapter_doc_url' => base_url()."uploads/chapter/chapter_master_id/chapter-documents/chapter_document_master_id/document_file",
                                    'sub_chapter_doc_url' => base_url()."uploads/sub-chapter/sub_chapter_master_id/sub-chapter-documents/sub_chapter_document_master_id/document_file",
                                    
                                );
                                
                }
                else
                {
                    $response = array('status' => false, 'message' => 'Course details not found.');
                }
            }
            else
            {
                $response = array('status' => false, 'message' => 'Invalid Student details.');
            }    
        }
        else
        {
            $response = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($response);
    }

    public function test_results()
    {        
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : 10;
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : 1;
        $offset = ($page_num - 1) * $limit;
        $searchTerm = isset($requestData['searchTerm']) ? $requestData['searchTerm'] : '';

        if($student_id != '' && $emailid != '')
        {

            // $courseData = array();
            $pagination = array('offset' => $offset, 'limit' => $limit );

            $where = " 1=1 AND test_records_master.student_id='".$student_id."' AND test_records_master.test_records_status='1' ";

            /*Saerch common search*/
            if (!empty($searchTerm)) {
                $where .= "AND (";
                $where .= " test_records_master.marks_obtained like '%$searchTerm%' ";
                $where .= ") ";
            }

            $login_detail = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($login_detail)
            {
                /*Count Table result*/
                $total_count_array = $this->Test_Records_Model->countAllTestRecordsList($where);
                $totalData = $total_count_array->total;

                /*Total Filter Record and fetch data*/
                $order_by = 'test_records_master.test_records_master_id' ;
                $start = $offset;
                $length = $limit;
                $order_dir = 'DESC';

                if(!empty($searchTerm))
                {
                    $start = 0;
                    $length = $totalData;
                }

                $list_array = $this->Test_Records_Model->listTestRecordsQuery($where, $order_by, $start, $length, $order_dir);
                $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
                $result = $list_array['Result'];
                $data = array();

                foreach ($result as $main) {
                    $start++;

                    $nestedData = array();
                    
                    $nestedData['test_records_master_id'] = $start;
                    $nestedData['test_date'] = date('d-m-Y', strtotime($main['test_date']));
                    $nestedData['marks_obtained'] = $main['marks_obtained'];
                    $nestedData['total_marks'] = $main['total_marks'];
                    $nestedData['no_of_right_questions'] = $main['no_of_right_questions'];
                    $nestedData['no_of_wrong_questions'] = $main['no_of_wrong_questions'];
                    $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));

                    $is_attempted = $main['is_attempted'];
                    $is_attempted_display = "";

                    if($is_attempted == 1){
                        $is_attempted_display = "<span class='badge badge-success'>Yes</span>";
                    }
                    else{
                        $is_attempted_display = "<span class='badge badge-danger'>No</span>";
                    }

                    $nestedData['is_attempted'] = $is_attempted_display;

                    $data[] = $nestedData;
                }            

                if($totalData > 0)
                {
                    $json_data = array(
                        "status" => true,
                        "message" => "Test results data found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
                else
                {
                    $json_data = array(
                        "status" => false,
                        "message" => "Test results data not found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
            }
            else 
            {
                $json_data = array('status' => false, 'message' => 'Student details not found.');
            }    
        }
        else 
        {
            $json_data = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($json_data);
    }

    public function student_profile()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $emailid = isset($post_data['emailid']) ?  filter_smart($post_data['emailid']): '' ;
        $student_id = isset($post_data['student_id']) ?  filter_smart($post_data['student_id']): '' ;
        
        if($emailid != '' && $student_id != '')
        {
            $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);
            // print_r_custom($studentInfo);

            if(!empty($studentInfo))
            {
                $this->data['result']['status'] = true;
                $this->data['result']['student_info'] = $studentInfo;
                if($studentInfo['profile_pic'] != '')
                {
                    $this->data['result']['profile_img_url'] = base_url().'uploads/student/'.$studentInfo['student_id'].'/profile-pic/'.$studentInfo['profile_pic'];
                }
                else
                {
                    $this->data['result']['profile_img_url'] = base_url().'assets/images/profile-photo-not-available.png';
                }
                $this->data['result']['message'] = "<b>Student details not found! </b>Please try again.";
            }
            else
            {
                $this->data['result']['status'] = false;
                $this->data['result']['message'] = "<b>Student details not found! </b>Please try again.";
            }    
        }
        else
        {
            $this->data['result']['status'] = false;
            $this->data['result']['message'] = "Email id & student code is mandatory.";
        }

        echo json_encode($this->data['result']);
    }

    public function forgot_password()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $emailid = filter_smart($post_data['emailid']);

        $student_info = $this->Login_Model->checkEmailIdExistsOrNot($emailid);

        if(!empty($student_info))
        {
            $full_name = $student_info['full_name'];
            $student_id = $student_info['student_id'];
            $status = $student_info['status'];
            
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

                $where = array('student_id' => $student_id, 'emailid' => $emailid);

                $update_status = $this->Common_Model->updateTable('student_master', $update_array, $where);

                if($update_status){
                    $message = "Dear ".$full_name.",<br><br>";
                    $message .= "<hr><br>";
                    $message .= "Please find below temporary password generated to login your student account.<br><br>";
                    $message .= "This password is valid for 24 hours.<br>";
                    $message .= "<br><hr><br><br>";
                    $message .= "Please use below details to login to your account.<br><br><br>";
                    $message .= "<b>Email ID: </b>".$emailid." <br>";
                    $message .= "<b>Temporary Password : </b>".$temp_password." <br>";
                    $message .= "<b>Password Valid Till: </b>".date('d-m-Y H:i:s', strtotime($temp_password_created_on))." <br><br><br>";
                    $message .= "<span style='background-color:red; color:yellow;'><b>Please change your password once you login to your student account </b></span> <br><br><br>";
                    $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";

                    if(IS_LIVE){
                        sendEmail($emailid, 'Forgot Password - '.COMPANY_NAME, $message, "", "", '', '','');
                    }
                }

                $this->data['result']['status'] = true;
                $this->data['result']['message'] = "Temporary paasword generated successfully & sent to your email id.<br>Now you can login to your account using the temporary password sent on your email id.<br><span style='background-color:red; color:yellow;'><b>Please change your password once you login to your student account </b></span> ";
            }
            
        }
        else
        {
            $this->data['result']['status'] = false;
            $this->data['result']['message'] = "<b>INVALID PARAMETER! </b>Please try again";
        }

        echo json_encode($this->data['result']);
    }

    public function lecture_links()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : 10;
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : 1;
        $offset = ($page_num - 1) * $limit;
        $searchTerm = isset($requestData['searchTerm']) ? $requestData['searchTerm'] : '';



        if($student_id != '' && $emailid != '')
        {

            // $courseData = array();
            $pagination = array('offset' => $offset, 'limit' => $limit );
            $today = date('Y-m-d H:i:s');

            $where = " 1=1 AND em.student_id = '".$student_id."' ";

            $current_datetime = date('Y-m-d H:i:s');

            $where .= " AND em.valid_upto >= '".$current_datetime."' "; 

            if (!empty($searchTerm)) {
                $where .= "AND (";
                $where .= " cm.course_name like '%$searchTerm%'  OR
                            ccm.course_category_name like '%$searchTerm%' OR 
                            cvm.video_title like '%$searchTerm%' ";
                $where .= ") ";
            }


            $login_detail = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($login_detail)
            {
                /*Count Table result*/
                $total_count_array = $this->Student_Details_Model->countAllVideoLectureList($where);

                $totalData = $total_count_array->total;

                /*Total Filter Record and fetch data*/
                $order_by = 'em.enrollment_master_id' ;
                $start = $offset;
                $length = $limit;
                $order_dir = 'DESC';

                if(!empty($searchTerm))
                {
                    $start = 0;
                    $length = $totalData;
                }

                $list_array = $this->Student_Details_Model->listVideoLinksQuery($where, $order_by, $start, $length, $order_dir);
                $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
                $result = $list_array['Result'];
                $data = array();

                // print_r($result);die('sd');

                foreach ($result as $main) {
                    $start++;

                    $nestedData = array();
                    
                    $nestedData['course_master_id'] = $start;
                    $nestedData['course_name'] = $main['course_name'];
                    $nestedData['video_title'] = $main['video_title'];
                    $nestedData['video_link'] = $main['video_link'];
                    $nestedData['valid_upto'] = $main['valid_upto'];
                    $nestedData['uploaded_date'] = $main['uploaded_date'];
                    $nestedData['course_category_name'] = $main['course_category_name'];

                    $data[] = $nestedData;
                }            

                if($totalData > 0)
                {
                    $json_data = array(
                        "status" => true,
                        "message" => "Lecture links found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
                else
                {
                    $json_data = array(
                        "status" => false,
                        "message" => "Lectre links data not found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
            }
            else 
            {
                $json_data = array('status' => false, 'message' => 'Lecture links not found.');
            }    
        }
        else 
        {
            $json_data = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($json_data);
    }

    public function test_schedules()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : 10;
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : 1;
        $offset = ($page_num - 1) * $limit;
        $searchTerm = isset($requestData['searchTerm']) ? $requestData['searchTerm'] : '';



        if($student_id != '' && $emailid != '')
        {

            // $courseData = array();
            $pagination = array('offset' => $offset, 'limit' => $limit );
            $today = date('Y-m-d H:i:s');

            $where = " 1=1 AND test_schedule_master.test_schedule_status='1' ";

            $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

            $course_category_array = array();
            for($i=0; $i<count($validEnrollmentList); $i++){

                $course_category_id = $validEnrollmentList[$i]['course_category_id'];

                if($i==0){
                    $where .= " AND (FIND_IN_SET ($course_category_id, test_schedule_master.course_category_id) ";
                }
                else{
                    $where .= " OR (FIND_IN_SET ($course_category_id, test_schedule_master.course_category_id))";
                }

                if($i==(count($validEnrollmentList)-1) || count($validEnrollmentList)==1){
                    $where .= " )";
                }
                
            }

            /*Saerch common search*/
            if (!empty($searchTerm)) {
                $where .= "AND (";
                // $where .= " course_category_master.course_category_name like '%$searchTerm%'  or  test_schedule_master.test_schedule_title like '%$searchTerm%'  or  test_schedule_master.test_schedule_link like '%$searchTerm%' ";
                $where .= " test_schedule_master.test_schedule_title like '%$searchTerm%'  or  test_schedule_master.test_schedule_link like '%$searchTerm%' ";
                $where .= ") ";
            }


            $login_detail = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($login_detail)
            {
                /*Count Table result*/
                $total_count_array = $this->Test_Schedules_Model->countAllTestSchedulesList($where);

                $totalData = $total_count_array->total;

                /*Total Filter Record and fetch data*/
                $order_by = 'test_schedule_master.test_schedule_master_id' ;
                $start = $offset;
                $length = $limit;
                $order_dir = 'DESC';

                if(!empty($searchTerm))
                {
                    $start = 0;
                    $length = $totalData;
                }

                $list_array = $this->Test_Schedules_Model->listTestSchedulesQuery($where, $order_by, $start, $length, $order_dir);
                $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
                $result = $list_array['Result'];
                $data = array();

                // print_r($result);die('sd');

                foreach ($result as $main) {
                    $start++;

                    $nestedData = array();
            
                    $nestedData['test_schedule_master_id'] = $start;
                    $nestedData['test_schedule_title'] = $main['test_schedule_title'];
                    $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));

                    $course_category_id = $main['course_category_id'];
                    $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsById($course_category_id);
                    $nestedData['course_category_name'] = $course_category_list['course_category_name'];

                    $test_schedule_date_time = $main['test_schedule_date_time'];
                    $nestedData['test_schedule_date_time'] = date('d-m-Y H:i', strtotime($main['test_schedule_date_time']));

                    $is_valid_date = false;

                    if(date('Y-m-d H:i:s') >= date('Y-m-d H:i:s', strtotime($main['test_schedule_date_time']))){
                        $is_valid_date = true;
                    }

                    $test_schedule_link = $main['test_schedule_link'];
                    $test_schedule_link_display = "";

                    if($is_valid_date){
                        $test_schedule_link_display = $test_schedule_link;
                    }
                    else{
                        $test_schedule_link_display = "";
                    }
                    
                    $nestedData['test_schedule_link'] = $test_schedule_link_display;
                    
                    $data[] = $nestedData;
                }            

                if($totalData > 0)
                {
                    $json_data = array(
                        "status" => true,
                        "message" => "Lecture links found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
                else
                {
                    $json_data = array(
                        "status" => false,
                        "message" => "Test Scheduled data not found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
            }
            else 
            {
                $json_data = array('status' => false, 'message' => 'Test Scheduled data not found.');
            }    
        }
        else 
        {
            $json_data = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($json_data);
    }

    public function announcements()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : 10;
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : 1;
        $offset = ($page_num - 1) * $limit;
        $searchTerm = isset($requestData['searchTerm']) ? $requestData['searchTerm'] : '';



        if($student_id != '' && $emailid != '')
        {

            // $courseData = array();
            $pagination = array('offset' => $offset, 'limit' => $limit );
            $today = date('Y-m-d H:i:s');

            $where = " 1=1  AND announcement_master.announcement_status='1' ";

            $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

            $course_category_array = array();
            for($i=0; $i<count($validEnrollmentList); $i++){

                $course_category_id = $validEnrollmentList[$i]['course_category_id'];

                if($i==0){
                    $where .= " AND (FIND_IN_SET ($course_category_id, announcement_master.course_category_id) ";
                }
                else{
                    $where .= " OR (FIND_IN_SET ($course_category_id, announcement_master.course_category_id))";
                }

                if($i==(count($validEnrollmentList)-1) || count($validEnrollmentList)==1){
                    $where .= " )";
                }
                
            }

            /*Saerch common search*/
            if (!empty($searchTerm)) {
                $where .= "AND (";
                $where .= " announcement_master.announcement_title like '%$searchTerm%'  or  announcement_master.announcement_description like '%$searchTerm%' ";
                $where .= ") ";
            }


            $login_detail = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($login_detail)
            {
                /*Count Table result*/
                $total_count_array = $this->Announcements_Model->countAllAnnouncementsList($where);
                $totalData = $total_count_array->total;                

                /*Total Filter Record and fetch data*/
                $order_by = 'announcement_master.announcement_master_id' ;
                $start = $offset;
                $length = $limit;
                $order_dir = 'DESC';

                if(!empty($searchTerm))
                {
                    $start = 0;
                    $length = $totalData;
                }

                /*Total Filter Record and fetch data*/
                $list_array = $this->Announcements_Model->listAnnouncementsQuery($where, $order_by, $start, $length, $order_dir);
                $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
                $result = $list_array['Result'];
                $data = array();

                // print_r($result);die('sd');

                foreach ($result as $main) {
                    $start++;

                    $nestedData = array();
            
                    $nestedData['announcement_master_id'] = $start;
                    $nestedData['announcement_title'] = $main['announcement_title'];
                    $nestedData['announcement_description'] = $main['announcement_description'];
                    $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
                    $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

                    $course_category_id = $main['course_category_id'];
                    $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsById($course_category_id);
                    $nestedData['course_category_name'] = $course_category_list['course_category_name'];
                    
                    $data[] = $nestedData;
                }            

                if($totalData > 0)
                {
                    $json_data = array(
                        "status" => true,
                        "message" => "Announcements found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
                else
                {
                    $json_data = array(
                        "status" => false,
                        "message" => "Announcements data not found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
            }
            else 
            {
                $json_data = array('status' => false, 'message' => 'Test Scheduled data not found.');
            }    
        }
        else 
        {
            $json_data = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($json_data);
    }

    public function parent_teachers_meetings()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : 10;
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : 1;
        $offset = ($page_num - 1) * $limit;
        $searchTerm = isset($requestData['searchTerm']) ? $requestData['searchTerm'] : '';



        if($student_id != '' && $emailid != '')
        {

            // $courseData = array();
            $pagination = array('offset' => $offset, 'limit' => $limit );
            $today = date('Y-m-d H:i:s');

            $where = " 1=1 AND pt_meetings_master.pt_meetings_status='1' ";

            $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

            $course_category_array = array();
            for($i=0; $i<count($validEnrollmentList); $i++){

                $course_category_id = $validEnrollmentList[$i]['course_category_id'];

                if($i==0){
                    $where .= " AND (FIND_IN_SET ($course_category_id, pt_meetings_master.course_category_id) ";
                }
                else{
                    $where .= " OR (FIND_IN_SET ($course_category_id, pt_meetings_master.course_category_id))";
                }

                if($i==(count($validEnrollmentList)-1) || count($validEnrollmentList)==1){
                    $where .= " )";
                }
                
            }

            /*Saerch common search*/
            if (!empty($searchTerm)) {
                $where .= "AND (";
                $where .= " pt_meetings_master.pt_meetings_title like '%$searchTerm%' ";
                $where .= ") ";
            }


            $login_detail = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($login_detail)
            {
                /*Count Table result*/
                $total_count_array = $this->Pt_Meetings_Model->countAllPtMeetingsList($where);
                $totalData = $total_count_array->total;                

                /*Total Filter Record and fetch data*/
                $order_by = 'pt_meetings_master.pt_meetings_master_id' ;
                $start = $offset;
                $length = $limit;
                $order_dir = 'DESC';

                if(!empty($searchTerm))
                {
                    $start = 0;
                    $length = $totalData;
                }

                /*Total Filter Record and fetch data*/
                $list_array = $this->Pt_Meetings_Model->listPtMeetingsQuery($where, $order_by, $start, $length, $order_dir);
                $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
                $result = $list_array['Result'];
                $data = array();

                // print_r($result);die('sd');

                foreach ($result as $main) {
                    $start++;

                    $nestedData = array();
            
                    $nestedData['pt_meetings_master_id'] = $start;
                    $nestedData['pt_meetings_title'] = $main['pt_meetings_title'];
                    $nestedData['pt_meetings_date_time'] = date('d-m-Y H:ia', strtotime($main['pt_meetings_date_time']));;
                    $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
                    $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

                    $course_category_id = $main['course_category_id'];
                    $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsById($course_category_id);
                    $nestedData['course_category_name'] = $course_category_list['course_category_name'];
                    
                    $data[] = $nestedData;
                }            

                if($totalData > 0)
                {
                    $json_data = array(
                        "status" => true,
                        "message" => "PT found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
                else
                {
                    $json_data = array(
                        "status" => false,
                        "message" => "Data not found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
            }
            else 
            {
                $json_data = array('status' => false, 'message' => 'Test Scheduled data not found.');
            }    
        }
        else 
        {
            $json_data = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($json_data);
    }

    public function holiday_info()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $limit  = isset($requestData['limit']) ? $requestData['limit'] : 10;
        $page_num  = isset($requestData['page_num']) ? $requestData['page_num'] : 1;
        $offset = ($page_num - 1) * $limit;
        $searchTerm = isset($requestData['searchTerm']) ? $requestData['searchTerm'] : '';



        if($student_id != '' && $emailid != '')
        {

            // $courseData = array();
            $pagination = array('offset' => $offset, 'limit' => $limit );
            $today = date('Y-m-d H:i:s');

            $where = " 1=1  AND holiday_information_master.holiday_information_status='1' ";

            $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

            $course_category_array = array();
            for($i=0; $i<count($validEnrollmentList); $i++){

                $course_category_id = $validEnrollmentList[$i]['course_category_id'];

                if($i==0){
                    $where .= " AND (FIND_IN_SET ($course_category_id, holiday_information_master.course_category_id) ";
                }
                else{
                    $where .= " OR (FIND_IN_SET ($course_category_id, holiday_information_master.course_category_id))";
                }

                if($i==(count($validEnrollmentList)-1) || count($validEnrollmentList)==1){
                    $where .= " )";
                }
                
            }

            /*Saerch common search*/
            if (!empty($searchTerm)) {
                $where .= "AND (";
                $where .= " holiday_information_master.holiday_information_title like '%$searchTerm%' ";
                $where .= ") ";
            }


            $login_detail = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."' AND emailid = '" . $emailid ."'")->row_array();

            if($login_detail)
            {
                /*Count Table result*/
                $total_count_array = $this->Holiday_Information_Model->countAllHolidayInformationList($where);
                $totalData = $total_count_array->total;                

                /*Total Filter Record and fetch data*/
                $order_by = 'holiday_information_master.holiday_information_master_id' ;
                $start = $offset;
                $length = $limit;
                $order_dir = 'DESC';

                if(!empty($searchTerm))
                {
                    $start = 0;
                    $length = $totalData;
                }

                /*Total Filter Record and fetch data*/
                $list_array = $this->Holiday_Information_Model->listHolidayInformationQuery($where, $order_by, $start, $length, $order_dir);
                $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
                $result = $list_array['Result'];
                $data = array();

                // print_r($result);die('sd');

                foreach ($result as $main) {
                    $start++;

                    $nestedData['holiday_information_master_id'] = $start;
                    $nestedData['holiday_information_title'] = $main['holiday_information_title'];
                    $nestedData['holiday_information_from_date'] = date('d-m-Y', strtotime($main['holiday_information_from_date']));
                    $nestedData['holiday_information_to_date'] = date('d-m-Y', strtotime($main['holiday_information_to_date']));
                    $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
                    $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

                    $course_category_id = $main['course_category_id'];
                    $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsById($course_category_id);
                    $nestedData['course_category_name'] = $course_category_list['course_category_name'];
                    
                    $data[] = $nestedData;
                }            

                if($totalData > 0)
                {
                    $json_data = array(
                        "status" => true,
                        "message" => "Holiday information",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
                else
                {
                    $json_data = array(
                        "status" => false,
                        "message" => "Data not found",
                        "recordsTotal" => intval($totalData),
                        "recordsFiltered" => intval($totalData),
                        "data" => $data,
                    );
                }
            }
            else 
            {
                $json_data = array('status' => false, 'message' => 'Holiday information not found.');
            }    
        }
        else 
        {
            $json_data = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($json_data);
    }

    public function change_password()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $current_password = isset($post_data['current_password']) ? filter_smart($post_data['current_password']) : '';
        $new_password = isset($post_data['new_password']) ? filter_smart($post_data['new_password']) : '';
        $confirm_password = isset($post_data['confirm_password']) ? filter_smart($post_data['confirm_password']) : '';
        $student_id = isset($post_data['student_id']) ? filter_smart($post_data['student_id']) : '';

        if($student_id != ''  && $new_password != '' && $confirm_password != '' && $current_password)
        {
            $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);

            if(!empty($studentInfo))
            {

                if(strlen($new_password) < MIN_LENGTH_PASSWORD || strlen($new_password) > MAX_LENGTH_PASSWORD)
                {
                    $status = false;
                    $message = "Password should be of minimum ".MIN_LENGTH_PASSWORD." AND maximum ".MAX_LENGTH_PASSWORD." characters long";
                }
                else
                {
                    $new_passwordtext = filter_smart($post_data['new_password']);
                    
                    $current_password = hash('sha512',$current_password);
                    
                    $new_password = hash('sha512',$new_password);
                    $confirm_password = hash('sha512',$confirm_password);

                    if ($new_password == $confirm_password)
                    {
                        $haveuppercase = preg_match('/[A-Z]/', $new_passwordtext);
                        $havenumeric = preg_match('/[0-9]/', $new_passwordtext);
                        $havespecial = preg_match('/[!@#$%)*_(+=}{\[\]|:;,.>}]/', $new_passwordtext);

                        if (!$haveuppercase)
                        {
                            $status = false;
                            $message = "New password must have atleast one upper case character";
                        }
                        else if (!$havenumeric)
                        {
                            $status = false;
                            $message = 'New password must have atleast one digit';
                        }
                        else if (!$havespecial)
                        {
                            $status = false;
                            $message = 'New password must have atleast one special character [!@#$%^)*_(+=}{|:;,.<>}]';
                        }
                        else
                        {
                            $password = $studentInfo['password'];
                            $temp_password = $studentInfo['temp_password'];
                            $temp_password_created_on = $studentInfo['temp_password_created_on'];
                            
                            if($password != $current_password && $temp_password != $current_password)
                            {
                                $status = false;
                                $message = 'Current password does not match with database!! Try again with proper password.';
                            }
                            else
                            {

                                if($password == $current_password)
                                {
                                    $table_name = "student_master";

                                    $where = array( "student_id" => $student_id);

                                    $update_array = array(
                                        "password"          => $new_password,
                                        "updated_by"         => $student_id,
                                        "updated_date"      => date('Y-m-d H:i:s'),
                                        "ip_address"        => $_SERVER['REMOTE_ADDR']
                                    );

                                    $this->Common_Model->updateTable($table_name, $update_array, $where);

                                    $status = true;
                                    $message = "Password updated successfully";
                                }
                                else
                                if($temp_password == $current_password){
                                    
                                    if( strtotime($temp_password_created_on) >= strtotime(date('Y-m-d H:i:s')) ){

                                        $table_name = "student_master";

                                        $where = array( "student_id" => $student_id);

                                        $update_array = array(
                                            "password"          => $new_password,
                                            "updated_by"         => $student_id,
                                            "updated_date"      => date('Y-m-d H:i:s'),
                                            "ip_address"        => $_SERVER['REMOTE_ADDR']
                                        );

                                        $this->Common_Model->updateTable($table_name, $update_array, $where);

                                        $status = true;
                                        $message = "Password updated successfully";
                                    }
                                    else{
                                        $status = false;
                                        $message = "ERROR !!...Your current password not matched & also temporary password was expired.";
                                    }
                                }
                                
                            }
                        }
                    }
                    else
                    {
                        $status = false;
                        $message = "New password & confirm password not same";
                    }
                }               
            }
            else
            {
                $status = false;
                $message = "User details not available.";
            }
        }
        else
        {
            $status = false;
            $message = "Please enter all mandatory fields.";
        }
                
        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
    }

    public function update_contact_details()
    {
        $post_data = $this->input->post();

        //extract($post_data);
        $full_name = isset($post_data['full_name'])  ? filter_smart($post_data['full_name']) : '' ;
        $emailid = isset($post_data['emailid'])  ? filter_smart($post_data['emailid']) : '' ;
        $contact = isset($post_data['contact'])  ? filter_smart($post_data['contact']) : '' ;
        $address = isset($post_data['address'])  ? filter_smart($post_data['address']) : '' ;
        $aadhar_number = isset($post_data['aadhar_number'])  ? filter_smart($post_data['aadhar_number']) : '' ;
        $student_id = isset($post_data['student_id'])  ? filter_smart($post_data['student_id']) : '' ;

            
        if($student_id != ''  && $full_name != '' && $emailid != '' && $contact != '')
        {
            $studentInfo = $this->Student_Details_Model->getStudentsInfoFromEmailWithOtherUserId($emailid, $student_id);
            
            if(empty($studentInfo))
            {
                $table_name = "student_master";

                $where = array("student_id" => $student_id);

                $update_array = array(
                    "full_name"         => $full_name,
                    "contact"           => $contact,
                    "address"           => $address,
                    "aadhar_number"     => $aadhar_number,
                    "updated_by"        => $student_id,
                    "updated_date"      => date('Y-m-d H:i:s'),
                    "ip_address"        => $_SERVER['REMOTE_ADDR']
                );


                $this->Common_Model->updateTable($table_name, $update_array, $where);

                $status = true;
                $message = "Contact details updated successfully";
                
            }
            else
            {
                $status = false;
                $message = "Email already available in records, Please choose different email.";
            }
        }
        else
        {
            $status = false;
            $message = "Please enter all mandatory fields.";
        }    
        
        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
    }

    public function buy_product()
    {
        $post_data = $this->input->post();

        $emailid = isset($post_data['emailid'])  ? filter_smart($post_data['emailid']) : '' ;
        $student_id = isset($post_data['student_id'])  ? filter_smart($post_data['student_id']) : '' ;
        $product_id = isset($post_data['product_id'])  ? filter_smart($post_data['product_id']) : '' ;
        $status = 'false';
        $message = 'Something went wrong. Please try later';

        $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => array(),
                    );

        if($student_id != ''  && $emailid != '' && $product_id != '')
        {
            $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);
            
            if($studentInfo)
            {
                $this->data['studentInfo'] = $studentInfo;

                $product_details = $this->Course_Model->getCourseDetailsById($product_id);            

                if(isset($product_details) && count($product_details) > 0 )
                {                                    
                    $cart_details['product_name'] = $product_details['course_name'];
                    $cart_details['course_image'] = $product_details['course_image'];
                    $cart_details['course_duration_number_of_days'] = $product_details['course_duration_number_of_days'];
                    $cart_details['course_start_date'] = $product_details['course_start_date'];
                    $cart_details['course_end_date'] = $product_details['course_end_date'];
                    $cart_details['is_allow_purchase_after_expire'] = $product_details['is_allow_purchase_after_expire'];
                    
                    $course_end_date = $product_details['course_end_date'];
                    $cart_details['is_course_expired'] = false;
                    $cart_details['price_after_discount'] = $product_details['course_sell_price'];
                    $cart_details['product_img_url'] = base_url()."uploads/course/".$product_id."/course-image/".$product_details['course_image'];

                    if($course_end_date==NULL || $course_end_date=='0000-00-00'){
                        $cart_details['is_course_expired'] = true;
                    }
                    else
                    if(strtotime(date('Y-m-d')) > strtotime($course_end_date)){
                        $cart_details['is_course_expired'] = true;
                    }

                    $this->data['cart_details'] = $cart_details;

                    $status = true;
                    $message = 'Product details found';
                    
                    $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => $cart_details,
                    );
                }
                else
                {
                    $status = false;
                    $message = "Product details not found";    

                    $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => array(),
                    );   
                }
            }
            else
            {
                $status = false;
                $message = "Student details not found";

                $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => array(),
                    );   
            }            
        }
        else
        {
            $status = false;
            $message = "Please enter all mandatory fields.";

            $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => array(),
                    );   
        }  
        echo json_encode($response);  
    }

    public function apply_coupon()
    {
        $post_data = $this->input->post();

        $emailid = isset($post_data['emailid'])  ? filter_smart($post_data['emailid']) : '' ;
        $student_id = isset($post_data['student_id'])  ? filter_smart($post_data['student_id']) : '' ;
        $product_id = isset($post_data['product_id'])  ? filter_smart($post_data['product_id']) : '' ;
        $coupon_code = isset($post_data['coupon_code'])  ? filter_smart($post_data['coupon_code']) : '' ;


        $status = 'false';
        $message = 'Something went wrong. Please try later';

        $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => array(),
                    );

        if($student_id != ''  && $emailid != '' && $product_id != '' && $coupon_code != '')
        {
            $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);
            
            if($studentInfo)
            {
                $product_details = $this->Course_Model->getCourseDetailsById($product_id); 


                $course_id = $product_details['course_master_id'];
                $course_sell_price = $product_details['course_sell_price'];

                $coupon_details = $this->Course_Model->checkCoupon($coupon_code);

                // print_r($coupon_details);die();

                if($coupon_details)
                {
                    $today = date('Y-m-d H:i:s');
                    $coupon_start_date = $coupon_details[0]->start_date == "0000-00-00" ? "" : $coupon_details[0]->start_date." 00:00:00"  ;
                    $coupon_end_date = $coupon_details[0]->end_date == "0000-00-00" ? "" : $coupon_details[0]->end_date." 23:59:59" ;
                    $coupon_discount_percent = $coupon_details[0]->disount_percent ;
                    $coupon_discount_amount = $coupon_details[0]->discount_amount ;
                    $no_of_times_coupon_can_use = $coupon_details[0]->no_of_times_coupon_use ;
                    $discount_coupon_master_id = $coupon_details[0]->discount_coupon_master_id ;

                    if(($coupon_details[0]->course_master_id == 0) || ($course_id == $coupon_details[0]->course_master_id))
                    {
                        $coupon_used_data = $this->Course_Model->checkCouponUsedCount($discount_coupon_master_id);
                    
                        $no_of_times_coupon_used = 0;

                        if($coupon_used_data)
                        {
                            $no_of_times_coupon_used = $coupon_used_data[0]->total;
                        }
                        
                        if($no_of_times_coupon_can_use > $no_of_times_coupon_used)
                        {
                            if($coupon_start_date != "" && $coupon_end_date != "")
                            {
                                if($today >= $coupon_start_date && $today <= $coupon_end_date)
                                {
                                    $coupon_result = $this->coupon_calculation($course_sell_price,$coupon_discount_percent,$coupon_discount_amount,$discount_coupon_master_id,$product_details);
                                    $response = array('status' =>true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);
                                }
                                else
                                {
                                    $response = array('status' =>false, 'message'=>"Invalid coupon code.");
                                }
                                goto print_result;
                            }                    
                            else if($coupon_start_date != "")
                            {
                                if($today >= $coupon_start_date)
                                {
                                    $coupon_result = $this->coupon_calculation($course_sell_price,$coupon_discount_percent,$coupon_discount_amount,$discount_coupon_master_id,$product_details);
                                    $response = array('status' =>true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);
                                }
                                else
                                {
                                    $response = array('status' =>false, 'message'=>"Invalid coupon code.");
                                }                                
                                goto print_result;

                            }
                            else if($coupon_end_date != "")
                            {
                                if($today <= $coupon_end_date)
                                {
                                    $coupon_result = $this->coupon_calculation($course_sell_price,$coupon_discount_percent,$coupon_discount_amount,$discount_coupon_master_id,$product_details);
                                    $response = array('status' =>true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);
                                }
                                else
                                {
                                    $response = array('status' =>false, 'message'=>"Invalid coupon code.");
                                }
                                goto print_result;

                            }
                            else
                            {
                                $coupon_result = $this->coupon_calculation($course_sell_price,$coupon_discount_percent,$coupon_discount_amount,$discount_coupon_master_id,$product_details);
                                $response = array('status' =>true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);
                                goto print_result;

                            }
                        }
                        else
                        {
                            $response = array('status' =>false, 'message'=>"Coupon is expired.");
                            goto print_result;
                        }
                    }
                    else
                    {
                        $response = array('status' =>false, 'message'=>"This coupon is not applicable for this course.");
                        goto print_result;
                    }
                }
                else
                {
                    $response = array('status' =>false, 'message'=>"Invalid coupon code.",);
                    goto print_result;
                }
            }
            else
            {
                $status = false;
                $message = "Student details not found";

                $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => array(),
                    ); 
                goto print_result;
            }
        }
        else
        {
            $status = false;
            $message = "Please enter all mandatory fields.";

            $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'cart_details' => array(),
                    );   
            goto print_result;
        }  
    
        print_result: echo json_encode($response);
    }

    public function coupon_calculation($course_sell_price,$coupon_discount_percent,$coupon_discount_amount,$discount_coupon_master_id,$cart_details){
        

        if($coupon_discount_percent != 0 && $coupon_discount_percent > 0)
        {
            $discount_value = ($course_sell_price*$coupon_discount_percent)/100;
            $cart_details['discount_type'] = 'PERCENTAGE';
        }
        else if($coupon_discount_amount > 0)
        {
            $discount_value = $coupon_discount_amount;
            $cart_details['discount_type'] = 'FLAT';
        }
        else
        {
            $discount_value = 0 ;
            $cart_details['discount_type'] = 'FLAT';
        }

        $selling_price = $course_sell_price - $discount_value ;    

        $cart_details['discount_coupon_master_id'] = $discount_coupon_master_id;
        $cart_details['discount_value'] = $discount_value;
        $cart_details['price_after_discount'] = $selling_price;
        $cart_details['is_discount_applied'] = 1;
        $cart_details['product_img_url'] = base_url()."uploads/course/".$cart_details['course_master_id']."/course-image/".$cart_details['course_image'];

        return $res = array(
                        'discount_coupon_master_id' => $discount_coupon_master_id,
                        'previous_selling_price' => $course_sell_price,
                        'discount_type' => $cart_details['discount_type'],
                        'discount_value' => $discount_value, 
                        'coupon_discount_percent' => $coupon_discount_percent, 
                        'selling_price' => $selling_price,
                        'cart_details' => $cart_details
                    );
    }

    public function booklets()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";

        if($student_id != '' && $emailid != '')
        {
            $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);
            
            if($studentInfo)
            {
                $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);
                
                if(count($validEnrollmentList) > 0)
                {   
                    for($v=0;$v<count($validEnrollmentList);$v++)
                    {
                        //course chapters
                        $validEnrollmentList[$v]['course_chapter'] = $this->Course_Model->getCourseChapterDetails($validEnrollmentList[$v]['course_master_id']);
                        
                        if(count($validEnrollmentList[$v]['course_chapter'])>0)
                        {                    
                            for($i=0;$i<count($validEnrollmentList[$v]['course_chapter']);$i++)
                            {
                                //chapter documents                        
                                $course_chapter_doc_details = $this->Course_Model->getCourseChapterDocDetails($validEnrollmentList[$v]['course_chapter'][$i]->chapter_master_id);
                                // print_r($course_chapter_doc_details);die();
                                $validEnrollmentList[$v]['course_chapter'][$i]->chapter_doc = count($course_chapter_doc_details) > 0 ? $course_chapter_doc_details : array();   

                                //sub chapter
                                // $course_subchapter_details = $this->Course_Model->getCourseSubChapterDetails($course_chapter_details[$i]->chapter_master_id);

                                $course_subchapter_details = $this->Course_Model->getCourseSubChapterDetails($validEnrollmentList[$v]['course_chapter'][$i]->chapter_master_id);
                                $validEnrollmentList[$v]['course_chapter'][$i]->sub_chapters = count($course_subchapter_details) > 0 ? $course_subchapter_details : array();

                                
                                //sub chapter documents
                                if(count($course_subchapter_details) > 0)
                                {
                                    for($p=0;$p<count($course_subchapter_details);$p++)
                                    {
                                        $course_sub_chapter_doc_details = $this->Course_Model->getCourseSubChapterDocDetails($course_subchapter_details[$p]->sub_chapter_master_id);
                                        $course_subchapter_details[$p]->sub_chapter_doc = count($course_sub_chapter_doc_details) > 0 ? $course_sub_chapter_doc_details : array();   
                                    }
                                }
                            }

                            $response = array(
                                'status'    => true,
                                'message'   => 'Data Found',
                                'validEnrollmentList' => $validEnrollmentList
                            );
                        }
                        else
                        {
                            $response = array(
                                'status'    => false,
                                'message'   => 'Booklets not Found',
                            );
                        }
                    }
                }
                else
                {
                    $status = false;
                    $message = "Enrollment details not found";

                    $response = array(
                            'status'    => $status,
                            'message'   => $message,
                        );   
                }
            }
            else
            {
                $status = false;
                $message = "Student details not found";

                $response = array(
                        'status'    => $status,
                        'message'   => $message,
                    );   
            }       
        }
        else 
        {
            $response = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($response);    
    }


    public function payment_params()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $product_id  = isset($requestData['product_id']) ? $requestData['product_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $amount  = isset($requestData['amount']) ? $requestData['amount'] : "";

        if($student_id != '' && $emailid != '' && $amount != '' && $product_id != '')
        {
            $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);
            
            if($studentInfo)
            {
                $merchant_order_id = "MauryaEdu-".date("YmdHis");
                $description =    "Order # ".$merchant_order_id ;

                $status = true;
                $message = "Payment params found.";

                $response = array(
                        'status'    => $status,
                        'message'   => $message,
                        'merchant_order_id'   => $merchant_order_id,
                        'description'   => $description,
                    );

            }
            else
            {
                $status = false;
                $message = "Student details not found";

                $response = array(
                        'status'    => $status,
                        'message'   => $message,
                    );   
            }    
        }
        else
        {
            $response = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }

        echo json_encode($response);        
    }


    public function app_payment_response()
    {
        $requestData = $_REQUEST;

        $student_id  = isset($requestData['student_id']) ? $requestData['student_id'] : "";
        $product_id  = isset($requestData['product_id']) ? $requestData['product_id'] : "";
        $emailid  = isset($requestData['emailid']) ? $requestData['emailid'] : "";
        $razor_payment_id  = isset($requestData['razor_payment_id']) ? $requestData['razor_payment_id'] : "";
        $order_id  = isset($requestData['merchant_order_id']) ? $requestData['merchant_order_id'] : "";
        $amount  = isset($requestData['merchant_amount']) ? $requestData['merchant_amount'] : "";
       
        $payment_status  = isset($requestData['payment_status']) ? $requestData['payment_status'] : "";
        $payment_method  = isset($requestData['payment_method']) ? $requestData['payment_method'] : "";
        $payment_response  = isset($requestData['payment_response']) ? $requestData['payment_response'] : "";
        $captured  = isset($requestData['captured']) ? $requestData['captured'] : "";
        
        $discount_coupon_master_id = isset($requestData['discount_coupon_master_id']) ? $requestData['discount_coupon_master_id'] : '';
        $course_actual_price = isset($requestData['course_actual_price']) ? $requestData['course_actual_price'] : '';
        $discount_type = isset($requestData['discount_type']) ? $requestData['discount_type'] : '';
        $disount_percent = isset($requestData['disount_percent']) ? $requestData['disount_percent'] : '';
        $discount_value = isset($requestData['discount_value']) ? $requestData['discount_value'] : '';
        $enrollment_expiry_date = isset($requestData['course_end_date']) ? $requestData['course_end_date'] : '';

        if($student_id != '' && $emailid != '' && $razor_payment_id != '' && $order_id != '' && $amount != '' && $product_id != '')
        {
            $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);
            
            if($studentInfo)
            {
                $insert_array = array(
                    'student_id' => $student_id,
                    'razor_payment_id' => $razor_payment_id,
                    'order_id' => $order_id,
                    'amount' => $amount,
                    'payment_status' => $payment_status,
                    'captured' => $captured,
                    'payment_method' => $payment_method,
                    'payment_response' => $payment_response,
                    'discount_coupon_master_id' => $discount_coupon_master_id,
                    'course_actual_price' => $course_actual_price,
                    'discount_type' => $discount_type,
                    'disount_percent' => $disount_percent,
                    'discount_value' => $discount_value,
                    'created_date' => date('Y-m-d H:i:s')
                );

                $table_name = 'razor_payment_master';
                $payment_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);   
            
                $paymentDetails = $this->RazorPay_Modal->getRazorPaymentDetails($student_id, $razor_payment_id, $order_id);

                if(!empty($paymentDetails))
                {
                    $product_details = $this->Course_Model->getCourseDetailsById($product_id);
                    $course_name = '';
                    $course_actual_price = '';

                    $enrollment_array['student_id'] = $student_id;
                    $enrollment_array['course_master_id'] = $product_id;
                    $enrollment_array['paid_price'] = $amount;
                    $enrollment_array['no_of_days'] = $product_details['course_duration_number_of_days'];
                    $enrollment_array['valid_upto'] = date('Y-m-d H:i:s', strtotime($enrollment_expiry_date." 23:59:59"));
                    $enrollment_array['payment_master_id'] = $payment_master_id;                
                    // $enrollment_array['request_data'] = json_encode($this->session->userdata('student_cart_details'));
                    $enrollment_array['created_by'] = $student_id;
                    $enrollment_array['created_date'] = date('Y-m-d H:i:s');
                    $enrollment_array['is_app_payment'] = '1';

                    $course_name = $product_details['course_name'];
                    $course_actual_price = $product_details['course_actual_price'];

                    $this->db->insert('enrollment_master', $enrollment_array); 

                    ////////////
                                                        
                    $full_name = $studentInfo['full_name'];
                    $emailid = $studentInfo['emailid'];
                    $contact = $studentInfo['contact'];
                    $address = $studentInfo['address'];

                    //--- sms notification
                    if(IS_LIVE){
                        sendCourseEnrollmentSMS($full_name, $contact);
                    }

                    //--- email notification student
                    $message = "Dear ".$full_name.",<br><br>";
                    $message .= "Your Course Enrollment is successful !";
                    $message .= "<br><br>";
                    $message .= "login to 'Students Dashboard' to access your course.";
                    $message .= "<br><br><br>";
                    $message .= "Thanks,<br> MauryaEdu";

                    if(IS_LIVE){
                        sendEmail($emailid, 'Course Enrollment - '.COMPANY_NAME, $message, "", "", '', '','');
                    }

                    //--- email notification student
                    $message_company = "";
                    
                    $message_company = "Following Student has been enrolled for your program,<br><br>";
                    $message_company .= "Student Name: ".$full_name;
                    $message_company .= "<br><br>";
                    $message_company .= "Mobile Number: ".$contact;
                    $message_company .= "<br><br>";
                    $message_company .= "Email Id: ".$emailid;
                    $message_company .= "<br><br>";
                    $message_company .= "Enrolled Course: ".$course_name;
                    $message_company .= "<br><br>";
                    $message_company .= "Course Purchasing Date: ".date('d/m/Y');
                    $message_company .= "<br><br>";
                    $message_company .= "Fee Paid: ".$amount;
                    $message_company .= "<br><br>";
                    $message_company .= "Address: ".$address;
                    $message_company .= "<br><br>";

                    if(IS_LIVE){
                        sendEmail(COMPANY_EMAIL, 'Course Enrollment - '.COMPANY_NAME, $message_company, "", "", '', '','');
                    }

                    $msg = 'Razorpay Success | '.COMPANY_NAME;
                    $msg .= "<h4>Your transaction is successful</h4>";  
                    $msg .= "<br/>";
                    $msg .= "Transaction ID: ".$this->session->flashdata('razorpay_payment_id');
                    $msg .= "<br/>";
                    $msg .= "Order ID: ".$this->session->flashdata('merchant_order_id');
                    $msg .= "<br/>";
                    $msg .= "Course enrollment completed.";

                    $res_status = true;
                    $res_message = 'Course enrollment completed successfully.';
                    
                    /////////////
                }
                else
                {
                    $res_status = false;
                    $res_message = "Payment details not found...";
                }

                //$response['login_detail'] = $login_detail;
                $response['studentInfo'] = $studentInfo;
                $response['status'] = $res_status;
                $response['message'] = $res_message;
            }
            else
            {
                $status = false;
                $message = "Student details not found";

                $response = array(
                        'status'    => $status,
                        'message'   => $message,
                    );   
            }    
        }
        else 
        {
            $response = array('status' => false, 'message' => 'Mandatory parameters are missing.');
        }    

        echo json_encode($response);        
    }


} 