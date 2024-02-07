<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ParentTeacherMeetings extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Pt_Meetings_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->helper('common_helper');
    }

    public function index(){
        checkStudentLoginSession();
        
        addJs(array("student/pt-meetings.js"));

        $login_detail = $this->session->userdata('student_login_detail');
        $student_id = $login_detail['student_id'];

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);

        $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        $this->data['validEnrollmentList'] = $validEnrollmentList;

        // print_r_custom($this->data,1);

        $this->load->studenttemplate('pt-meetings', $this->data);
    }

    public function ParentTeacherMeetingsListAjax()
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
            0=>'pt_meetings_master.pt_meetings_master_id',
            1=>'pt_meetings_master.course_category_id',
            2=>'pt_meetings_master.pt_meetings_title',
            3=>'pt_meetings_master.pt_meetings_date_time',
            4=>'pt_meetings_master.created_date',
            5=>'pt_meetings_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

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
            $nestedData['pt_meetings_date_time'] = date('d-m-Y H:ia', strtotime($main['pt_meetings_date_time']));;
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $course_category_id = $main['course_category_id'];
            $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsById($course_category_id);
            $nestedData['course_category_name'] = $course_category_list['course_category_name'];

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