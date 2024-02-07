<?php

class RazorPay_Modal extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function getRazorPaymentDetails($student_id, $razor_payment_id, $order_id){
        $sql = "SELECT * 
            FROM razor_payment_master 
            WHERE student_id = $student_id AND razor_payment_id = '".$razor_payment_id."' AND order_id = '".$order_id."' ";

        $result = $this->db->query($sql)->row_array();

        return $result;
    }
}