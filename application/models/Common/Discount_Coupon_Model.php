<?php

class Discount_Coupon_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - Discount Coupon details

    /*  Get Discount Coupon Info using status  */
    function getAllDiscountCouponDetailsByCouponStatus($discount_coupon_status){
        $result = $this->db->query("SELECT * FROM discount_coupon_master WHERE discount_coupon_status = '".$discount_coupon_status."'")->result_array();

        return $result;
    }

    /*  Get Discount Coupon Info from ID  */
    function getDiscountCouponById($discount_coupon_master_id){
        $result = $this->db->query("SELECT * FROM discount_coupon_master WHERE discount_coupon_master_id = $discount_coupon_master_id.")->row_array();

        return $result;
    }

    /*  Get Discount Coupon Info from CouponCode  */
    function getDiscountCouponByDiscountCode($discount_coupon_code){
        $result = $this->db->query("SELECT * FROM discount_coupon_master WHERE discount_coupon_code = '".$discount_coupon_code."'")->row_array();

        return $result;
    }

    // count all Discount Coupon from list
    function countAllDiscountCouponList($where){
        $sql = "SELECT COUNT(discount_coupon_master.discount_coupon_master_id) AS total 
            FROM discount_coupon_master 
            LEFT JOIN course_master ON discount_coupon_master.course_master_id = course_master.course_master_id 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL Discount Coupon from list
    function listDiscountCouponQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT discount_coupon_master.*, course_master.course_name
            FROM discount_coupon_master 
            LEFT JOIN course_master ON discount_coupon_master.course_master_id = course_master.course_master_id 
            WHERE $where 
            ORDER BY $order_by $order_dir LIMIT $start, $length";
        
        $result = $this->db->query($sql)->result_array();
        $result_total = $this->db->query($sql)->num_rows();
        $array = array(
            "Result" => $result,
            "Result_total_filter" => $result_total,
        );
        return $array;
    }

    /*  Get DISCOUNT COUPON from COUPON CODE with other id  */
    function getDiscountCouponDetailsByCodeForOtherId($discount_coupon_code, $discount_coupon_master_id){
        $result = $this->db->query("SELECT * FROM discount_coupon_master WHERE LOWER(discount_coupon_code) = '".strtolower($discount_coupon_code)."'  AND discount_coupon_master_id != ".$discount_coupon_master_id)->row_array();

        return $result;
    }

}