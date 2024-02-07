<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Course extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        
        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Course_Model');
        $this->load->model('Common/Chapter_Model');
        $this->load->model('Common/Chapter_Documents_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    public function index()
    {
        checkBranchAdminLoginSession();

        addJs(array("subadmin/course-list.js"));
        
        $login_detail = $this->session->userdata('login_detail');

        $where = " AND branch_id IN (" . $login_detail['branch_id'] . ")";

        $course_category_list = $this->Course_Category_Model->getAllCourseCategoryDetailsByStatus(1,$where);
        // print_r_custom($course_category_list,1);

        $this->data['login_detail'] = $login_detail;
        $this->data['course_category_list'] = $course_category_list;

        $this->load->subadmintemplate('course-list', $this->data);
    }

    public function CourseAddProcess()
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
        $course_name = filter_smart($post_data['course_name']);
        $course_info = $post_data['course_info'];
        //$course_image = filter_smart($post_data['course_image']);
        $course_actual_price = filter_smart($post_data['course_actual_price']);
        $course_sell_price = filter_smart($post_data['course_sell_price']);
        $course_duration_number_of_days = filter_smart($post_data['course_duration_number_of_days']);
        $course_number_of_installments = filter_smart($post_data['course_number_of_installments']);
        $course_start_date = filter_smart($post_data['course_start_date']);
        $course_end_date = filter_smart($post_data['course_end_date']);
        $is_allow_purchase_after_expire = filter_smart($post_data['is_allow_purchase_after_expire']);
        $telegram_group_link = filter_smart($post_data['telegram_group_link']);
        $whatsapp_group_link = filter_smart($post_data['whatsapp_group_link']);

        $course_start_date = date('Y-m-d', strtotime($course_start_date));
        $course_end_date = date('Y-m-d', strtotime($course_end_date));

        $get_Course_Details = $this->Course_Model->getCourseDetailsByNameAndCategory($course_name, $course_category_id);
        
        if(empty($get_Course_Details)){

            $table_name = "course_master";

            $insert_array = array(
                "course_category_id"                => $course_category_id,
                "branch_id"                         => $branch_id,
                "course_name"                       => $course_name,
                "course_info"                       => $course_info,
                "course_actual_price"               => $course_actual_price,
                "course_sell_price"                 => $course_sell_price,
                "course_duration_number_of_days"    => $course_duration_number_of_days,
                "course_number_of_installments"     => $course_number_of_installments,
                "course_start_date"                 => $course_start_date,
                "course_end_date"                   => $course_end_date,
                "is_allow_purchase_after_expire"    => $is_allow_purchase_after_expire,
                "telegram_group_link"               => $telegram_group_link,
                "whatsapp_group_link"               => $whatsapp_group_link,
                "course_status"                     => '1',
                "created_date"                      => date('Y-m-d H:i:s'),
                "created_by"                        => $branch_id,
            );

            $course_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($course_master_id > 0){
                try{

                    $ext = pathinfo($_FILES['course_image']['name'], PATHINFO_EXTENSION);

                    $imageName = md5(time()). '.'.$ext;

                    $target_dir = "uploads/course/".$course_master_id."/course-image/";

                    if (!file_exists($target_dir)) 
                    {
                        try 
                        {
                            mkdir($target_dir, 0777, true);
                        } 
                        catch (Exception $ex) 
                        {
                        die("error");
                        }
                    }

                    //upload file
                    $config['upload_path'] = $target_dir;
                    $config['allowed_types'] = 'jpg|JPG|jpeg|JPEG|png|PNG';
                    $config['file_name'] = $imageName;
                    
                    $this->upload->initialize($config);
                    //$this->load->library('upload', $config);

                    if (!$this->upload->do_upload('course_image')) {
                        //print_r_custom($this->upload->display_errors(),1);
                        $status = false;
                        $res_message = "Error occured while uploading course image.";
                    } else {

                        $where = array('course_master_id' => $course_master_id);

                        $update_array = array(
                            "course_image" => $imageName
                        );

                        $this->Common_Model->updateTable($table_name, $update_array, $where);

                        $status = true;
                        $res_message = "Course added successfully.";
                    }
                }
                catch (Exception $e) 
                {
                    $status = true;
                    $res_message = "Error in course image upload";
                }
                
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Course name already exists in records, Please choose different Course name.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function CourseListAjax()
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
            0=>'cm.course_master_id',
            1=>'ccm.course_category_name',
            2=>'cm.course_name',
            3=>'cm.course_image',
            4=>'cm.course_start_date',
            5=>'cm.course_end_date',
            6=>'bm.branch_name',
            7=>'cm.is_allow_purchase_after_expire',
            8=>'cm.course_duration_number_of_days',
            9=>'cm.course_actual_price',
            10=>'cm.course_sell_price',
            11=>'cm.course_number_of_installments',
            12=>'cm.course_status',
            13=>'cm.created_date',
            14=>'cm.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 AND cm.branch_id IN (" . $login_detail['branch_id'] . ", 1)";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " ccm.course_category_name like '%$searchTerm%' OR cm.course_name like '%$searchTerm%' OR cm.course_duration_number_of_days like '%$searchTerm%' OR cm.course_actual_price like '%$searchTerm%' OR cm.course_sell_price like '%$searchTerm%' OR cm.course_number_of_installments like '%$searchTerm%'  ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Course_Model->countAllCourseList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Course_Model->listCourseQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['course_master_id'] = $start;
            $nestedData['course_category_name'] = $main['course_category_name'];
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['course_start_date'] = ($main['course_start_date'] != NULL) ? date('d-m-Y', strtotime($main['course_start_date'])) : "-";
            $nestedData['course_end_date'] = ($main['course_end_date'] != NULL) ? date('d-m-Y', strtotime($main['course_end_date'])) : "-";
            $nestedData['course_actual_price'] = $main['course_actual_price'];
            $nestedData['course_sell_price'] = $main['course_sell_price'];
            $nestedData['course_duration_number_of_days'] = $main['course_duration_number_of_days'];
            $nestedData['course_number_of_installments'] = $main['course_number_of_installments'];

            $branch_name = $main['branch_name'];
            $created_by = ($branch_name == "Superadmin") ? "Superadmin" : "You";
            $nestedData['created_by'] = $created_by;

            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $course_master_id = $main['course_master_id'];

            $course_image = $main['course_image'];
            $target_dir = "uploads/course/".$course_master_id."/course-image/";
            $img_path = "";
            $img_path = base_url().$target_dir.$course_image;
            $nestedData['course_image'] = "";
            $nestedData['course_image'] = "<a href='".$img_path."' target='_blank'><img src='".$img_path."' style='width:120px!important;max-width: none!important;max-height: 80px!important;'></a>";
            
            $course_status = $main['course_status'];
            $status_display = "";
            if($course_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }
            $nestedData['course_status'] = $status_display;

            $is_allow_purchase_after_expire = $main['is_allow_purchase_after_expire'];
            $is_allow_purchase_after_expire_display = "";

            if($is_allow_purchase_after_expire == 1){
                $is_allow_purchase_after_expire_display = "<span class='badge badge-success'>Yes</span>";
            }
            else{
                $is_allow_purchase_after_expire_display = "<span class='badge badge-danger'>No</span>";
            }

            $nestedData['is_allow_purchase_after_expire'] = $is_allow_purchase_after_expire_display;

            $course_category_id = $main['course_category_id'];

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_course' id='".$course_master_id."'><i class='fa fa-eye'></i> View</a>";

            $add_chapter_button = "<a href='".base_url()."subadmin/chapter-list/".$course_master_id."' class='btn btn-info btn-sm' id='".$course_master_id."'><i class='fa fa-plus'></i> Add Chapters</a>";

            // $add_course_content = "<a href='".base_url()."admin/course-videos/".$course_master_id."' class='btn btn-info btn-sm' id='".$course_master_id."'><i class='fa fa-plus'></i> Add Course Live/Recorded Video Links</a>";

            // $new_course_notification_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm new_course_notification' id='".$course_master_id."' course_category_id='".$course_category_id."'><i class='fa fa-envelope'></i> Send New Course Notification</a>";

            $delete_button = "<a href='javascript:void(0);' class='btn btn-danger btn-sm delete_course' id='".$course_master_id."'><i class='fa fa-trash'></i> Delete</a>";

            $action = "";

            if ($branch_name !== "Superadmin") {
                // $action .= $edit_button."&nbsp;&nbsp;&nbsp;".$add_chapter_button."&nbsp;&nbsp;&nbsp;".$add_course_content."&nbsp;&nbsp;&nbsp;".$new_course_notification_button."&nbsp;&nbsp;&nbsp;".$delete_button;
                $action .= $edit_button."&nbsp;&nbsp;&nbsp;".$add_chapter_button."&nbsp;&nbsp;&nbsp;".$delete_button;
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

    //get course details
    public function GetCourseDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $course_details = array();
        $message = "Course details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_master_id = filter_smart($post_data['course_master_id']);

        $get_Course_Details = $this->Course_Model->getCourseDetailsById($course_master_id);

        if(count($get_Course_Details) == 0){
            $status = false;
            $course_details = array();
            $message = "Course details not found";
        }
        else{
            $status_html = null;

            $course_status = $get_Course_Details['course_status'];

            if($course_status=="1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($course_status=="0"){
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0' selected>In-Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }

            $course_image = $get_Course_Details['course_image'];
            $target_dir = "uploads/course/".$course_master_id."/course-image/";
            $img_path = "";
            $img_path = base_url().$target_dir.$course_image;

            $course_start_date = $course_end_date = '';

            $course_start_date_db = $get_Course_Details['course_start_date'];
            if($course_start_date_db != NULL && $course_start_date_db != '0000-00-00'){
                $course_start_date = date('m/d/Y', strtotime($get_Course_Details['course_start_date']));
            }

            $course_end_date_db = $get_Course_Details['course_end_date'];
            if($course_end_date_db != NULL && $course_end_date_db != '0000-00-00'){
                $course_end_date = date('m/d/Y', strtotime($get_Course_Details['course_end_date']));
            }

            $course_details = array(
                'course_master_id' => $get_Course_Details['course_master_id'],
                'course_category_id' => $get_Course_Details['course_category_id'],
                'course_name' => $get_Course_Details['course_name'],
                'course_info' => $get_Course_Details['course_info'],
                'course_image' => "<img src='".$img_path."' style='width:120px!important;max-width: none!important;'>",
                'course_actual_price' => $get_Course_Details['course_actual_price'],
                'course_sell_price' => $get_Course_Details['course_sell_price'],
                'course_duration_number_of_days' => $get_Course_Details['course_duration_number_of_days'],
                'course_number_of_installments' => $get_Course_Details['course_number_of_installments'],
                'course_start_date' => $course_start_date,
                'course_end_date' => $course_end_date,
                'is_allow_purchase_after_expire' => $get_Course_Details['is_allow_purchase_after_expire'],
                'telegram_group_link' => $get_Course_Details['telegram_group_link'],
                'whatsapp_group_link' => $get_Course_Details['whatsapp_group_link'],
                'course_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'course_details'  => $course_details,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    public function CourseUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_name = filter_smart($post_data['course_name']);
        $course_info = $post_data['course_info'];
        //$course_image = filter_smart($post_data['course_image']);
        $course_actual_price = filter_smart($post_data['course_actual_price']);
        $course_sell_price = filter_smart($post_data['course_sell_price']);
        $course_duration_number_of_days = filter_smart($post_data['course_duration_number_of_days']);
        $course_number_of_installments = filter_smart($post_data['course_number_of_installments']);
        $course_start_date = filter_smart($post_data['course_start_date']);
        $course_end_date = filter_smart($post_data['course_end_date']);
        $is_allow_purchase_after_expire = filter_smart($post_data['is_allow_purchase_after_expire']);
        $telegram_group_link = filter_smart($post_data['telegram_group_link']);
        $whatsapp_group_link = filter_smart($post_data['whatsapp_group_link']);
        $course_status = filter_smart($post_data['course_status']);

        $course_start_date = date('Y-m-d', strtotime($course_start_date));
        $course_end_date = date('Y-m-d', strtotime($course_end_date));
        
        $get_Course_Details = $this->Course_Model->getCourseDetailsByNameAndCategoryForOtherId($course_name, $course_category_id, $course_master_id);
        
        if(empty($get_Course_Details)){

            $table_name = "course_master";

            $where = array('course_master_id' => $course_master_id);

            $update_array = array(
                "course_category_id"                => $course_category_id,
                "course_name"                       => $course_name,
                "course_info"                       => $course_info,
                "course_actual_price"               => $course_actual_price,
                "course_sell_price"                 => $course_sell_price,
                "course_duration_number_of_days"    => $course_duration_number_of_days,
                "course_number_of_installments"     => $course_number_of_installments,
                "course_start_date"                 => $course_start_date,
                "course_end_date"                   => $course_end_date,
                "is_allow_purchase_after_expire"    => $is_allow_purchase_after_expire,
                "telegram_group_link"               => $telegram_group_link,
                "whatsapp_group_link"               => $whatsapp_group_link,
                "course_status"                     => $course_status,
                "updated_date"                      => date('Y-m-d H:i:s'),
                "updated_by"                        => $branch_id,
            );

            $this->Common_Model->updateTable($table_name, $update_array, $where);

            if(count($_FILES) > 0){
                
                try{

                    $ext = pathinfo($_FILES['course_image']['name'], PATHINFO_EXTENSION);

                    $imageName = md5(time()). '.'.$ext;

                    $target_dir = "uploads/course/".$course_master_id."/course-image/";

                    //----- [START] --- Delete current course image
                    $curr_course_detail =  $this->Course_Model->getCourseDetailsById($course_master_id);
                    
                    unlink($target_dir.$curr_course_detail['course_image']);
                    //----- [END] --- 

                    if (!file_exists($target_dir)) 
                    {
                        try 
                        {
                            mkdir($target_dir, 0777, true);
                        } 
                        catch (Exception $ex) 
                        {
                        die("error");
                        }
                    }

                    //upload file
                    $config['upload_path'] = $target_dir;
                    $config['allowed_types'] = 'jpg|JPG|jpeg|JPEG|png|PNG';
                    $config['file_name'] = $imageName;
                    
                    $this->upload->initialize($config);
                    //$this->load->library('upload', $config);

                    if (!$this->upload->do_upload('course_image')) {
                        //print_r_custom($this->upload->display_errors(),1);
                        $status = false;
                        $res_message = "Error occured while uploading course image: ".$this->upload->display_errors();
                    } else {

                        $update_course_array = array(
                            "course_image" => $imageName
                        );

                        $this->Common_Model->updateTable($table_name, $update_course_array, $where);

                        $status = true;
                        $res_message = "Course details updated successfully.";
                    }
                }
                catch (Exception $e) 
                {
                    $status = true;
                    $res_message = "Error in course image upload";
                }
                
            }
            else{

                $status = true;
                $res_message = "Course details updated successfully.";
            }
        }
        else{
            $status = false;
            $res_message = "Course name already exists in records, Please choose different Course name.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function NewCourseSendNotification()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);

        $Course_Details = $this->Course_Model->getCourseDetailsById($course_master_id);

        
        if(!empty($Course_Details)){

            $course_name = $Course_Details['course_name'];

            $Enrolled_Students = $this->Enrollment_Model->getEnrollmentDetailsByCourseCategoryId($course_category_id);
            
            if(count($Enrolled_Students)>0){
                
                for($i=0; $i<count($Enrolled_Students); $i++){
                    $student_details = $this->Student_Details_Model->getStudentDetailsById($Enrolled_Students[$i]['student_id']);

                    if($student_details){
                        $full_name = "";
                        $emailid = "";
                        $contact = "";

                        $full_name = $student_details['full_name'];
                        $emailid = $student_details['emailid'];
                        $contact = $student_details['contact'];

                        //--- sms notification
                        if(IS_LIVE){
                            sendNewCoursePublishedSMS($full_name, $contact, $course_name);
                        }

                        //--- email notification
                        $message = "Dear ".$full_name.",<br><br>";

                        $message .= "New course '".$course_name."' has been published !<br><br>";

                        $message .= "Enroll yourself to get access.<br><br>";
                        
                        $message .= "<b>Note:</b> This is a system generated email. Please do not reply to this email.<br><br>";
                        $message .= "Thanks,<br> ChemCaliba";

                        if(IS_LIVE){
                            sendEmail($emailid, 'New Course Published - '.COMPANY_NAME, $message, "", "", '', '','');
                        }
                    }
                }

            }

            $status = true;
            $res_message = "New course published notification sent successfully.";
        }
        else{
            $status = false;
            $res_message = "Course details details not found in records...";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function CourseDelete()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $admin_id = $login_detail['admin_id'];
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $course_master_id = filter_smart($post_data['course_master_id']);

        // print_r($course_master_id); 
        // $course_master_id = 4;

        $get_Course_Chapter_Documents_Details = $this->Course_Model->getCourseAndChapterAndDocumentsDetailsByCourseId(intval($course_master_id));
        
        // print_r("<pre>");
        // print_r($get_Course_Chapter_Documents_Details[0]['course_image']);
        // print_r($get_Course_Chapter_Documents_Details);
        // echo json_encode($get_Course_Chapter_Documents_Details[0]);

        if($get_Course_Chapter_Documents_Details){

            $target_dir = "uploads/course/".$course_master_id."/course-image/";

            //----- [START] --- Delete course image
            
            if($get_Course_Chapter_Documents_Details[0]['course_image']){
                unlink($target_dir.$get_Course_Chapter_Documents_Details[0]['course_image']);
            }
            //----- [END] --- 

            //----- [START] --- Delete chapter documents
            // $is_deleted_chapter_doc="";

            for($i=0;$i<count($get_Course_Chapter_Documents_Details);$i++){

                if($get_Course_Chapter_Documents_Details[$i]['document_file']){

                    unlink("uploads/chapter/".$get_Course_Chapter_Documents_Details[$i]['chapter_master_id']."/chapter-documents/".$get_Course_Chapter_Documents_Details[$i]['chapter_document_master_id']."/".$get_Course_Chapter_Documents_Details[$i]['document_file']); 
                }
            }
            //----- [END] --- 

            if(true){
                $delete_Course_Chapter_Documents_Details = $this->Course_Model->deleteCourseAndChapterAndDocumentsDetailsByCourseId($course_master_id);

                if($delete_Course_Chapter_Documents_Details){

                    $status = true;
                    $res_message = "Course details deleted successfully.";

                }else{

                    $status = false;
                    $res_message = "Something went wrong1";
                }
            }else{

                $status = false;
                $res_message = "Something went wrong2";
            }     
        }
        else{
            $status = false;
            $res_message = "Course details does not exists in records.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }
}