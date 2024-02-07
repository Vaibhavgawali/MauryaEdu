<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ChapterDocuments extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Course_Model');
        $this->load->model('Common/Chapter_Model');
        $this->load->model('Common/Chapter_Documents_Model');
        $this->load->helper('common_helper');
    }

    public function ChapterDocumentsDetails($chapter_master_id = '')
    {
        checkBranchAdminLoginSession();
        
        addJs(array("subadmin/chapter-documents.js"));

        $login_detail = $this->session->userdata('login_detail');

        $this->data['login_detail'] = $login_detail;
        $this->data['chapter_master_id'] = $chapter_master_id;

        $chapter_master_details = $this->Chapter_Model->getChapterDetailsById($chapter_master_id);
         
        if(count($chapter_master_details) > 0){

            $this->data['chapter_master_details'] = $chapter_master_details;

            $course_master_details = $this->Course_Model->getCourseDetailsById($chapter_master_details['course_master_id']);
            $this->data['course_master_details'] = $course_master_details;

            $course_category_details = $this->Course_Category_Model->getCourseCategoryDetailsById($chapter_master_details['course_category_id']);
            $this->data['course_category_details'] = $course_category_details;
            
            // print_r_custom($this->data,1);

            $this->load->subadmintemplate('chapter/add-chapter-documents', $this->data);
        }
        else{
            echo "Invalid Parameters!!!";
        }
        exit;
    }

    public function ViewChapterDocumentsDetails($chapter_master_id = '')
    {
        checkBranchAdminLoginSession();
        
        addJs(array("subadmin/chapter-documents.js"));

        $login_detail = $this->session->userdata('login_detail');

        $this->data['login_detail'] = $login_detail;
        $this->data['chapter_master_id'] = $chapter_master_id;

        $chapter_master_details = $this->Chapter_Model->getChapterDetailsById($chapter_master_id);
         
        if(count($chapter_master_details) > 0){

            $this->data['chapter_master_details'] = $chapter_master_details;

            $course_master_details = $this->Course_Model->getCourseDetailsById($chapter_master_details['course_master_id']);
            $this->data['course_master_details'] = $course_master_details;

            $course_category_details = $this->Course_Category_Model->getCourseCategoryDetailsById($chapter_master_details['course_category_id']);
            $this->data['course_category_details'] = $course_category_details;
            
            // print_r_custom($this->data,1);

            $this->load->subadmintemplate('chapter/view-chapter-documents', $this->data);
        }
        else{
            echo "Invalid Parameters!!!";
        }
        exit;
    }

    public function ChapterDocumentsAddProcess()
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
        $chapter_master_id = filter_smart($post_data['chapter_master_id']);
        $document_title = filter_smart($post_data['document_title']);
        // $document_link = filter_smart($post_data['document_link']);

        // print_r_custom($document_link);
        // exit();

        $get_chapter_details = $this->Chapter_Model->getChapterDetailsById($chapter_master_id);
        
        if(!empty($get_chapter_details)){

            $table_name = "chapter_document_master";

            $insert_array = array(
                "course_category_id"    => $course_category_id,
                "course_master_id"      => $course_master_id,
                "chapter_master_id"     => $chapter_master_id,
                "document_status"       => '1',
                "created_date"          => date('Y-m-d H:i:s'),
                "created_by"            => $branch_id,
            );

            $chapter_document_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($chapter_document_master_id > 0){
                try{

                    $ext = pathinfo($_FILES['document_file']['name'], PATHINFO_EXTENSION);

                    $imageName = md5($chapter_document_master_id.time()). '.'.$ext;

                    $target_dir = "uploads/chapter/".$chapter_master_id."/chapter-documents/".$chapter_document_master_id."/";

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

                    if (!$this->upload->do_upload('document_file')) {
                        //print_r_custom($this->upload->display_errors(),1);
                        $status = false;
                        $res_message = "Error occured while uploading course image.";
                    } else {

                        $where = array('chapter_document_master_id' => $chapter_document_master_id);

                        $update_array = array(
                            "document_title"    => $document_title,
                            "document_file"     => $imageName,
                            // "document_link"=>$document_link
                        );

                        if($this->Common_Model->updateTable($table_name, $update_array, $where)){
                            $status = true;
                            $res_message = "Chapter document uploaded successfully.";
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
                    $res_message = "Error in chapter document upload";
                }
                
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Chapter details not available in records. Please try again";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function ChapterDocumentsListAjax()
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

        $chapter_master_id = $requestData['chapter_master_id'];
        
        /*order by colum value*/
        $colums = array(
            0=>'chapter_document_master.chapter_document_master_id',
            1=>'course_category_master.course_category_name',
            2=>'course_master.course_name',
            3=>'chapter_master.chapter_name',
            4=>'chapter_document_master.document_title',
            5=>'chapter_document_master.document_file',
            6=>'chapter_document_master.document_link',
            7=>'chapter_document_master.document_status',
            8=>'chapter_document_master.created_date',
            9=>'chapter_document_master.updated_date',
            // 10=>'chapter_document_master.document_link',

        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 AND chapter_document_master.chapter_master_id=$chapter_master_id ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " course_category_master.course_category_name like '%$searchTerm%' OR course_master.course_name like '%$searchTerm%' OR chapter_master.chapter_name like '%$searchTerm%' OR chapter_document_master.document_title like '%$searchTerm%'  ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Chapter_Documents_Model->countAllChapterDocumentsList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Chapter_Documents_Model->listChapterDocumentsQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['chapter_document_master_id'] = $start;
            $nestedData['course_category_name'] = $main['course_category_name'];
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['chapter_name'] = $main['chapter_name'];
            $nestedData['document_title'] = $main['document_title'];
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $chapter_master_id = $main['chapter_master_id'];
            $chapter_document_master_id = $main['chapter_document_master_id'];
            $document_file = $main['document_file'];
            $document_title = $main['document_title'];

            $target_dir = "uploads/chapter/".$chapter_master_id."/chapter-documents/".$chapter_document_master_id."/";
            $document_file_link = base_url().$target_dir.$document_file;
            $nestedData['document_file'] = "<a href='".$document_file_link."' target='_blank'>View</a>";

            $document_link = $main['document_link'];
            $nestedData['document_link'] = "<a href='".$document_link."' target='_blank'>View</a>";
            
            $document_status = $main['document_status'];
            $status_display = "";

            if($document_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['document_status'] = $status_display;

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_chapter_document' id='".$chapter_document_master_id."' chapter_master_id='".$chapter_master_id."' document_title='".$document_title."' document_file='".$document_file."'document_link='".$document_link."' document_status='".$document_status."'><i class='fa fa-pencil'></i> Edit</a>";

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

    public function ChapterDocumentsUpdateProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $chapter_document_master_id = filter_smart($post_data['chapter_document_master_id']);
        $course_category_id = filter_smart($post_data['course_category_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $chapter_master_id = filter_smart($post_data['chapter_master_id']);
        $document_title = filter_smart($post_data['document_title']);
        $document_status = filter_smart($post_data['document_status']);

        // updated document link 
        // $document_link = filter_smart($post_data['document_link']);


        $get_chapter_document_details = $this->Chapter_Documents_Model->getChapterDocumentsDetailsById($chapter_document_master_id);
        
        if(!empty($get_chapter_document_details)){

            $table_name = "chapter_document_master";

            $where = array("chapter_document_master_id" => $chapter_document_master_id);

            $update_array = array(
                "course_category_id"    => $course_category_id,
                "course_master_id"      => $course_master_id,
                "chapter_master_id"     => $chapter_master_id,
                "document_title"        => $document_title,
                // "document_link"         => $document_link,
                "document_status"       => $document_status,
                "created_date"          => date('Y-m-d H:i:s'),
                "created_by"            => $branch_id,
            );

            $is_updated_document = $this->Common_Model->updateTable($table_name, $update_array, $where);

            if($is_updated_document){

                if(count($_FILES) > 0){

                    try{

                        $ext = pathinfo($_FILES['document_file']['name'], PATHINFO_EXTENSION);
    
                        $imageName = md5($chapter_document_master_id.time()). '.'.$ext;
    
                        $target_dir = "uploads/chapter/".$chapter_master_id."/chapter-documents/".$chapter_document_master_id."/";
    
                        //----- [START] --- Delete current document
                        $curr_document =  $get_chapter_document_details['document_file'];
                        
                        unlink($target_dir.$curr_document);
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
                        $config['file_name'] = $imageName;
                        
                        $this->upload->initialize($config);
                        //$this->load->library('upload', $config);
    
                        if (!$this->upload->do_upload('document_file')) {
                            //print_r_custom($this->upload->display_errors(),1);
                            $status = false;
                            $res_message = "Error occured while uploading course image.";
                        } else {
    
                            $where = array('chapter_document_master_id' => $chapter_document_master_id);
    
                            $update_array = array(
                                "document_file"     => $imageName
                            );
    
                            $this->Common_Model->updateTable($table_name, $update_array, $where);
    
                            $status = true;
                            $res_message = "Chapter document  details updated successfully.";
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
                    $res_message = "Chapter document  details updated successfully.";
                }
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Chapter document details not available in records. Please try again";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}