<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Installment extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Common/Installment_Model');
    }

    public function getInstallments() {
        checkBranchAdminLoginSession();

        $status = true;
        $installments = array();
        $message = "Installments fetch successfully";

        $razor_payment_id = $this->input->post('razor_payment_id');
        // print_r_custom($razor_payment_id,1);

        $get_all_installments = $this->Installment_Model->get_installments($razor_payment_id);
        $get_all_unpaid_installments = $this->Installment_Model->get_unpaid_installments($razor_payment_id);

        // print_r_custom($get_all_unpaid_installments,1);

        $total_installment_amount = 0;

        foreach ($get_all_installments as $installment) {
            $total_installment_amount += $installment['installment_amount'];
        }

        if(!$get_all_installments){
            $status = false;
            $installments = array();
            $get_all_unpaid_installments=array();
            $message = "Installments not found";
        }else{
            $installments=$get_all_installments;
            $unpaid_installments=$get_all_unpaid_installments;
        }

        $response = array(
            'status'    => $status,
            'installments' => $installments,
            'unpaid_installments'=>$get_all_unpaid_installments,
            'message'   => $message,
            'total_installment_amount'=>$total_installment_amount
        );

        echo json_encode($response);
    }

    public function updateInstallments() {
        checkBranchAdminLoginSession();

        $status = true;
        $message = "Installments updated successfully";

        $post_data = $this->input->post();

        $razor_payment_id = filter_smart($post_data['razor_payment_id']);
        $installment_id = filter_smart($post_data['installment']);
        $installment_amount = filter_smart($post_data['installment_amount']);
        $paid_status = filter_smart($post_data['paid_status']);
        $last_installment = filter_smart($post_data['last_installment']);
        $course_price = filter_smart($post_data['course_price']);
        $total_installment_amount = filter_smart($post_data['total_installment_amount']);
        // print_r_custom($course_price,1);

        // check if course paid price less than total amount paid by student
        $total_amount_paid = $total_installment_amount + $installment_amount;
        $is_paid_total=($total_amount_paid < $course_price) ? true : false;
        $is_last_installment=($last_installment == 1) ? true : false;
        
        if ($is_last_installment && $is_paid_total) { 

                $status = false;
                $message = "Amount paid is lesss than course price";

                $response = array(
                    'status'    => $status,
                    'message'   => $message
                );
        
                echo json_encode($response);
                return false;
        }

        $table_name = "installment_master";

        $where = array('installment_id' => $installment_id);

        $update_array = array(
            "installment_amount"  => $installment_amount,
            "paid_status"         => $paid_status,
            // "updated_date"     => date('Y-m-d H:i:s'),
        );

        $updated_installment = $this->Common_Model->updateTable($table_name, $update_array, $where);

        if(!$updated_installment){
            $status = false;
            $message = "Failed to update installments";
        }

        if ($last_installment == 1) {   
            $table_name = "razor_payment_master";
            $where = array("razor_payment_master_id" => $razor_payment_id);
            $update_array = array(
                "payment_status" => "captured"
            );

            $is_updated_payment = $this->Common_Model->updateTable($table_name, $update_array, $where);
        } 

        $response = array(
            'status'    => $status,
            'message'   => $message
        );

        echo json_encode($response);
    }
}
?>
