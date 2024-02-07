<?php
defined('BASEPATH') or exit('No direct script access allowed');

class DiscountCoupon extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Model');
        $this->load->model('Common/Discount_Coupon_Model');
        $this->load->helper('common_helper');
    }

    public function index(){
        checkBranchAdminLoginSession();

        addJs(array("admin/discount-coupon.js",));
        
        $login_detail = $this->session->userdata('login_detail');
        $this->data['login_detail'] = $login_detail;

        $course_list = $this->Course_Model->getAllCourseDetailsByStatus(1);
        $this->data['course_list'] = $course_list;

        $this->load->subadmintemplate('discount-coupon', $this->data);
    }

    public function AddDiscountCoupon()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $discount_coupon_code = filter_smart($post_data['discount_coupon_code']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $disount_percent = filter_smart($post_data['disount_percent']);
        $discount_amount = filter_smart($post_data['discount_amount']);
        $start_date = filter_smart($post_data['start_date']);
        $end_date = filter_smart($post_data['end_date']);
        $no_of_times_coupon_use = filter_smart($post_data['no_of_times_coupon_use']);
        $is_locked = filter_smart($post_data['is_locked']);

        $start_date = ($start_date != NULL) ? date('Y-m-d', strtotime($start_date)) : '';
        $end_date = ($end_date != NULL) ? date('Y-m-d', strtotime($end_date)) : '';

        $get_discount_coupon_Details = $this->Discount_Coupon_Model->getDiscountCouponByDiscountCode($discount_coupon_code);

        if(empty($get_discount_coupon_Details)){
            $table_name = "discount_coupon_master";

            $insert_array = array(
                "discount_coupon_code"      => $discount_coupon_code,
                "course_master_id"          => $course_master_id,
                "disount_percent"           => $disount_percent,
                "discount_amount"           => $discount_amount,
                "start_date"                => $start_date,
                "end_date"                  => $end_date,
                "no_of_times_coupon_use"    => $no_of_times_coupon_use,
                "is_locked"                 => $is_locked,
                "created_date"              => date('Y-m-d H:i:s'),
                "created_by"                => $userinfo_id,
            );

            $discount_coupon_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($discount_coupon_master_id > 0){
                $status = true;
                $res_message = "Discount coupon added successfully.";
                
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
        }
        else{
            $status = false;
            $res_message = "Coupon code already available in records! Please use different coupon code.";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

    public function DiscountCouponListAjax()
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
            0=>'discount_coupon_master.discount_coupon_master_id',
            1=>'discount_coupon_master.discount_coupon_code',
            2=>'course_master.course_name',
            3=>'discount_coupon_master.disount_percent',
            4=>'discount_coupon_master.discount_amount',
            5=>'discount_coupon_master.start_date',
            6=>'discount_coupon_master.end_date',
            7=>'discount_coupon_master.no_of_times_coupon_use',
            8=>'discount_coupon_master.is_locked',
            9=>'discount_coupon_master.discount_coupon_status',
            10=>'discount_coupon_master.created_date',
            11=>'discount_coupon_master.updated_date'
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 ";

        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= "   discount_coupon_master.discount_coupon_code like '%$searchTerm%' OR  course_master.course_name like '%$searchTerm%' OR discount_coupon_master.disount_percent like '%$searchTerm%' OR discount_coupon_master.discount_amount like '%$searchTerm%' OR discount_coupon_master.no_of_times_coupon_use like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Discount_Coupon_Model->countAllDiscountCouponList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Discount_Coupon_Model->listDiscountCouponQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['discount_coupon_master_id'] = $start;
            $nestedData['discount_coupon_code'] = $main['discount_coupon_code'];
            $nestedData['disount_percent'] = ($main['disount_percent']>0) ? $main['disount_percent'] : '';
            $nestedData['discount_amount'] = ($main['discount_amount']>0) ? $main['discount_amount'] : '';
            $nestedData['no_of_times_coupon_use'] = $main['no_of_times_coupon_use'];
            $nestedData['created_date'] = date('d-m-Y H:i:s', strtotime($main['created_date']));
            $nestedData['updated_date'] = ($main['updated_date'] != NULL) ? date('d-m-Y H:i:s', strtotime($main['updated_date'])) : "-";

            $discount_coupon_master_id = $main['discount_coupon_master_id'];

            $discount_coupon_status = $main['discount_coupon_status'];
            $status_display = "";

            if($discount_coupon_status == 1){
                $status_display = "<span class='badge badge-success'>Active</span>";
            }
            else{
                $status_display = "<span class='badge badge-danger'>In-Active</span>";
            }

            $nestedData['discount_coupon_status'] = $status_display;

            $start_date = $end_date = '';

            $start_date_db = $main['start_date'];
            if($start_date_db != NULL && $start_date_db != '0000-00-00'){
                $start_date = date('m/d/Y', strtotime($main['start_date']));
                $nestedData['start_date'] = date('d-m-Y', strtotime($main['start_date']));
            }
            else{
                $nestedData['start_date'] = '';
            }

            $end_date_db = $main['end_date'];
            if($end_date_db != NULL && $end_date_db != '0000-00-00'){
                $end_date = date('m/d/Y', strtotime($main['end_date']));
                $nestedData['end_date'] = date('d-m-Y', strtotime($main['end_date']));
            }
            else{
                $nestedData['end_date'] = '';
            }
            

            $course_master_id = $main['course_master_id'];
            if($course_master_id == 0){
                $nestedData['course_name'] = 'All';
            }
            else{
                $nestedData['course_name'] = $main['course_name'];
            }

            $disount_percent = ($main['disount_percent']>0) ? $main['disount_percent'] : '';
            $discount_amount = ($main['discount_amount']>0) ? $main['discount_amount'] : '';

            $is_locked = $main['is_locked'];
            $is_locked_display = "";

            if($is_locked == 1){
                $is_locked_display = "<span class='badge badge-success'>Yes</span>";
            }
            else{
                $is_locked_display = "<span class='badge badge-danger'>No</span>";
            }
            $nestedData['is_locked'] = $is_locked_display;

            $edit_button = "<a href='javascript:void(0);' class='btn btn-info btn-sm edit_discount_coupon' id='".$discount_coupon_master_id."' discount_coupon_code='".$main['discount_coupon_code']."' course_master_id='".$course_master_id."' disount_percent='".$disount_percent."' discount_amount='".$discount_amount."' start_date='".$start_date."' end_date='".$end_date."' no_of_times_coupon_use='".$main['no_of_times_coupon_use']."' is_locked='".$main['is_locked']."'  discount_coupon_status='".$main['discount_coupon_status']."'><i class='fa fa-pencil'></i> Edit</a>";

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
    
    public function UpdateDiscountCoupon()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $userinfo_id = $login_detail['userinfo_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();
        
        //extract($post_data);
        $discount_coupon_master_id = filter_smart($post_data['discount_coupon_master_id']);
        $discount_coupon_code = filter_smart($post_data['discount_coupon_code']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $disount_percent = filter_smart($post_data['disount_percent']);
        $discount_amount = filter_smart($post_data['discount_amount']);
        $start_date = filter_smart($post_data['start_date']);
        $end_date = filter_smart($post_data['end_date']);
        $no_of_times_coupon_use = filter_smart($post_data['no_of_times_coupon_use']);
        $is_locked = filter_smart($post_data['is_locked']);
        $discount_coupon_status = filter_smart($post_data['discount_coupon_status']);

        $start_date = ($start_date != NULL) ? date('Y-m-d', strtotime($start_date)) : '';
        $end_date = ($end_date != NULL) ? date('Y-m-d', strtotime($end_date)) : '';

        $get_discount_coupon_Details = $this->Discount_Coupon_Model->getDiscountCouponById($discount_coupon_master_id);

        if(!empty($get_discount_coupon_Details)){

            $get_other_coupon_Details = $this->Discount_Coupon_Model->getDiscountCouponDetailsByCodeForOtherId($discount_coupon_code, $discount_coupon_master_id);

            if(empty($get_other_coupon_Details)){
                $table_name = "discount_coupon_master";

                $where = array('discount_coupon_master_id' => $discount_coupon_master_id);

                $update_array = array(
                    "discount_coupon_code"      => $discount_coupon_code,
                    "course_master_id"          => $course_master_id,
                    "disount_percent"           => $disount_percent,
                    "discount_amount"           => $discount_amount,
                    "start_date"                => $start_date,
                    "end_date"                  => $end_date,
                    "no_of_times_coupon_use"    => $no_of_times_coupon_use,
                    "is_locked"                 => $is_locked,
                    "discount_coupon_status"    => $discount_coupon_status,
                    "updated_date"              => date('Y-m-d H:i:s'),
                    "updated_by"                => $userinfo_id,
                );

                $this->Common_Model->updateTable($table_name, $update_array, $where);

                $status = true;
                $res_message = "Discount coupon updated successfully.";
            }
            else{
                $status = false;
                $res_message = "Coupon code already available in records. Kindly user different coupon code. ";
            }

            
        }
        else{
            $status = false;
            $res_message = "Coupon code not exists in records";
        }
        
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}