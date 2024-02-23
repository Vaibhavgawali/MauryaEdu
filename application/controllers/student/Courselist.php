<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Courselist extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Course_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->helper('common_helper');
    }

    public function courses_list(){

        checkStudentLoginSession();

        addJs(array("course/course-list.js"));
        
        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        
        $this->load->studenttemplate('course-list', $this->data);
        // print_r( $this->data);
    }

    public function courses_listAjax()
    {
        $login_detail = $this->session->userdata('student_login_detail');

        $requestData = $_REQUEST;

        $limit  = $requestData['limit'];
        $page_num  = $requestData['page_num'];
        $offset = ($page_num - 1) * $limit;

        // $courseData = array();
        $pagination = array('offset' => $offset, 'limit' => $limit );

        $where = " AND course_master.branch_id IN (" . $login_detail['branch_id'] . ", 1)";

        $courses = $this->Course_Model->loadCourses($pagination,$where);

    
        for($i=0;$i<count($courses);$i++)
        {
            if($login_detail)
            {
                $check_if_already_bought = $this->Course_Model->CheckCourseIfAlreadyBought($login_detail['student_id'], $courses[$i]['course_master_id']);
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
            else
            {
                $courses[$i]['is_already_bought'] = false;
            }
            // print_r_custom($check_if_already_bought,1);
        }
         
        $totalCourses =  $this->Course_Model->totalCourses($where);
        $totalCourses = $totalCourses['total'];

        if($courses){
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

        echo json_encode($response);
    }

    public function getCourseDetails($course_id = '')
    {
        checkStudentLoginSession();
        
        addJs(array("course/course-list.js"));

        $login_detail = $this->session->userdata('student_login_detail');

        $this->data['login_detail'] = $login_detail;
        $this->data['course_id'] = $course_id;

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);
        $this->data['studentInfo'] = $studentInfo;

        $course_details = $this->Course_Model->getCourseDetailsById($course_id);
        
        if(count($course_details) > 0){

            //---- check course is expired or not
            $course_end_date = $course_details['course_end_date'];
            $is_allow_purchase_after_expire = $course_details['is_allow_purchase_after_expire'];
            $course_duration_number_of_days = $course_details['course_duration_number_of_days'];

            $course_details['is_course_expired'] = false;
            if($course_end_date==NULL || $course_end_date=='0000-00-00'){
                $course_details['is_course_expired'] = true;
            }
            else
            if(strtotime(date('Y-m-d')) > strtotime($course_end_date)){
                $course_details['is_course_expired'] = true;
            }

            $enrollment_expiry_date = '';

            if(($course_details['is_course_expired']) && $is_allow_purchase_after_expire=='1'){
                $enrollment_expiry_date = date('Y-m-d', strtotime("+".$course_duration_number_of_days." days"));
            }
            else{
                if($course_end_date > date('Y-m-d'))
                {
                    $enrollment_expiry_date = date('Y-m-d', strtotime($course_end_date.""));
                }
                else
                if(($course_end_date < date('Y-m-d')) && $is_allow_purchase_after_expire=='1'){
                    $enrollment_expiry_date = date('Y-m-d', strtotime("+".$course_duration_number_of_days." days"));
                }
            }
            $course_details['enrollment_expiry_date'] = $enrollment_expiry_date;

            $this->data['course_details'] = $course_details;
            
            // print_r_custom($this->data,1);

            $this->load->studenttemplate('course-details', $this->data);
        }
        else{
            echo "Invalid Parameters!!!";
        }
        exit;
    }

    public function enrolled_courses_list(){
        checkStudentLoginSession();
        
        // header("Location: ".APP_LINK);
        // die();

        addJs(array("course/enrolled-course-list.js"));
        
        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        
        $this->load->studenttemplate('enrolled-course-list', $this->data);   
    }

    public function enrolledcourses_listAjax()
    {
        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);
        $requestData = $_REQUEST;

        $limit  = $requestData['limit'];
        $page_num  = $requestData['page_num'];
        $offset = ($page_num - 1) * $limit;
        $where = " 1=1 AND em.student_id = '".$login_detail['student_id']."' ";

        // $courseData = array();
        $pagination = array('offset' => $offset, 'limit' =>$limit );

        $courses = $this->Course_Model->loadEnrolledCourses($pagination,$where);
        $totalCourses =  $this->Course_Model->totalEnrolledCourses($where);
        // print_r_custom(count($courses),1);
        $totalCourses = $totalCourses['total'];

        $count=0;
        $data=array();

        if($courses){
            
            for($i=0; $i<count($courses); $i++){

                    $valid_upto = "";
                    $valid_upto = $courses[$i]['valid_upto'];
                    $validity = date('d-m-Y H:i', strtotime($valid_upto));

                    $courses[$i]['course_validity'] = $validity;

                    $created_date = "";
                    $created_date = $courses[$i]['enrollment_date'];
                    $created_date = date('d-m-Y H:i', strtotime($created_date));

                    $courses[$i]['course_enrollment_date'] = $created_date;

                   //---- check course is expired or not
                   $courses[$i]['is_course_expired'] = false;

                    if($validity==NULL || $validity=='0000-00-00'){
                        $courses[$i]['is_course_expired'] = true;
                    }
                    else
                    if(strtotime(date('Y-m-d')) > strtotime($validity)){
                        $courses[$i]['is_course_expired'] = true;
                    }

                    if( (($courses[$i]['enrollment_status'] == "1") || $courses[$i]['is_course_expired']==false)){
                        $count++;
                        $data[]=$courses[$i];
                    }

            }
            // print_r_custom(count($data),1);

            if($count == 0){
                $response = array('status' => false, 'message' => 'Course data not found', 'remaining_course' => 0);
            }else{

                $response = array(
                    'status' => true,
                    'courseData' => $data,
                    'remaining_course' => count($data) - $limit * $page_num, 
                    'limit'=>$limit,
                    'pagenum'=>$page_num,
                    'message' => 'Course data found'
                );
            }          
        }
        else
        {
            $response = array('status' => false, 'message' => 'Course data not found', 'remaining_course' => 0);
        }

        echo json_encode($response);
    }

    public function getEnrolledCourseDetails($course_id = '')
    {
        checkStudentLoginSession();
        
        // header("Location: ".APP_LINK);
        // die();

        addJs(array("course/enrolled-course-list.js"));
                
        $login_detail = $this->session->userdata('student_login_detail');

        $this->data['login_detail'] = $login_detail;
        $this->data['course_id'] = $course_id;

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);
        $this->data['studentInfo'] = $studentInfo;

        $course_details = $this->Course_Model->getEnrolledCourseDetailsById($login_detail['student_id'],$course_id);
        // print_r_custom($course_details);
        if(count($course_details) > 0)
        {
            //---- check course is expired or not
            $course_end_date = $course_details['course_end_date'];
            $course_details['is_course_expired'] = false;

            if($course_end_date==NULL || $course_end_date=='0000-00-00'){
                $course_details['is_course_expired'] = true;
            }
            else
            if(strtotime(date('Y-m-d')) > strtotime($course_end_date)){
                $course_details['is_course_expired'] = true;
            }

            $this->data['course_details'] = $course_details;

            // redirect  to courselist page if course is expired or student status for course is inactive
            if($course_details['is_course_expired'] == true && $course_details['enrollment_status']=="0"){
                redirect('student/enrolled-courses-list');
            }

                //course videos
                $course_video_details = $this->Course_Model->getCourseVideoDetails($course_details['course_master_id']);
                $this->data['course_video_details'] = count($course_video_details) > 0 ? $course_video_details : array();

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
                $this->data['course_chapter_details'] = count($course_chapter_details) > 0 ? $course_chapter_details : array();
            
            // print_r_custom($this->data['course_details'],1);
            // print_r_custom($this->data['course_video_details']);
            // print_r_custom($this->data['course_chapter_details'],1);
            // print_r_custom($this->data['course_chapter_doc_details'],1);
        }
        
        $this->load->studenttemplate('enrolled-course-details', $this->data);
        // exit;
    }


    // public function view_pdf(){
    //     checkStudentLoginSession();
        
    //     $file = 'http://localhost/student-portal/uploads/chapter/5/chapter-documents/4/c97986e2267af38ab552b447515a137e.pdf';
    //     $filename = 'http://localhost/student-portal/uploads/chapter/5/chapter-documen   ts/4/c97986e2267af38ab552b447515a137e.pdf';
          
    //     // Header content type
    //     header('Content-type: application/pdf');
          
    //     header('Content-Disposition: inline; filename="' . $filename . '"');
          
    //     header('Content-Transfer-Encoding: binary');
          
    //     header('Accept-Ranges: bytes');
          
    //     // Read the file
    //     @readfile($file);
    // }

}
?>    