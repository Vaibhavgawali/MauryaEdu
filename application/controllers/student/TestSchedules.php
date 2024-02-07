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
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index(){
        checkStudentLoginSession();
        
        addJs(array("student/test-schedules.js"));

        $login_detail = $this->session->userdata('student_login_detail');
        $student_id = $login_detail['student_id'];

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);

        $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        $this->data['validEnrollmentList'] = $validEnrollmentList;

        // print_r_custom($this->data,1);

        $this->load->studenttemplate('test-schedules', $this->data);
    }

    public function TestSchedulesListAjax()
    {
        $login_detail = $this->session->userdata('student_login_detail');
        $student_id  = $login_detail['student_id'];

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
            1=>'course_category_master.course_category_name',
            2=>'test_schedule_master.test_schedule_title',
            3=>'test_schedule_master.test_schedule_link',
            4=>'test_schedule_master.created_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/
        
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
            $where .= " course_category_master.course_category_name like '%$searchTerm%'  or  test_schedule_master.test_schedule_title like '%$searchTerm%'  or  test_schedule_master.test_schedule_link like '%$searchTerm%' ";
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
                $test_schedule_link_display = "<a href='".$test_schedule_link."' target='_blank'>Click Here</a>";
            }
            else{
                $test_schedule_link_display = "<span class='badge badge-danger'>Coming Soon!!!</span>";
            }
            
            $nestedData['test_schedule_link'] = $test_schedule_link_display;
            
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

}