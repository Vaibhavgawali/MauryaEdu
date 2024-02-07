<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Announcements extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Announcements_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index(){
        checkAdminLoginSession();

        addJs(array("admin/announcements.js",));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $course_category_list = $this->Course_Category_Model->getAllCourseCategoryDetailsByStatus(1);
        $this->data['course_category_list'] = $course_category_list;

        $this->load->admintemplate('announcements', $this->data);
    }

    public function AddAnnouncements()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $announcement_title = filter_smart($post_data['announcement_title']);
        $announcement_description = filter_smart($post_data['announcement_description']);
        
        $table_name = "announcement_master";

        $insert_array = array(
            "course_category_id"        => $course_category_id,
            "announcement_title"        => $announcement_title,
            "announcement_description"  => $announcement_description,
            "created_date"              => date('Y-m-d H:i:s'),
            "created_by"                => $userinfo_id,
        );

        $test_records_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

        if($test_records_master_id > 0){
            $status = true;
            $res_message = "Announcement added successfully.";
            
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

    public function AnnouncementsListAjax()
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
            0=>'announcement_master.announcement_master_id',
            1=>'announcement_master.course_category_id',
            1=>'announcement_master.announcement_title',
            2=>'announcement_master.announcement_description',
            3=>'announcement_master.announcement_status',
            4=>'announcement_master.created_date',
            5=>'announcement_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " announcement_master.announcement_title like '%$searchTerm%'  or  announcement_master.announcement_description like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Announcements_Model->countAllAnnouncementsList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Announcements_Model->listAnnouncementsQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['announcement_master_id'] = $start;
            $nestedData['announcement_title'] = $main['announcement_title'];
            $nestedData['announcement_description'] = $main['announcement_description'];
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $announcement_master_id = $main['announcement_master_id'];
            
            $announcement_status = $main['announcement_status'];
            $status_display = "";

            if($announcement_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['announcement_status'] = $status_display;

            $course_category_id = $main['course_category_id'];
            $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsByMultipleId($course_category_id);
            $course_category_array = array();
            
            for($i=0; $i<count($course_category_list); $i++){
                array_push($course_category_array, $course_category_list[$i]['course_category_name']);
            }
            $nestedData['course_category_id'] = implode(', ',$course_category_array);


            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_announcement' id='".$announcement_master_id."' course_category_id='".$course_category_id."' announcement_title='".$main['announcement_title']."'  announcement_description='".$main['announcement_description']."' announcement_status='".$main['announcement_status']."'><i class='fa fa-pencil'></i> Edit</a>";

            $action = "";
            $action .= $edit_button;

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

    public function UpdateAnnouncements()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $announcement_master_id = filter_smart($post_data['announcement_master_id']);
        $announcement_title = filter_smart($post_data['announcement_title']);
        $announcement_description = filter_smart($post_data['announcement_description']);
        $announcement_status = filter_smart($post_data['announcement_status']);

        $get_announcement_Details = $this->Announcements_Model->getAnnouncementsById($announcement_master_id);
        
        if(!empty($get_announcement_Details)){

            $table_name = "announcement_master";

            $where = array("announcement_master_id" => $announcement_master_id);

            $update_array = array(
                "course_category_id"        => $course_category_id,
                "announcement_title"        => $announcement_title,
                "announcement_description"  => $announcement_description,
                "announcement_status"       => $announcement_status,
                "updated_date"              => date('Y-m-d H:i:s'),
                "updated_by"                => $userinfo_id,
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $status = true;
            $res_message = "Announcement details updated successfully.";
        }
        else{
            $status = false;
            $res_message = "Announcement details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}