<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TestResults extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Test_Records_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index(){
        checkStudentLoginSession();
        
        addJs(array("student/test-results.js"));

        $login_detail = $this->session->userdata('student_login_detail');
        $student_id = $login_detail['student_id'];

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);

        $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        $this->data['validEnrollmentList'] = $validEnrollmentList;

        // print_r_custom($this->data,1);

        $this->load->studenttemplate('test-results', $this->data);
    }

    public function TestResultsListAjax()
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
            1=>'test_records_master.test_date',
            2=>'test_records_master.is_attempted',
            3=>'test_records_master.marks_obtained',
            4=>'test_records_master.total_marks',
            5=>'test_records_master.no_of_right_questions',
            6=>'test_records_master.no_of_wrong_questions',
            7=>'test_records_master.created_date',
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $login_detail = $this->session->userdata('student_login_detail');
        $student_id = $login_detail['student_id'];

        $where = " 1=1 AND test_records_master.student_id=$student_id AND test_records_master.test_records_status='1' ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " test_records_master.marks_obtained like '%$searchTerm%' ";
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

        $json_data = array(
            "draw" => $draw,
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data,
        );

        echo json_encode($json_data);
    }

}