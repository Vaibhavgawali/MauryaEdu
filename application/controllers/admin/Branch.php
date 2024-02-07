<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Branch extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Branch_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkAdminLoginSession();

        addJs(array("admin/branch-list.js"));
        
        $login_detail = $this->session->userdata('login_detail');
        //print_r_custom($login_detail,1);
        $this->data['login_detail'] = $login_detail;
        $this->load->admintemplate('branch-list', $this->data);
    }

    public function BranchAddProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);  branch_emailid: , 

        $branch_name = filter_smart($post_data['branch_name']);
        $branch_emailid = filter_smart($post_data['branch_emailid']);
        $branch_contact = filter_smart($post_data['branch_contact']);
        $branch_address = filter_smart($post_data['branch_address']);
        $branch_info = filter_smart($post_data['branch_info']);

        $get_branch_Details = $this->Branch_Model->getBranchDetailsByName($branch_name);

        if(empty($get_branch_Details)){

            $table_name = "branch_master";

            $insert_array = array(
                "branch_name"      => $branch_name,
                "branch_emailid"   => $branch_emailid,
                "branch_contact"   => $branch_contact,
                "branch_address"   => $branch_address,
                "branch_info"      => $branch_info,
                "branch_status"    => '1',
                "created_date"     => date('Y-m-d H:i:s'),
                "created_by"       => $userinfo_id,
            );

            $branch_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($branch_id > 0){

                $status = true;
                $res_message = "Branch added successfully.";

            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Branch already exists in records, Please choose different Branch.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function BranchListAjax()
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
            0=>'branch_id',
            1=>'branch_name',
            2=>'branch_emailid',
            3=>'branch_contact',
            4=>'branch_address',
            5=>'branch_status',
            6=>'created_date',
            7=>'updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "sm.branch_name like '%$searchTerm%' ";
            $where .= ") ";
        }
        
        /*Count Table result*/
        $total_count_array = $this->Branch_Model->countAllBranchList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Branch_Model->listBranchQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['branch_id'] = $start;
            $nestedData['branch_name'] = $main['branch_name'];
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $nestedData['branch_emailid']=$main['branch_emailid'];
            $nestedData['branch_contact']=$main['branch_contact'];
            $nestedData['branch_address']=$main['branch_address'];

            $branch_status = $main['branch_status'];
            $status_display = "";

            if($branch_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['status'] = $status_display;

            $branch_id = $main['branch_id'];
            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_branch' id='".$branch_id."'><i class='fa fa-eye'></i> View</a>";

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

    //get branch details
    public function GetBranchDetails()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = true;
        $branch_details = array();
        $message = "Branch details fetch successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $branch_id = filter_smart($post_data['branch_id']);

        $get_branch_Details = $this->Branch_Model->getBranchDetailsById($branch_id);

        if(count($get_branch_Details) == 0){
            $status = false;
            $branch_details = array();
            $message = "Branch details not found";
        }
        else{
            $status_html = null;

            $branch_status = $get_branch_Details['branch_status'];

            if($branch_status=="1"){
                $status_html .= "<option value='1' selected>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }
            else
            if($branch_status=="0"){
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0' selected>In-Active</option>";
            }
            else{
                $status_html .= "<option value='1'>Active</option>";
                $status_html .= "<option value='0'>In-Active</option>";
            }

            $branch_details = array(
                'branch_id' => $get_branch_Details['branch_id'],
                'branch_name' => $get_branch_Details['branch_name'],
                "branch_emailid" => $get_branch_Details['branch_emailid'],
                "branch_contact" => $get_branch_Details['branch_contact'],
                "branch_address" => $get_branch_Details['branch_address'],
                'branch_info' => $get_branch_Details['branch_info'],
                'branch_status_html' => $status_html
            );
        }

        $response = array(
            'status'    => $status,
            'branch_details'  => $branch_details,
            'message'   => $message
        );

        echo json_encode($response);
        exit;
    }

    // update branch
    public function BranchUpdateProcess()
    {
        checkAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        //extract($post_data);
        $branch_id = filter_smart($post_data['branch_id']); 
        $branch_name = filter_smart($post_data['branch_name']);
        $branch_emailid = filter_smart($post_data['branch_emailid']);
        $branch_contact = filter_smart($post_data['branch_contact']);
        $branch_address = filter_smart($post_data['branch_address']);
        $branch_info = filter_smart($post_data['branch_info']);
        $branch_status = filter_smart($post_data['branch_status']);

        $get_branch_Details = $this->Branch_Model->getBranchDetailsByNameWithOtherId($branch_name, $branch_id);

        if(empty($get_branch_Details)){

            $table_name = "branch_master";

            $where = array( "branch_id" => $branch_id);

            $update_array = array(
                "branch_name"      => $branch_name,
                "branch_emailid"   => $branch_emailid,
                "branch_contact"   => $branch_contact,
                "branch_address"   => $branch_address,
                "branch_info"      => $branch_info,
                "branch_status"    => $branch_status,
                "updated_date"     => date('Y-m-d H:i:s'),
                "updated_by"       => $userinfo_id,
            );

            $this->Common_Model->updateTable("$table_name", $update_array, $where);

            $status = true;
            $res_message = "Branch details updated successfully.";
            
        }
        else{
            $status = false;
            $res_message = "Branch already exists in records, Please choose different Branch.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}