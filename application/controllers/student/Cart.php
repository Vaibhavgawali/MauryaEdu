<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cart extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Course_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('Common/Discount_Coupon_Model');
        $this->load->helper('common_helper');
    }


    public function add_to_cart()
    {

        checkStudentLoginSession();

        addJs(array("course/course-list.js"));

        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;

        $requestData = $_REQUEST;

        $product_id = filter_smart($requestData['product_id']);
        $course_sell_price = filter_smart($requestData['course_sell_price']);
        $quantity = 1;

        $response = array('status' => false, 'message' => 'Failed to add product in cart');

        // $cart_details = $this->session->userdata('student_cart_details');
        // print_r($cart_details);
        // die('sss');

        if ($product_id && $quantity > 0) {
            $cart_details = $this->session->userdata('student_cart_details');

            if ($cart_details) {
                //---Note:- At a time one course can be added to the cart. Hence below code is commented.
                /*
                    for($i=0;$i<count($cart_details);$i++)
                    {
                        if($product_id == $cart_details[$i]['product_id'])
                        {
                            $response = array('status' => false, 'message' => 'You have already added this product to cart. You cannot add the same product again', 'cart_details' => $cart_details);                        
                            goto print_result;
                        }
                    }    

                    $item_details = array(
                                'product_id' => $product_id,
                                'quantity' => $quantity,
                                'course_sell_price' => $course_sell_price,
                                'student_id' => $login_detail['student_id']
                            );

                    $cart_details[] = $item_details; 

                    $this->session->unset_userdata('student_cart_details');

                    $session_data = array(
                        "student_cart_details" => $cart_details
                    );

                    $this->session->set_userdata($session_data);
                */
                $response = array('status' => false, 'message' => 'You have already added one course to the cart. Please checkout first.', 'cart_details' => $cart_details);
                goto print_result;
            } else {
                $item_details = array(
                    'product_id' => $product_id,
                    'quantity' => $quantity,
                    'course_sell_price' => $course_sell_price,
                    'student_id' => $login_detail['student_id'],
                    'is_discount_applied' => 0,
                    'discount_coupon_master_id' => 0,
                );

                $cart[] = $item_details;

                $session_data = array(
                    "student_cart_details" => $cart
                );

                $this->session->set_userdata($session_data);
                $cart_details = $this->session->userdata('student_cart_details');

                $response = array('status' => true, 'message' => 'Product added to cart', 'cart_details' => $cart_details);
                goto print_result;
            }
        }

        print_result:
        echo json_encode($response);
    }

    public function view_cart()
    {
        checkStudentLoginSession();

        addJs(array("course/course-list.js"));

        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        if ($login_detail) {
            $this->data['login_detail'] = $login_detail;
        }

        if ($studentInfo) {
            $this->data['studentInfo'] = $studentInfo;
        }

        $cart_details = $this->session->userdata('student_cart_details');

        if (isset($cart_details) && count($cart_details) > 0) {
            // die('sds123456');                        
            for ($i = 0; $i < count($cart_details); $i++) {
                $product_details = $this->Course_Model->getCourseDetailsById($cart_details[$i]['product_id']);

                if (isset($cart_details[$i]['is_discount_applied']) && $cart_details[$i]['is_discount_applied'] == 1) {
                    $coupon_details = $this->Discount_Coupon_Model->getDiscountCouponById($cart_details[$i]['discount_coupon_master_id']);
                    if ($coupon_details) {
                        // print_r_custom($cart_details,1);
                        $coupon_discount_percent = $coupon_details['disount_percent'];
                        $coupon_discount_amount = $coupon_details['discount_amount'];

                        if ($coupon_discount_percent != 0 && $coupon_discount_percent > 0) {
                            $discount_value = ($cart_details[$i]['course_sell_price'] * $coupon_discount_percent) / 100;
                            $cart_details[$i]['discount_type'] = 'PERCENTAGE';
                            $cart_details[$i]['disount_percent'] = $coupon_discount_percent;
                            $cart_details[$i]['discount_value'] = $discount_value;
                        } else {
                            $discount_value = $coupon_discount_amount;
                            $cart_details[$i]['discount_type'] = 'FLAT';
                            $cart_details[$i]['disount_percent'] = 0;
                            $cart_details[$i]['discount_value'] = $discount_value;
                        }
                        $cart_details[$i]['discount_coupon_code'] = $coupon_details['discount_coupon_code'];

                        $selling_price = $cart_details[$i]['course_sell_price'] - $discount_value;

                        $cart_details[$i]['price_after_discount'] = $selling_price;
                    } else {
                        $cart_details[$i]['price_after_discount'] = $cart_details[$i]['course_sell_price'];
                        $cart_details[$i]['discount_type'] = '';
                        $cart_details[$i]['disount_percent'] = '';
                        $cart_details[$i]['discount_value'] = '';
                        $cart_details[$i]['discount_coupon_code'] = '';
                    }
                } else {
                    $cart_details[$i]['price_after_discount'] = $cart_details[$i]['course_sell_price'];
                    $cart_details[$i]['discount_type'] = '';
                    $cart_details[$i]['disount_percent'] = '';
                    $cart_details[$i]['discount_value'] = '';
                    $cart_details[$i]['discount_coupon_code'] = '';
                }

                // print_r_custom($product_details,1);   
                $cart_details[$i]['product_name'] = $product_details['course_name'];
                $cart_details[$i]['course_image'] = $product_details['course_image'];
                $cart_details[$i]['course_duration_number_of_days'] = $product_details['course_duration_number_of_days'];
                $cart_details[$i]['course_start_date'] = $product_details['course_start_date'];
                $cart_details[$i]['course_end_date'] = $product_details['course_end_date'];
                $cart_details[$i]['is_allow_purchase_after_expire'] = $product_details['is_allow_purchase_after_expire'];

                $course_end_date = $product_details['course_end_date'];
                $cart_details[$i]['is_course_expired'] = false;

                if ($course_end_date == NULL || $course_end_date == '0000-00-00') {
                    $cart_details[$i]['is_course_expired'] = true;
                } else
                    if (strtotime(date('Y-m-d')) > strtotime($course_end_date)) {
                        $cart_details[$i]['is_course_expired'] = true;
                    }
            }
            // print_r_custom($cart_details,1);   
            $this->data['cart_details'] = $cart_details;
        } else {
            $this->data['cart_details'] = array();
        }

        //----  Razorpay parameters
        $this->data['title'] = 'Checkout payment | ' . COMPANY_NAME;
        $this->data['callback_url'] = base_url() . 'razorpay/callback';
        $this->data['surl'] = base_url() . 'razorpay/success';
        $this->data['furl'] = base_url() . 'razorpay/failed';
        $this->data['currency_code'] = 'INR';
        // print_r_custom($this->data, 1);
        $this->load->studenttemplate('view_cart', $this->data);
    }

    public function remove_from_cart()
    {
        $cart_details = $this->session->userdata('student_cart_details');

        $requestData = $_REQUEST;

        $product_id = filter_smart($requestData['product_id']);

        // print_r_custom($cart_details);

        if ($cart_details) {
            for ($i = 0; $i < count($cart_details); $i++) {
                if ($product_id == $cart_details[$i]['product_id']) {
                    unset($cart_details[$i]);
                }
            }
        }
        $updated_cart = array_values($cart_details);

        $this->session->unset_userdata('student_cart_details');

        $session_data = array(
            "student_cart_details" => $updated_cart
        );
        $this->session->set_userdata($session_data);

        $result = array('status' => true);

        echo json_encode($result);
    }

    public function checkout()
    {
        checkStudentLoginSession();

        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;

        $cart_details = $this->session->userdata('student_cart_details');

        $insert_array = array();
        if ($cart_details) {
            for ($i = 0; $i < count($cart_details); $i++) {
                $product_details = $this->Course_Model->getCourseDetailsById($cart_details[$i]['product_id']);
                $insert_array[$i]['student_id'] = $login_detail['student_id'];
                $insert_array[$i]['course_master_id'] = $cart_details[$i]['product_id'];
                $insert_array[$i]['paid_price'] = $product_details['course_sell_price'];
                $insert_array[$i]['no_of_days'] = $product_details['course_duration_number_of_days'];
                $insert_array[$i]['valid_upto'] = date('Y-m-d H:i:s', strtotime("+" . $product_details['course_duration_number_of_days'] . " days"));
                $insert_array[$i]['payment_master_id'] = '1';
                $insert_array[$i]['created_by'] = $login_detail['student_id'];
                $insert_array[$i]['created_date'] = date('Y-m-d H:i:s');
            }
            $this->db->insert_batch('enrollment_master', $insert_array);

            $result = array('status' => true, 'message' => "Course enrollment completed.");
            $this->session->unset_userdata('student_cart_details');
        } else {
            $result = array('status' => false, 'message' => "Your cart is empty");
        }

        echo json_encode($result);
    }

    public function applyCoupon()
    {
        checkStudentLoginSession();

        addJs(array("course/course-list.js"));

        $result = array('status' => false, 'message' => "Something went wrong. Please try later", 'err_code' => 'E000');

        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $requestData = $_REQUEST;

        $coupon_code = filter_smart($requestData['coupon_code']);

        if ($coupon_code != '') {
            $cart_details = $this->session->userdata('student_cart_details');

            $course_id = $cart_details[0]['product_id'];
            $course_sell_price = $cart_details[0]['course_sell_price'];

            $student_id = $login_detail['student_id'];

            $coupon_details = $this->Course_Model->checkCoupon($coupon_code);

            if ($coupon_details) {
                $today = date('Y-m-d H:i:s');
                $coupon_start_date = $coupon_details[0]->start_date == "0000-00-00" ? "" : $coupon_details[0]->start_date . " 00:00:00";
                $coupon_end_date = $coupon_details[0]->end_date == "0000-00-00" ? "" : $coupon_details[0]->end_date . " 23:59:59";
                $coupon_discount_percent = $coupon_details[0]->disount_percent;
                $coupon_discount_amount = $coupon_details[0]->discount_amount;
                $no_of_times_coupon_can_use = $coupon_details[0]->no_of_times_coupon_use;
                $discount_coupon_master_id = $coupon_details[0]->discount_coupon_master_id;


                if (($coupon_details[0]->course_master_id == 0) || ($course_id == $coupon_details[0]->course_master_id)) {
                    $coupon_used_data = $this->Course_Model->checkCouponUsedCount($discount_coupon_master_id);

                    $no_of_times_coupon_used = 0;

                    if ($coupon_used_data) {
                        $no_of_times_coupon_used = $coupon_used_data[0]->total;
                    }

                    if ($no_of_times_coupon_can_use > $no_of_times_coupon_used) {
                        if ($coupon_start_date != "" && $coupon_end_date != "") {
                            if ($today >= $coupon_start_date && $today <= $coupon_end_date) {
                                $coupon_result = $this->coupon_calculation($course_sell_price, $coupon_discount_percent, $coupon_discount_amount, $discount_coupon_master_id);
                                $result = array('status' => true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);
                            } else {
                                $result = array('status' => false, 'message' => "Invalid coupon code.", 'err_code' => 'E001');
                            }
                            goto print_result;
                        } else if ($coupon_start_date != "") {
                            if ($today >= $coupon_start_date) {
                                $coupon_result = $this->coupon_calculation($course_sell_price, $coupon_discount_percent, $coupon_discount_amount, $discount_coupon_master_id);
                                $result = array('status' => true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);
                            } else {
                                $result = array('status' => false, 'message' => "Invalid coupon code.", 'err_code' => 'E002');
                            }

                            goto print_result;
                        } else if ($coupon_end_date != "") {
                            if ($today <= $coupon_end_date) {
                                $coupon_result = $this->coupon_calculation($course_sell_price, $coupon_discount_percent, $coupon_discount_amount, $discount_coupon_master_id);
                                $result = array('status' => true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);
                            } else {
                                $result = array('status' => false, 'message' => "Invalid coupon code.", 'err_code' => 'E003');
                            }

                            goto print_result;
                        } else {
                            $coupon_result = $this->coupon_calculation($course_sell_price, $coupon_discount_percent, $coupon_discount_amount, $discount_coupon_master_id);
                            $result = array('status' => true, 'message' => 'Coupon applied.', 'coupon_result' => $coupon_result);

                            goto print_result;
                        }
                    } else {
                        $result = array('status' => false, 'message' => "Coupon is expired.", 'err_code' => 'E004');
                    }
                } else {
                    $result = array('status' => false, 'message' => "This coupon is not applicable for this course.", 'err_code' => 'E005');
                }
            } else {
                $result = array('status' => false, 'message' => "Invalid coupon code.", 'err_code' => 'E006');
            }
        } else {
            $result = array('status' => false, 'message' => "Please enter coupon code", 'err_code' => 'E007');
        }

        $result['cart_session'] = $this->session->userdata('student_cart_details');
        print_result:
        echo json_encode($result);
    }

    public function coupon_calculation($course_sell_price, $coupon_discount_percent, $coupon_discount_amount, $discount_coupon_master_id)
    {

        $cart_details = $this->session->userdata('student_cart_details');

        if ($coupon_discount_percent != 0 && $coupon_discount_percent > 0) {
            $discount_value = ($course_sell_price * $coupon_discount_percent) / 100;
            $cart_details[0]['discount_type'] = 'PERCENTAGE';
        } else if ($coupon_discount_amount > 0) {
            $discount_value = $coupon_discount_amount;
            $cart_details[0]['discount_type'] = 'FLAT';
        } else {
            $discount_value = 0;
            $cart_details[0]['discount_type'] = 'FLAT';
        }

        $selling_price = $course_sell_price - $discount_value;

        $cart_details[0]['discount_coupon_master_id'] = $discount_coupon_master_id;
        $cart_details[0]['discount_value'] = $discount_value;
        $cart_details[0]['price_after_discount'] = $selling_price;
        $cart_details[0]['is_discount_applied'] = 1;


        $this->session->unset_userdata('student_cart_details');
        $session_data = array(
            "student_cart_details" => $cart_details
        );
        $this->session->set_userdata($session_data);
        $cart_details = $this->session->userdata('student_cart_details');

        return $res = array(
            'discount_coupon_master_id' => $discount_coupon_master_id,
            'previous_selling_price' => $course_sell_price,
            'discount_type' => $cart_details[0]['discount_type'],
            'discount_value' => $discount_value,
            'coupon_discount_percent' => $coupon_discount_percent,
            'selling_price' => $selling_price,
        );


    }

}
?>