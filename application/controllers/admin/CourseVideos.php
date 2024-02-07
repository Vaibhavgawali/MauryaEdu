<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CourseVideos extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Course_Model');
        $this->load->model('Common/Course_Videos_Model');
        $this->load->helper('common_helper');
    }

    public function CourseVideosData($course_master_id = '')
    {
        checkAdminLoginSession();
        
        addJs(array("admin/course-videos.js"));

        $login_detail = $this->session->userdata('login_detail');

        $this->data['login_detail'] = $login_detail;
        $this->data['course_master_id'] = $course_master_id;

        $course_master_details = $this->Course_Model->getCourseDetailsById($course_master_id);
        
        if(count($course_master_details) > 0){
            $this->data['course_master_details'] = $course_master_details;

            $course_category_details = $this->Course_Category_Model->getCourseCategoryDetailsById($course_master_details['course_category_id']);
            $this->data['course_category_details'] = $course_category_details;
            
            // print_r_custom($this->data,1);

            $this->load->admintemplate('course-videos', $this->data);
        }
        else{
            echo "Invalid Parameters!!!";
        }
        exit;
    }

    public function CourseVideosAddProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $video_title = filter_smart($post_data['video_title']);
        $video_link = filter_smart($post_data['video_link']);

        $table_name = "course_video_master";

        $insert_array = array(
            "course_category_id"        => $course_category_id,
            "course_master_id"          => $course_master_id,
            "video_title"               => $video_title,
            "video_link"                => $video_link,
            "video_status"              => '1',
            "created_date"              => date('Y-m-d H:i:s'),
            "created_by"                => $userinfo_id,
        );

        $course_video_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

        if($course_video_master_id > 0){

            $status = true;
            $res_message = "Course video added successfully.";

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

    public function CourseVideosListAjax()
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

        $course_master_id = $requestData['course_master_id'];
        
        /*order by colum value*/
        $colums = array(
            0=>'course_video_master.course_video_master_id',
            1=>'course_category_master.course_category_name',
            2=>'course_master.course_name',
            3=>'course_video_master.video_link',
            4=>'course_video_master.video_status',
            5=>'course_video_master.created_date',
            6=>'course_video_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 AND course_video_master.course_master_id=$course_master_id ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " course_category_master.course_category_name like '%$searchTerm%' OR course_master.course_name like '%$searchTerm%' OR course_video_master.video_link like '%$searchTerm%'  ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Course_Videos_Model->countAllCourseVideosList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Course_Videos_Model->listCourseVideosQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['course_video_master_id'] = $start;
            $nestedData['course_category_name'] = $main['course_category_name'];
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['video_link'] = "<a href='".$main['video_link']."' target='_blank'>".$main['video_link']."</a>";

            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $course_video_master_id = $main['course_video_master_id'];
            $video_title = $main['video_title'];
            $video_link = $main['video_link'];
            
            $video_status = $main['video_status'];
            $status_display = "";

            if($video_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['video_status'] = $status_display;

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_course_videos' id='".$course_video_master_id."' video_title='".$video_title."' video_link='".$video_link."' video_status='".$video_status."'><i class='fa fa-pencil'></i> Edit</a>";

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

    public function CourseVideosUpdateProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_video_master_id = filter_smart($post_data['course_video_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $video_title = filter_smart($post_data['video_title']);
        $video_link = filter_smart($post_data['video_link']);
        $video_status = filter_smart($post_data['video_status']);

        $table_name = "course_video_master";

        $where = array("course_video_master_id" => $course_video_master_id);

        $update_array = array(
            "course_category_id"        => $course_category_id,
            "course_master_id"          => $course_master_id,
            "video_title"               => $video_title,
            "video_link"                => $video_link,
            "video_status"              => $video_status,
            "updated_date"              => date('Y-m-d H:i:s'),
            "updated_by"                => $userinfo_id,
        );

        $this->Common_Model->updateTable($table_name, $update_array, $where);

        $status = true;
        $res_message = "Course video updated successfully.";
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}