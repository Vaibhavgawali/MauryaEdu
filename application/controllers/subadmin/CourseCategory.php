<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CourseCategory extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkBranchAdminLoginSession();

        addJs(array("subadmin/course-category-list.js"));
        
        $login_detail = $this->session->userdata('login_detail');
        //print_r_custom($login_detail,1);
        $this->data['login_detail'] = $login_detail;
        $this->load->subadmintemplate('course-category-list', $this->data);
    }

    public function CourseCategoryAddProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $admin_id = $login_detail['admin_id'];
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_category_name = filter_smart($post_data['course_category_name']);
        $course_category_info = filter_smart($post_data['course_category_info']);

        $get_Course_Category_Details = $this->Course_Category_Model->getCourseCategoryDetailsByName($course_category_name);

        if(empty($get_Course_Category_Details)){

            $table_name = "course_category_master";

            $insert_array = array(
                "course_category_name"      => $course_category_name,
                "course_category_info"      => $course_category_info,
                "branch_id"                 => $branch_id,
                "course_category_status"    => '1',
                "created_date"              => date('Y-m-d H:i:s'),
                "created_by"                => $branch_id,
            );

            $course_category_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($course_category_id > 0){

                $status = true;
                $res_message = "Course category added successfully.";

            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Course category already exists in records, Please choose different Course category.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function CourseCategoryListAjax()
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
            0 => 'course_category_id',
            1 => 'course_category_name',
            2 => 'bm.branch_name' ,
            3 => 'course_category_status',
            4 => 'created_date',
            5 => 'updated_date',
        );
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 AND sm.branch_id IN (" . $login_detail['branch_id'] . ", 1)";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "sm.course_category_name like '%$searchTerm%' OR bm.branch_name like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Course_Category_Model->countAllCourseCategoryList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Course_Category_Model->listCourseCategoryQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['course_category_id'] = $start;
            $nestedData['course_category_name'] = $main['course_category_name'];

            $branch_name = $main['branch_name'];
            $created_by = ($branch_name == "Superadmin") ? "Superadmin" : "You";
            $nestedData['created_by'] = $created_by;

            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $course_category_id = $main['course_category_id'];
            
            $course_category_status = $main['course_category_status'];
            $status_display = "";

            if($course_category_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['status'] = $status_display;

            

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_course_category' id='".$course_category_id."'><i class='fa fa-eye'></i> View</a>";

            $action = "";
            
            $branch_name = $main['branch_name'];
            
            // Check if the branch name is not 'Superadmin' before adding the edit button
            if ($branch_name !== "Superadmin") {
                $action .= $edit_button;
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

        // print_r_custom($json_data,1);
        echo json_encode($json_data);
    }

    //get course category details
    public function GetCourseCategoryDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $course_category_details = array();
        $message = "Course category details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);

        $get_Course_Category_Details = $this->Course_Category_Model->getCourseCategoryDetailsById($course_category_id);

        if(count($get_Course_Category_Details) == 0){
            $status = false;
            $course_category_details = array();
            $message = "Course category details not found";
        }
        else{
            $status_html = null;

            $course_category_status = $get_Course_Category_Details['course_category_status'];

            if($course_category_status=="1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($course_category_status=="0"){
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0' selected>In-Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }

            $course_category_details = array(
                'course_category_id' => $get_Course_Category_Details['course_category_id'],
                'course_category_name' => $get_Course_Category_Details['course_category_name'],
                'course_category_info' => $get_Course_Category_Details['course_category_info'],
                'course_category_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'course_category_details'  => $course_category_details,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    // update course category
    public function CourseCategoryUpdateProcess()
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
        $course_category_name = filter_smart($post_data['course_category_name']);
        $course_category_info = filter_smart($post_data['course_category_info']);
        $course_category_status = filter_smart($post_data['course_category_status']);

        $get_Course_Category_Details = $this->Course_Category_Model->getCourseCategoryDetailsByNameWithOtherId($course_category_name, $course_category_id);

        if(empty($get_Course_Category_Details)){

            $table_name = "course_category_master";

            $where = array( "course_category_id" => $course_category_id);

            $update_array = array(
                "course_category_name"      => $course_category_name,
                "course_category_info"      => $course_category_info,
                "course_category_status"    => $course_category_status,
                "updated_date"              => date('Y-m-d H:i:s'),
                "updated_by"                => $branch_id,
            );

            $this->Common_Model->updateTable("$table_name", $update_array, $where);

            $status = true;
            $res_message = "Course category details updated successfully.";
            
        }
        else{
            $status = false;
            $res_message = "Course category already exists in records, Please choose different Course category.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}