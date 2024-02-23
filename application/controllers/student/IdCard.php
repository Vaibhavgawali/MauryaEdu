<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IdCard extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Course_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Id_Card_Model');
        $this->load->helper('common_helper');
    }

    public function index(){
        checkStudentLoginSession();

        addJs(array("student/id-cards-list.js"));

        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        
        $this->load->studenttemplate('id-cards-list', $this->data);   
    }

    public function IdCardListAjax()
    {
        $login_detail = $this->session->userdata('student_login_detail');
        // print_r_custom($login_detail,1);

        $requestData = $_REQUEST;
        $draw = $requestData['draw'];
        $start = $requestData['start']; /*start length*/
        $length = $requestData['length']; /*End length*/
        $order = $requestData['order']; /*Order by col index*/
        $search = $requestData['search']; /*search */
        // echo "<pre>";
        // print_r($search);
        /*Search value single search*/
        $searchTerm = $search['value'];

        /*order by colum value*/
        $colums = array(
            0=>'icm.id_card_master',
            1=>'cm.course_name',
            2=>'icm.id_card_title',
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = "icm.id_card_status= 1 AND em.student_id = '".$login_detail['student_id']."' ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "cm.course_name like '%$searchTerm%' ";
            $where .= ") ";
        }
        
        /*Count Table result*/
        $total_count_array =  $this->Id_Card_Model->totalIdCards($where);

        $totalData = $total_count_array['total'];

        /*Total Filter Record and fetch data*/
        $list_array = $this->Id_Card_Model->loadIdCards($where, $order_by, $start, $length, $order_dir);

        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['id_card_id'] = $start;
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['id_card_title']=$main['id_card_title'];

            $id_card_file=$main['id_card_file'];

            $document_url= base_url("uploads/student/".$main['student_id']."/id-card/".$id_card_file);
            // print_r_custom($document_url);
            $view_button = "<a href='".$document_url."' class='btn btn-info btn-sm' target='_blank'><i class='fa fa-eye'></i>View</a>";

            $edit_button = "<a href='".$document_url."' class='btn btn-info btn-sm' download><i class='fa fa-download'></i> Download</a>";
            $action = "";
            $action .= $view_button. " ".$edit_button;
                   
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
}