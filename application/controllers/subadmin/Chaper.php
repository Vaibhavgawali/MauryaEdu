<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Chaper extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Course_Model');
        $this->load->model('Common/Chapter_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkBranchAdminLoginSession();

        addJs(array("subadmin/chaper-list.js"));
        
        $login_detail = $this->session->userdata('login_detail');

        $where = " AND branch_id IN (" . $login_detail['branch_id'] . ")";

        $course_category_list = $this->Course_Category_Model->getAllCourseCategoryDetailsByStatus(1,$where);
        $course_master_list = $this->Course_Model->getAllCourseDetailsByStatus(1);
        //print_r_custom($course_category_list,1);

        $this->data['login_detail'] = $login_detail;
        $this->data['course_category_list'] = $course_category_list;
        $this->data['course_master_list'] = $course_master_list;

        $this->load->subadmintemplate('chapter/chapter-list', $this->data);
    }

    public function GetCourseListFromCategory(){
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = false;
        $course_details = array();
        $message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);

        $get_Course_Details_From_Course_Id = $this->Course_Model->getCourseDetailsByCategoryId($course_category_id);

        if(count($get_Course_Details_From_Course_Id) > 0){
            $status = true;
            $course_details = $get_Course_Details_From_Course_Id;
            $message = "Course details fetch successfully";
        }
        else{
            $status = false;
            $course_details = array();
            $message = "Courses not available for this category";
        }

        $response = array(
            'status'    => $status,
            'course_details'  => $course_details,
            'message'   => $message
        );

        echo json_encode($response, TRUE);
        exit;
    }

    public function AddCourseChapter($course_master_id = '')
    {
        checkBranchAdminLoginSession();
        
        addJs(array("subadmin/chaper-list.js"));

        $login_detail = $this->session->userdata('login_detail');

        $this->data['login_detail'] = $login_detail;

        $course_master_details = $this->Course_Model->getCourseDetailsById($course_master_id);
        
        if(count($course_master_details) > 0){
            $this->data['course_master_details'] = $course_master_details;

            $course_category_details = $this->Course_Category_Model->getCourseCategoryDetailsById($course_master_details['course_category_id']);
            $this->data['course_category_details'] = $course_category_details;
            
            // print_r_custom($this->data,1);

            $this->load->subadmintemplate('chapter/add-chapter-details', $this->data);
        }
        else{
            echo "Invalid Parameters!!!";
        }
        exit;
    }

    public function ChaperAddProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $admin_id = $login_detail['admin_id'];
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $chapter_name = filter_smart($post_data['chapter_name']);
        $chapter_info = filter_smart($post_data['chapter_info']);

        $get_Capter_Details = $this->Chapter_Model->getChapterDetailsByNameWithCategoryAndCourse($course_category_id, $course_master_id, $chapter_name);

        if(empty($get_Capter_Details)){

            $table_name = "chapter_master";

            $insert_array = array(
                "course_category_id"        => $course_category_id,
                "course_master_id"          => $course_master_id,
                "branch_id"                 => $branch_id,
                "chapter_name"              => $chapter_name,
                "chapter_info"              => $chapter_info,
                "chapter_status"            => '1',
                "created_date"              => date('Y-m-d H:i:s'),
                "created_by"                => $branch_id,
            );

            $chapter_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($chapter_master_id > 0){

                $status = true;
                $res_message = "Chapter added successfully.";

            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Chapter already exists in records, Please choose different Chapter name.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function ChaperListAjax()
    {
        $login_detail = $this->session->userdata('login_detail');
        //print_r_custom($login_detail,1);

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
            0=>'chapter_master.chapter_master_id',
            1=>'course_category_master.course_category_name',
            2=>'course_master.course_name',
            3=>'chapter_master.chapter_name',
            4=>'branch_master.branch_name',
            5=>'chapter_master.chapter_status',
            6=>'chapter_master.created_date',
            7=>'chapter_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 AND branch_master.branch_id IN (" . $login_detail['branch_id'] . ", 1)";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " course_category_master.course_category_name like '%$searchTerm%' OR course_master.course_name like '%$searchTerm%' OR chapter_master.chapter_name like '%$searchTerm%' OR branch_master.branch_name like '%$searchTerm%'";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Chapter_Model->countAllChapterList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Chapter_Model->listChapterQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['chapter_master_id'] = $start;
            $nestedData['course_category_name'] = $main['course_category_name'];
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['chapter_name'] = $main['chapter_name'];

            $branch_name = $main['branch_name'];
            $created_by = ($branch_name == "Superadmin") ? "Superadmin" : "You";
            $nestedData['created_by'] = $created_by;

            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $chapter_master_id = $main['chapter_master_id'];

            $chapter_status = $main['chapter_status'];
            $status_display = "";

            if($chapter_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['chapter_status'] = $status_display;

            

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_chaper' id='".$chapter_master_id."'><i class='fa fa-eye'></i> View</a>";

            // $add_sub_chapter_button = "<a href='".base_url()."admin/sub-chapter-list/".$chapter_master_id."' class='btn btn-info btn-sm' id='".$chapter_master_id."'><i class='fa fa-plus'></i> Add Sub Chapters</a>";

            $add_chapter_content = "<a href='".base_url()."subadmin/chapter-data/".$chapter_master_id."' class='btn btn-info btn-sm' id='".$chapter_master_id."'><i class='fa fa-plus'></i> Add Chapter Data</a>";
            
            $view_chapter_content = "<a href='".base_url()."subadmin/view-chapter-data/".$chapter_master_id."' class='btn btn-info btn-sm' id='".$chapter_master_id."'><i class='fa fa-eye'></i> View Chapter Data</a>";
            
            $action = "";

            if ($branch_name !== "Superadmin") {
                // $action .= $edit_button."&nbsp;&nbsp;&nbsp;".$add_sub_chapter_button."&nbsp;&nbsp;&nbsp;".$add_chapter_content;
                $action .= $edit_button."&nbsp;&nbsp;&nbsp;".$add_chapter_content;
            }else{
                $action .= $view_chapter_content;
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

    //get chapter details
    public function GetChaperDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $chapter_details = array();
        $message = "Chapter details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $chapter_master_id = filter_smart($post_data['chapter_master_id']);

        $get_Chapter_Details = $this->Chapter_Model->getChapterDetailsById($chapter_master_id);

        if(count($get_Chapter_Details) == 0){
            $status = false;
            $chapter_details = array();
            $message = "Chapter details not found";
        }
        else{
            $status_html = null;

            $chapter_status = $get_Chapter_Details['chapter_status'];

            if($chapter_status=="1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($chapter_status=="0"){
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0' selected>In-Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }

            $chapter_details = array(
                'chapter_master_id' => $get_Chapter_Details['chapter_master_id'],
                'course_category_id' => $get_Chapter_Details['course_category_id'],
                'course_master_id' => $get_Chapter_Details['course_master_id'],
                'chapter_name' => $get_Chapter_Details['chapter_name'],
                'chapter_info' => $get_Chapter_Details['chapter_info'],
                'chapter_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'chapter_details'  => $chapter_details,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    public function ChaperUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $chapter_master_id = filter_smart($post_data['chapter_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $chapter_name = filter_smart($post_data['chapter_name']);
        $chapter_info = filter_smart($post_data['chapter_info']);
        $chapter_status = filter_smart($post_data['chapter_status']);

        $get_Capter_Details = $this->Chapter_Model->getChapterDetailsByNameWithCategoryAndCourseForOtherId($course_category_id, $course_master_id, $chapter_master_id, $chapter_name);

        if(empty($get_Capter_Details)){

            $table_name = "chapter_master";

            $where = array("chapter_master_id" => $chapter_master_id);

            $update_array = array(
                "course_category_id"        => $course_category_id,
                "course_master_id"          => $course_master_id,
                "chapter_name"              => $chapter_name,
                "chapter_info"              => $chapter_info,
                "chapter_status"            => $chapter_status,
                "updated_date"              => date('Y-m-d H:i:s'),
                "updated_by"                => $branch_id,
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $status = true;
            $res_message = "Chapter updated successfully.";
            
        }
        else{
            $status = false;
            $res_message = "Chapter already exists in records, Please choose different Chapter name.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}