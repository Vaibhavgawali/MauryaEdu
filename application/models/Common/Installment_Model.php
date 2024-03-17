<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Installment_model extends CI_Model {

    public function get_installments($razor_payment_id) {
        $this->db->where('razor_payment_master_id', $razor_payment_id); 
        $query = $this->db->get('installment_master');
        return $query->result_array();
    }

    public function get_unpaid_installments($razor_payment_id) {
        $this->db->where('razor_payment_master_id', $razor_payment_id); 
        $this->db->where('paid_status', 0);
        $query = $this->db->get('installment_master');
        return $query->result_array();
    }

    public function update_installment($installment_id, $amount, $status) {
        $data = array(
            'installment_amount' => $amount,
            'paid_status' => $status
        );
        $this->db->where('installment_id', $installment_id);
        $this->db->update('installment_master', $data);
    }

}
?>
