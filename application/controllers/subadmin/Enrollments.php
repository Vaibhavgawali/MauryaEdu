<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Enrollments extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Admin/Student_List_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->model('Common/Certificate_Model');
        $this->load->model('Common/Id_Card_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkBranchAdminLoginSession();

        addJs(array("subadmin/enrollment-list.js"));
        addJs(array("subadmin/installment.js"));
        
        $login_detail = $this->session->userdata('login_detail');
        // print_r_custom($login_detail,1);
        $this->data['login_detail'] = $login_detail;
        $this->load->subadmintemplate('enrollment-list', $this->data);
    }

    public function StudentListAjax()
    {
        $login_detail = $this->session->userdata('login_detail');
        // print_r_custom($login_detail,1);

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
            0=>'em.student_id',
            1=>'sm.full_name',
            2=>'sm.emailid',
            3=>'sm.contact',
            4=>'cm.course_name',
            5=>'pm.course_actual_price',
            6=>'cm.paid_price',
            7=>'em.valid_upto',
            8=>'em.created_date',
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";
        $where .= " AND sm.branch_id = " . $login_detail['branch_id'];

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= " AND (";
            $where .= "sm.full_name like '%".$searchTerm."%'  OR  
                       sm.emailid like '%".$searchTerm."%' OR 
                       sm.contact like '%".$searchTerm."%' OR
                       cm.course_name like '%".$searchTerm."%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Student_List_Model->countAllEnrolledStudentList($where);
        $totalData = $total_count_array->total;

        /*Total Filter Record and fetch data*/
        $list_array = $this->Student_List_Model->listEnrolledStudentQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;

        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['student_id'] = $start;
            $nestedData['full_name'] = $main['full_name'];
            $nestedData['emailid'] = $main['emailid'];
            $nestedData['contact'] = $main['contact'];
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['course_actual_price'] = $main['course_actual_price'];
            $nestedData['paid_price'] = $main['paid_price'];
            $nestedData['valid_upto'] = date('d-m-Y H:i:s', strtotime($main['valid_upto']));
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));;

            $enrollment_id = $main['enrollment_master_id'];

            $current_date = date('Y-m-d H:i:s');
            $today = new Datetime($current_date);
            $validity_date = new Datetime($main['valid_upto']);

            if($today > $validity_date)
            {
                $nestedData['validity_status'] = "<span class='badge badge-danger'>Expired</span>";
            }
            else
            {
                $nestedData['validity_status'] = "<span class='badge badge-success'>Active</span>";
            }

            // course status for particular student
            $student_course_status=$main['enrollment_status'];
            if($student_course_status == 1)
            {
                $nestedData['status'] = "<span class='badge badge-success'>Active</span>";
            }
            else
            {
                $nestedData['status'] = "<span class='badge badge-danger'>Inactive</span>";
            }

            // $student_id = $main['student_id'];
            // $SHOP_STATUS = $SHOP_STATUS_ALERT = null;

            // $status_text = $main['status_text'];
            // $status_alert = $main['status_alert'];

            // $status_display = "<span class='badge badge-".$status_alert."'>".$status_text."</span>";

            // $nestedData['status'] = $status_display;

            

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_student_status' id='".$enrollment_id."'><i class='fa fa-eye'></i> View</a>";

            $delete_button = "<a href='javascript:void(0);' class='btn btn-danger btn-sm delete_student_enrollment' id='".$enrollment_id."'><i class='fa fa-trash'></i> Delete</a>";
            
            $add_certificate_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm add_certificate' id='".$enrollment_id."'><i class='fa fa-plus'></i> Add Certificate</a>";

            $add_id_card_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm add_id_card' id='".$enrollment_id."'><i class='fa fa-plus'></i> Add Id Card</a>";

            $action = "";
            $action .= $edit_button."&nbsp;&nbsp;&nbsp;".$delete_button;

            $student_id = $main['student_id'];

            $certificate_master_id = $main['certificate_master_id'];
            if ($certificate_master_id == null) {
                $action .= "&nbsp;&nbsp;&nbsp;" . $add_certificate_button;
            }else{
                $update_certificate_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_certificate' id='".$certificate_master_id."' enrollment_id='".$enrollment_id."' student_id='".$student_id."'><i class='fa fa-eye'></i> View Certificate</a>";
                $action .= "&nbsp;&nbsp;&nbsp;" . $update_certificate_button;
            }

            $id_card_master_id = $main['id_card_master_id'];
            if ($id_card_master_id == null) {
                $action .= "&nbsp;&nbsp;&nbsp;" . $add_id_card_button;
            }else{
                $update_id_card_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_id_card' id='".$id_card_master_id."' enrollment_id='".$enrollment_id."' student_id='".$student_id."'><i class='fa fa-eye'></i> View Id Card</a>";
                $action .= "&nbsp;&nbsp;&nbsp;" . $update_id_card_button;
            }

            $payment_status = $main['payment_status'];
            if($payment_status == "Pending"){
                $payment_master_id=$main['payment_master_id'];
                $payment_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm payment_btn' id='".$payment_master_id."' enrollment_id='".$enrollment_id."' student_id='".$student_id."' course_price='".$main['paid_price']."'><i class='fa fa-plus'></i>Make Payment</a>";
                $action .= "&nbsp;&nbsp;&nbsp;" . $payment_button;
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
        // print_r_custom($json_data);
    }

    //get enrollment details of student
    public function GetEnrollmentStudentsDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $enrollment_student_details = array();
        $message = "Student details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);
        $get_Enrolllment_Student_Details = $this->Enrollment_Model->getEnrollmentDetailsById($enrollment_id);

        if(count($get_Enrolllment_Student_Details) == 0){
            $status = false;
            $enrollment_student_details = array();
            $message = "Course category details not found";
        }
        else{
            $status_html = null;

            $student_course_status = $get_Enrolllment_Student_Details['enrollment_status'];

            if($student_course_status == "1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($student_course_status == "0" ){
                $status_html .= "<option value='0' selected>In-Active</option>";
                $status_html .= "<option value='1'>Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
        // print_r_custom($status_html);

            $enrollment_student_details = array(
                'enrollment_id' => $get_Enrolllment_Student_Details['enrollment_master_id'],
                'enrollment_student_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'enrollment_student_details' => $enrollment_student_details,
            'message'   => $message
        );

        echo json_encode($response);
        // exit;
    }
   
    // update enrollment details of student
    public function EnrollmentStudentUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['admin_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);
        $enrollment_student_status = filter_smart($post_data['enrollment_student_status']);

        // print_r_custom($enrollment_student_status);

        $get_Enrolllment_Student_Details = $this->Enrollment_Model->getEnrollmentDetailsById($enrollment_id);

        // print_r_custom($get_Enrolllment_Student_Details);

        if(count($get_Enrolllment_Student_Details)){
            // if(empty($get_Enrolllment_Student_Details)){

            $table_name = "enrollment_master";

            $where = array( "enrollment_master_id" => $enrollment_id);

            $update_array = array(     
                "enrollment_status" => $enrollment_student_status,
            );

            $result= $this->Common_Model->updateTable("$table_name", $update_array, $where);
        
            if($result){
                $status = true;
                $res_message = "Student Enrollment details updated successfully.";
            }else{
                $status = false;
                $res_message = "Something went wrong!";
            }
        }
        else{
            $status = false;
            $res_message = "Student Enrollment does exists in records.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message,
            // 'data'=>$update_array,
            // 'id'=>$where
        );

        echo json_encode($response);
        exit;
    }

    // delete enrollment details of student
    public function DeleteEnrollmentStudent()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['admin_id'];

        $status = true;
        $message = "Enrollment of Student deleted successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);

        $del_enrollment = $this->Enrollment_Model->deleteEnrollmentById($enrollment_id);

        if($del_enrollment == false){
            $status = false;
            $message = "Something went wrong !";
        }

        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    // add certificate
    public function AddStudentsCertificateDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);
        $certificate_title = filter_smart($post_data['certificate_title']);

        // print_r_custom($certificate_title);
        // exit();

        $get_Enrolllment_Student_Details = $this->Enrollment_Model->getEnrollmentDetailsById($enrollment_id);
        // print_r_custom($get_Enrolllment_Student_Details,1);
        $student_id=$get_Enrolllment_Student_Details['student_id'];
        if(!empty($get_Enrolllment_Student_Details)){

            $table_name = "certificate_master";

            $insert_array = array(
                "enrollment_id"         => $enrollment_id,
                "certificate_status"       => '1',
                "created_date"          => date('Y-m-d H:i:s'),
                "created_by"            => $branch_id
            );

            $certificate_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($certificate_master_id > 0){

                    // Update enrollments table
                $table_name_1="enrollment_master";

                $where = array('enrollment_master_id' => $enrollment_id);

                $update_array = array(
                    'certificate_master_id' => $certificate_master_id
                );

                $this->Common_Model->updateTable($table_name_1, $update_array, $where);

                try{

                    $ext = pathinfo($_FILES['certificate_file']['name'], PATHINFO_EXTENSION);

                    $imageName = md5($certificate_master_id.time()). '.'.$ext;

                    $target_dir = "uploads/student/".$student_id."/certificates/".$certificate_master_id."/";

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
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $imageName;
                    
                    $this->upload->initialize($config);
                    //$this->load->library('upload', $config);

                    if (!$this->upload->do_upload('certificate_file')) {
                        //print_r_custom($this->upload->display_errors(),1);
                        $status = false;
                        $res_message = "Error occured while uploading certificate.";
                    } else {

                        $where = array('certificate_master_id' => $certificate_master_id);

                        $update_array = array(
                            "certificate_title"    => $certificate_title,
                            "certificate_file"     => $imageName,
                        );

                        if($this->Common_Model->updateTable($table_name, $update_array, $where)){
                            $status = true;
                            $res_message = "Certificate uploaded successfully.";
                        }
                        else{
                            $status = false;
                            $res_message = "Something went wrong !";
                        }
                        
                    }
                }
                catch (Exception $e) 
                {
                    $status = true;
                    $res_message = "Error in certificate upload";
                }
                
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Enrollment details not available in records. Please try again";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    //get certificate details of student
    public function GetStudentsCertificateDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $enrollment_student_details = array();
        $message = "Certificate details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $certificate_master_id = filter_smart($post_data['certificate_master_id']);
        $get_Certificate_Details = $this->Certificate_Model->getCertificateDetailsById($certificate_master_id);
        // print_r_custom($get_Certificate_Details,1);

        if(count($get_Certificate_Details) == 0){
            $status = false;
            $certificate_details = array();
            $message = "Certificate details not found";
        }
        else{
            $status_html = null;

            $certificate_status = $get_Certificate_Details['certificate_status'];

            if($certificate_status == "1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($certificate_status == "0" ){
                $status_html .= "<option value='0' selected>In-Active</option>";
                $status_html .= "<option value='1'>Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
        // print_r_custom($status_html);

            $certificate_details = array(
                'certificate_master_id' => $get_Certificate_Details['certificate_master_id'],
                'certificate_title' => $get_Certificate_Details['certificate_title'],
                'certificate_file' => $get_Certificate_Details['certificate_file'],
                'certificate_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'certificate_details' => $certificate_details,
            'message'   => $message
        );
        // print_r_custom($response);

        echo json_encode($response);
        // exit;
    }

    //update certificate details of student
    public function StudentsCertificateUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        extract($post_data);
        $certificate_master_id = filter_smart($post_data['certificate_master_id']);
        $student_id = filter_smart($post_data['student_id']);
        $certificate_title = filter_smart($post_data['certificate_title']);
        $document_status = filter_smart($post_data['certificate_status']);

        $get_Certificate_Details = $this->Certificate_Model->getCertificateDetailsById($certificate_master_id);
        // print_r_custom($get_Certificate_Details,1);

        if(!empty($get_Certificate_Details)){

            $table_name = "certificate_master";

            $where = array("certificate_master_id" => $certificate_master_id);

            $update_array = array(
                "certificate_title"     => $certificate_title,
                "certificate_status"    => $certificate_status,
                "updated_date"          => date('Y-m-d H:i:s'),
                "updated_by"            => $branch_id,
            );

            $is_updated_document = $this->Common_Model->updateTable($table_name, $update_array, $where);

            if($is_updated_document){

                if(count($_FILES) > 0){

                    try{

                        $ext = pathinfo($_FILES['certificate_file']['name'], PATHINFO_EXTENSION);
    
                        $certificateName = md5($certificate_master_id.time()). '.'.$ext;
    
                        $target_dir = "uploads/student/".$student_id."/certificates/".$certificate_master_id."/";
    
                        //----- [START] --- Delete current certificate
                        $curr_certificate =  $get_Certificate_Details['certificate_file'];
                        
                        unlink($target_dir.$curr_certificate);
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
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $certificateName;
                        
                        $this->upload->initialize($config);
                        //$this->load->library('upload', $config);
    
                        if (!$this->upload->do_upload('certificate_file')) {
                            //print_r_custom($this->upload->display_errors(),1);
                            $status = false;
                            $res_message = "Error occured while uploading certificate.";
                        } else {
    
                            $where = array('certificate_master_id' => $certificate_master_id);
    
                            $update_array = array(
                                "certificate_file" => $certificateName
                            );
    
                            $this->Common_Model->updateTable($table_name, $update_array, $where);
    
                            $status = true;
                            $res_message = "Certificate details updated successfully.";
                        }
                    }
                    catch (Exception $e) 
                    {
                        $status = true;
                        $res_message = "Error in chapter document upload";
                    }
                }
                else{
                    $status = true;
                    $res_message = "Certificate details updated successfully.";
                }
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Certificate details not available in records. Please try again";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    // add id card
    public function AddStudentsIdCardDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $enrollment_id = filter_smart($post_data['enrollment_id']);
        $id_card_title = filter_smart($post_data['id_card_title']);

        // print_r_custom($certificate_title);
        // exit();

        $get_Enrolllment_Student_Details = $this->Enrollment_Model->getEnrollmentDetailsById($enrollment_id);
        // print_r_custom($get_Enrolllment_Student_Details,1);
        $student_id=$get_Enrolllment_Student_Details['student_id'];
        if(!empty($get_Enrolllment_Student_Details)){

            $table_name = "id_card_master";

            $insert_array = array(
                "enrollment_id"         => $enrollment_id,
                "id_card_status"    => '1',
                "created_date"          => date('Y-m-d H:i:s'),
                "created_by"            => $branch_id
            );

            $id_card_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($id_card_master_id > 0){

                    // Update enrollments table
                $table_name_1="enrollment_master";

                $where = array('enrollment_master_id' => $enrollment_id);

                $update_array = array(
                    'id_card_master_id' => $id_card_master_id
                );

                $this->Common_Model->updateTable($table_name_1, $update_array, $where);

                try{

                    $ext = pathinfo($_FILES['id_card_file']['name'], PATHINFO_EXTENSION);

                    $imageName = md5($id_card_master_id.time()). '.'.$ext;

                    $target_dir = "uploads/student/".$student_id."/id-card/";

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
                    $config['allowed_types'] = '*';
                    $config['file_name'] = $imageName;
                    
                    $this->upload->initialize($config);

                    if (!$this->upload->do_upload('id_card_file')) {
                        $status = false;
                        $res_message = "Error occured while uploading id card.";
                    } else {

                        $where = array('id_card_master_id' => $id_card_master_id);

                        $update_array = array(
                            "id_card_title"    => $id_card_title,
                            "id_card_file"     => $imageName,
                        );

                        if($this->Common_Model->updateTable($table_name, $update_array, $where)){
                            $status = true;
                            $res_message = "Id Card uploaded successfully.";
                        }
                        else{
                            $status = false;
                            $res_message = "Something went wrong !";
                        }
                        
                    }
                }
                catch (Exception $e) 
                {
                    $status = true;
                    $res_message = "Error in certificate upload";
                }
                
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Enrollment details not available in records. Please try again";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    //get id card details of student
    public function GetStudentsIdCardDetails()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $enrollment_student_details = array();
        $message = "Certificate details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $id_card_master_id = filter_smart($post_data['id_card_master_id']);
        $get_Id_Card_Details = $this->Id_Card_Model->getIdCardDetailsById($id_card_master_id);
        // print_r_custom($get_Id_Card_Details,1);

        if(count($get_Id_Card_Details) == 0){
            $status = false;
            $certificate_details = array();
            $message = "Id Card details not found";
        }
        else{
            $status_html = null;

            $id_card_status = $get_Id_Card_Details['id_card_status'];

            if($id_card_status == "1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($id_card_status == "0" ){
                $status_html .= "<option value='0' selected>In-Active</option>";
                $status_html .= "<option value='1'>Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            // print_r_custom($status_html);
            $id_card_details = array(
                'id_card_master_id' => $get_Id_Card_Details['id_card_master_id'],
                'id_card_title' => $get_Id_Card_Details['id_card_title'],
                'id_card_file' => $get_Id_Card_Details['id_card_file'],
                'id_card_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'id_card_details' => $id_card_details,
            'message'   => $message
        );
        // print_r_custom($response);

        echo json_encode($response);
        // exit;
    }

    //update id card details of student
    public function StudentsIdCardUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        extract($post_data);
        $id_card_master_id = filter_smart($post_data['id_card_master_id']);
        $student_id = filter_smart($post_data['student_id']);
        $id_card_title = filter_smart($post_data['id_card_title']);
        $id_card_status = filter_smart($post_data['id_card_status']);

        $get_Id_Card_Details = $this->Id_Card_Model->getIdCardDetailsById($id_card_master_id);
        // print_r_custom($get_Id_Card_Details,1);

        if(!empty($get_Id_Card_Details)){

            $table_name = "id_card_master";

            $where = array("id_card_master_id" => $id_card_master_id);

            $update_array = array(
                "id_card_title"     => $id_card_title,
                "id_card_status"    => $id_card_status,
                "updated_date"          => date('Y-m-d H:i:s'),
                "updated_by"            => $branch_id,
            );

            $is_updated_document = $this->Common_Model->updateTable($table_name, $update_array, $where);

            if($is_updated_document){

                if(count($_FILES) > 0){

                    try{

                        $ext = pathinfo($_FILES['id_card_file']['name'], PATHINFO_EXTENSION);
    
                        $idCardName = md5($id_card_master_id.time()). '.'.$ext;
    
                        $target_dir = "uploads/student/".$student_id."/id-card/";
    
                        //----- [START] --- Delete current certificate
                        $curr_id_card =  $get_Id_Card_Details['id_card_file'];
                        
                        unlink($target_dir.$curr_id_card);
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
                        $config['allowed_types'] = '*';
                        $config['file_name'] = $idCardName;
                        
                        $this->upload->initialize($config);
                        //$this->load->library('upload', $config);
    
                        if (!$this->upload->do_upload('id_card_file')) {
                            //print_r_custom($this->upload->display_errors(),1);
                            $status = false;
                            $res_message = "Error occured while uploading Id Card.";
                        } else {
    
                            $where = array('id_card_master_id' => $id_card_master_id);
    
                            $update_array = array(
                                "id_card_file" => $idCardName
                            );
    
                            $this->Common_Model->updateTable($table_name, $update_array, $where);
    
                            $status = true;
                            $res_message = "Id Card details updated successfully.";
                        }
                    }
                    catch (Exception $e) 
                    {
                        $status = true;
                        $res_message = "Error in Id Card upload";
                    }
                }
                else{
                    $status = true;
                    $res_message = "Id Card details updated successfully.";
                }
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Certificate details not available in records. Please try again";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }
}
