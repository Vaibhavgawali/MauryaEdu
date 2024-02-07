<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SubChaper extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Course_Model');
        $this->load->model('Common/Chapter_Model');
        $this->load->model('Common/Sub_Chapter_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkBranchAdminLoginSession();

        addJs(array("admin/sub-chaper-list.js"));
        
        $login_detail = $this->session->userdata('login_detail');

        $course_category_list = $this->Course_Category_Model->getAllCourseCategoryDetailsByStatus(1);
        $course_master_list = $this->Course_Model->getAllCourseDetailsByStatus(1);
        $chapter_master_list = $this->Chapter_Model->getAllChapterDetailsByStatus(1);
        //print_r_custom($course_category_list,1);

        $this->data['login_detail'] = $login_detail;
        $this->data['course_category_list'] = $course_category_list;
        $this->data['course_master_list'] = $course_master_list;
        $this->data['chapter_master_list'] = $chapter_master_list;

        $this->load->subadmintemplate('sub-chapter/sub-chapter-list', $this->data);
    }

    public function GetCapterListFromCourse(){
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = false;
        $chapter_details = array();
        $message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_master_id = filter_smart($post_data['course_master_id']);

        $get_chapter_details_From_Course_Id = $this->Chapter_Model->getChapterDetailsByCourseId($course_master_id);

        if(count($get_chapter_details_From_Course_Id) > 0){
            $status = true;
            $chapter_details = $get_chapter_details_From_Course_Id;
            $message = "Chapter details fetch successfully";
        }
        else{
            $status = false;
            $chapter_details = array();
            $message = "Chapter not available for this category";
        }

        $response = array(
            'status'    => $status,
            'chapter_details'  => $chapter_details,
            'message'   => $message
        );

        echo json_encode($response, TRUE);
        exit;
    }

    public function AddCourseSubChaper($chapter_master_id = '')
    {
        checkBranchAdminLoginSession();
        
        addJs(array("admin/sub-chaper-list.js"));

        $login_detail = $this->session->userdata('login_detail');

        $this->data['login_detail'] = $login_detail;

        $chapter_master_details = $this->Chapter_Model->getChapterDetailsById($chapter_master_id);
        
        if(count($chapter_master_details) > 0){

            $this->data['chapter_master_details'] = $chapter_master_details;

            $course_master_details = $this->Course_Model->getCourseDetailsById($chapter_master_details['course_master_id']);
            $this->data['course_master_details'] = $course_master_details;

            $course_category_details = $this->Course_Category_Model->getCourseCategoryDetailsById($chapter_master_details['course_category_id']);
            $this->data['course_category_details'] = $course_category_details;
            
            // print_r_custom($this->data,1);

            $this->load->subadmintemplate('sub-chapter/add-sub-chapter-details', $this->data);
        }
        else{
            echo "Invalid Parameters!!!";
        }
        exit;
    }

    public function SubChaperAddProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $chapter_master_id = filter_smart($post_data['chapter_master_id']);
        $sub_chapter_name = filter_smart($post_data['sub_chapter_name']);
        $sub_chapter_info = filter_smart($post_data['sub_chapter_info']);

        $get_Sub_Capter_Details = $this->Sub_Chapter_Model->getSubChapterDetailsByNameWithCategoryAndCourseAndChapter($course_category_id, $course_master_id, $chapter_master_id, $sub_chapter_name);

        if(empty($get_Sub_Capter_Details)){

            $table_name = "sub_chapter_master";

            $insert_array = array(
                "course_category_id"        => $course_category_id,
                "course_master_id"          => $course_master_id,
                "chapter_master_id"         => $chapter_master_id,
                "sub_chapter_name"          => $sub_chapter_name,
                "sub_chapter_info"          => $sub_chapter_info,
                "sub_chapter_status"        => '1',
                "created_date"              => date('Y-m-d H:i:s'),
                "created_by"                => $userinfo_id,
            );

            $sub_chapter_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($sub_chapter_master_id > 0){

                $status = true;
                $res_message = "Sub Chapter added successfully.";

            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Sub Chapter already exists in records, Please choose different Sub Chapter name.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function SubChaperListAjax()
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
            0=>'sub_chapter_master.sub_chapter_master_id',
            1=>'course_category_master.course_category_name',
            2=>'course_master.course_name',
            2=>'chapter_master.chapter_name',
            2=>'sub_chapter_master.sub_chapter_name',
            2=>'sub_chapter_master.sub_chapter_status',
            3=>'sub_chapter_master.created_date',
            4=>'sub_chapter_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " course_category_master.course_category_name like '%$searchTerm%' OR course_master.course_name like '%$searchTerm%' OR chapter_master.chapter_name like '%$searchTerm%' OR sub_chapter_master.sub_chapter_name like '%$searchTerm%'  ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Sub_Chapter_Model->countAllSubChapterList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Sub_Chapter_Model->listSubChapterQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['sub_chapter_master_id'] = $start;
            $nestedData['course_category_name'] = $main['course_category_name'];
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['chapter_name'] = $main['chapter_name'];
            $nestedData['sub_chapter_name'] = $main['sub_chapter_name'];

            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $sub_chapter_master_id = $main['sub_chapter_master_id'];

            $sub_chapter_status = $main['sub_chapter_status'];
            $status_display = "";

            if($sub_chapter_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['sub_chapter_status'] = $status_display;

            

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_sub_chaper' id='".$sub_chapter_master_id."'><i class='fa fa-eye'></i> View</a>";

            $add_sub_chapter_content = "<a href='".base_url()."admin/sub-chapter-data/".$sub_chapter_master_id."' class='btn btn-info btn-sm' id='".$sub_chapter_master_id."'><i class='fa fa-plus'></i> Add Sub Chapter Data</a>";

            $action = "";
            $action .= $edit_button;
            
            $nestedData['action'] = $action."&nbsp;&nbsp;&nbsp;".$add_sub_chapter_content;


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

    //get sub chapter details
    public function GetSubChaperDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $sub_chapter_details = array();
        $message = "Sub Chapter details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $sub_chapter_master_id = filter_smart($post_data['sub_chapter_master_id']);

        $get_Sub_Chapter_Details = $this->Sub_Chapter_Model->getSubChapterDetailsById($sub_chapter_master_id);

        if(count($get_Sub_Chapter_Details) == 0){
            $status = false;
            $sub_chapter_details = array();
            $message = "Chapter details not found";
        }
        else{
            $status_html = null;

            $sub_chapter_status = $get_Sub_Chapter_Details['sub_chapter_status'];

            if($sub_chapter_status=="1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($sub_chapter_status=="0"){
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0' selected>In-Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }

            $sub_chapter_details = array(
                'sub_chapter_master_id' => $get_Sub_Chapter_Details['sub_chapter_master_id'],
                'course_category_id' => $get_Sub_Chapter_Details['course_category_id'],
                'course_master_id' => $get_Sub_Chapter_Details['course_master_id'],
                'chapter_master_id' => $get_Sub_Chapter_Details['chapter_master_id'],
                'sub_chapter_name' => $get_Sub_Chapter_Details['sub_chapter_name'],
                'sub_chapter_info' => $get_Sub_Chapter_Details['sub_chapter_info'],
                'sub_chapter_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'sub_chapter_details'  => $sub_chapter_details,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    public function SubChaperUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $sub_chapter_master_id = filter_smart($post_data['sub_chapter_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $chapter_master_id = filter_smart($post_data['chapter_master_id']);
        $sub_chapter_name = filter_smart($post_data['sub_chapter_name']);
        $sub_chapter_info = filter_smart($post_data['sub_chapter_info']);
        $sub_chapter_status = filter_smart($post_data['sub_chapter_status']);

        $get_Sub_Capter_Details = $this->Sub_Chapter_Model->getSubChapterDetailsByNameWithCategoryAndCourseAndChapterForOtherId($course_category_id, $course_master_id, $chapter_master_id, $sub_chapter_master_id, $sub_chapter_name);

        if(empty($get_Sub_Capter_Details)){

            $table_name = "sub_chapter_master";

            $where = array("sub_chapter_master_id" => $sub_chapter_master_id);

            $update_array = array(
                "course_category_id"        => $course_category_id,
                "course_master_id"          => $course_master_id,
                "chapter_master_id"         => $chapter_master_id,
                "sub_chapter_name"          => $sub_chapter_name,
                "sub_chapter_info"          => $sub_chapter_info,
                "sub_chapter_status"        => $sub_chapter_status,
                "updated_date"              => date('Y-m-d H:i:s'),
                "updated_by"                => $userinfo_id,
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            $status = true;
            $res_message = "Sub Chapter updated successfully.";
            
        }
        else{
            $status = false;
            $res_message = "Sub Chapter already exists in records, Please choose different Sub Chapter name.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}