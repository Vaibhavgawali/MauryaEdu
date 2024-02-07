<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends Front_Controller
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

        $login_detail = $this->session->userdata('student_login_detail');

        if(!empty($login_detail) && $login_detail['student_is_logged_in']=='1' && $login_detail['student_id'] > 0)
        {
            redirect(base_url() . 'student/dashboard');
            exit;
        }
        else
        {
            $this->load->view('course/courses-list');
        }        
    }

    public function courses_listAjax()
    {
        $requestData = $_REQUEST;

        $limit  = $requestData['limit'];
        $page_num  = $requestData['page_num'];
        $offset = ($page_num - 1) * $limit;

        // $courseData = array();
        $pagination = array('offset' => $offset, 'limit' => $limit );

        $courses = $this->Course_Model->loadCourses($pagination);
        $totalCourses =  $this->Course_Model->totalCourses();
        // print_r($totalCourses);
        $totalCourses = $totalCourses['total'];

        for($i=0;$i<count($courses);$i++)
        {
            $courses[$i]['is_already_bought'] = false;

            //---- check course is expired or not
            $course_end_date = $courses[$i]['course_end_date'];
            $courses[$i]['is_course_expired'] = false;

            // if($course_end_date==NULL || $course_end_date=='0000-00-00'){
            //     $courses[$i]['is_course_expired'] = true;
            // }
            // else
            // if(strtotime(date('Y-m-d')) > strtotime($course_end_date)){
            //     $courses[$i]['is_course_expired'] = true;
            // }
        }

        if($courses){
            $response = array(
                        'status' => true,
                        'courseData' => $courses,
                        'remaining_course' => $totalCourses - $limit * $page_num, 
                        'message' => 'Course data found',
                        'is_logged_in' => 'No'
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
        checkAdminLoginSession();
        
        addJs(array("admin/chapter-documents.js"));

        $login_detail = $this->session->userdata('login_detail');

        $this->data['login_detail'] = $login_detail;
        $this->data['chapter_master_id'] = $chapter_master_id;

        $chapter_master_details = $this->Chapter_Model->getChapterDetailsById($chapter_master_id);
        
        if(count($chapter_master_details) > 0){

            $this->data['chapter_master_details'] = $chapter_master_details;

            $course_master_details = $this->Course_Model->getCourseDetailsById($chapter_master_details['chapter_master_id']);
            $this->data['course_master_details'] = $course_master_details;

            $course_category_details = $this->Course_Category_Model->getCourseCategoryDetailsById($chapter_master_details['course_category_id']);
            $this->data['course_category_details'] = $course_category_details;
            
            // print_r_custom($this->data,1);

            $this->load->admintemplate('chapter/add-chapter-documents', $this->data);
        }
        else{
            echo "Invalid Parameters!!!";
        }
        exit;
    }

}
?>    