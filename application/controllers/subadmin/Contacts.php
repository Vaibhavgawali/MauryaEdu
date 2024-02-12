<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Contacts extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('common_helper');
        $this->load->model('Common/Contacts_Model');

    }

    public function index(){
        checkBranchAdminLoginSession();

        addJs(array("subadmin/contacts.js",));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $contacts_list = $this->Contacts_Model->getAllContactsList();
        $this->data['contacts_list'] = $contacts_list;

        $this->load->subadmintemplate('contacts', $this->data);
    }

    public function ContactsListAjax()
    {
        
        $login_detail = $this->session->userdata('login_detail');

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
            0=>'contacts.id',
            1=>'contacts.fullname',
            2=>'contacts.email',
            3=>'contacts.phone',
            5=>'contacts.created_at'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 AND contacts.branch_id IN (" . $login_detail['branch_id'] . ")";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " contacts.fullname like '%$searchTerm%'  or  contacts.email like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Contacts_Model->countAllContactsList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Contacts_Model->listContactsQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['id'] = $start;
            $nestedData['fullname'] = $main['fullname'];
            $nestedData['email'] = $main['email'];
            $nestedData['phone'] = $main['phone'];
            $nestedData['created_at'] = date('d-m-Y H:i:s', strtotime($main['created_at']));

            $id = $main['id'];


            $delete_button = "<a href='javascript:void(0);' class='btn btn-danger btn-sm delete_contact' id='".$id."'><i class='fa fa-trash'></i> Delete</a>";

            $action = "";
            $action .= $delete_button;

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

    public function DeleteContact()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $admin_id = $login_detail['admin_id'];
        $branch_id = $login_detail['branch_id'];

        $status = true;
        $message = "Contact deleted successfully";

        $post_data = $this->input->post();

        //extract($post_data);
        $contact_id = filter_smart($post_data['contact_id']);

        $del_contact = $this->Contacts_Model->deleteContactsById($contact_id);

        if($del_contact == false){
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

}