<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RazorPay extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Course_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->model('RazorPay_Modal');
        $this->load->helper('common_helper');
        $this->load->helper('sms_helper');
    }

    // initialized cURL Request
    private function curl_handler($payment_id, $amount)
    {
        $url = 'https://api.razorpay.com/v1/payments/' . $payment_id . '/capture';
        $key_id = RAZOR_KEY_ID;
        $key_secret = RAZOR_KEY_SECRET;
        $fields_string = "amount=$amount";
        //cURL Request
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERPWD, $key_id . ':' . $key_secret);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        return $ch;
    }
    
    // callback method
    public function callback()
    {
        //print_r($this->input->post());     
        checkStudentLoginSession();

        $login_detail = $this->session->userdata('student_login_detail');

        if (!empty($this->input->post('razorpay_payment_id')) && !empty($this->input->post('merchant_order_id'))) {

            $razorpay_payment_id = $this->input->post('razorpay_payment_id');
            $merchant_order_id = $this->input->post('merchant_order_id');

            $discount_coupon_master_id = $this->input->post('discount_coupon_master_id') != '' ? $this->input->post('discount_coupon_master_id') : '';
            $course_actual_price = $this->input->post('course_actual_price') != '' ? $this->input->post('course_actual_price') : '';
            $price_after_discount = $this->input->post('price_after_discount') != '' ? $this->input->post('price_after_discount') : '';
            $discount_type = $this->input->post('discount_type') != '' ? $this->input->post('discount_type') : '';
            $disount_percent = $this->input->post('disount_percent') != '' ? $this->input->post('disount_percent') : '';
            $discount_value = $this->input->post('discount_value') != '' ? $this->input->post('discount_value') : '';
            $enrollment_expiry_date = $this->input->post('enrollment_expiry_date') != '' ? $this->input->post('enrollment_expiry_date') : '';

            $this->session->set_flashdata('razorpay_payment_id', $this->input->post('razorpay_payment_id'));
            $this->session->set_flashdata('merchant_order_id', $this->input->post('merchant_order_id'));
            $this->session->set_flashdata('card_holder_email_id', $this->input->post('card_holder_email_id'));
            $this->session->set_flashdata('enrollment_expiry_date', $this->input->post('enrollment_expiry_date'));
            $currency_code = 'INR';
            $amount = $this->input->post('merchant_total');
            $success = false;
            $error = '';
            try {
                $ch = $this->curl_handler($razorpay_payment_id, $amount);
                //execute post
                $result = curl_exec($ch);
                $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
                if ($result === false) {
                    $success = false;
                    $error = 'Curl error: ' . curl_error($ch);
                } else {
                    $response_array = json_decode($result, true);
                    //Check success response
                    if ($http_status === 200 and isset($response_array['error']) === false) {
                        $success = true;

                        $student_id = $login_detail['student_id'];
                        $razor_payment_id = $response_array['id'];
                        $order_id = $this->input->post('merchant_order_id');
                        $amount = $this->input->post('merchant_amount');
                        $payment_status = $response_array['status'];
                        $captured = $response_array['captured'];
                        $payment_method = $response_array['method'];
                        $payment_response = $result;

                        $insert_array = array(
                            'student_id' => $student_id,
                            'razor_payment_id' => $razor_payment_id,
                            'order_id' => $order_id,
                            'amount' => $amount,
                            'payment_status' => $payment_status,
                            'captured' => $captured,
                            'payment_method' => $payment_method,
                            'payment_response' => $payment_response,
                            'discount_coupon_master_id' => $discount_coupon_master_id,
                            'course_actual_price' => $course_actual_price,
                            'discount_type' => $discount_type,
                            'disount_percent' => $disount_percent,
                            'discount_value' => $discount_value,
                            'created_date' => date('Y-m-d H:i:s')
                        );

                        $table_name = 'razor_payment_master';

                        $payment_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

                        $this->session->set_flashdata('payment_master_id', $payment_master_id);
                        $this->session->set_flashdata('paid_amount', $amount);
                    } else {
                        $success = false;
                        if (!empty($response_array['error']['code'])) {
                            $error = $response_array['error']['code'] . ':' . $response_array['error']['description'];
                        } else {
                            $error = 'RAZORPAY_ERROR:Invalid Response <br/>' . $result;
                        }
                    }
                }
                //close curl connection
                curl_close($ch);
            } catch (Exception $e) {
                $success = false;
                $error = 'Request to Razorpay Failed';
            }

            if ($success === true) {
                if (!empty($this->session->userdata('ci_subscription_keys'))) {
                    $this->session->unset_userdata('ci_subscription_keys');
                }
                if (!$order_info['order_status_id']) {
                    redirect($this->input->post('merchant_surl_id'));
                } else {
                    redirect($this->input->post('merchant_surl_id'));
                }

            } else {
                redirect($this->input->post('merchant_furl_id'));
            }
        } else {
            echo 'An error occured. Contact site administrator, please!';
        }
    }

    // success method
    public function success()
    {

        checkStudentLoginSession();

        $login_detail = $this->session->userdata('student_login_detail');
        $student_id = $login_detail['student_id'];

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($student_id);

        $res_status = true;
        $res_message = "Enrollment done successfully.";

        $razor_payment_id = $this->session->flashdata('razorpay_payment_id');
        $order_id = $this->session->flashdata('merchant_order_id');
        $payment_master_id = $this->session->flashdata('payment_master_id');
        $paid_amount = $this->session->flashdata('paid_amount');
        $enrollment_expiry_date = $this->session->flashdata('enrollment_expiry_date');

        $paymentDetails = $this->RazorPay_Modal->getRazorPaymentDetails($student_id, $razor_payment_id, $order_id);

        if (!empty($paymentDetails)) {

            $cart_details = $this->session->userdata('student_cart_details');

            $insert_array = array();
            if ($cart_details) {
                $course_name = '';
                $course_actual_price = '';

                for ($i = 0; $i < count($cart_details); $i++) {
                    $product_details = $this->Course_Model->getCourseDetailsById($cart_details[$i]['product_id']);
                    $insert_array[$i]['student_id'] = $login_detail['student_id'];
                    $insert_array[$i]['course_master_id'] = $cart_details[$i]['product_id'];
                    $insert_array[$i]['paid_price'] = $paid_amount;
                    $insert_array[$i]['no_of_days'] = $product_details['course_duration_number_of_days'];
                    $insert_array[$i]['valid_upto'] = date('Y-m-d H:i:s', strtotime($enrollment_expiry_date . " 23:59:59"));
                    $insert_array[$i]['payment_master_id'] = $payment_master_id;

                    $insert_array[$i]['request_data'] = json_encode($this->session->userdata('student_cart_details'));

                    $insert_array[$i]['created_by'] = $login_detail['student_id'];
                    $insert_array[$i]['created_date'] = date('Y-m-d H:i:s');

                    $course_name = $product_details['course_name'];
                    $course_actual_price = $product_details['course_actual_price'];
                }
                $this->db->insert_batch('enrollment_master', $insert_array);

                $this->session->unset_userdata('student_cart_details');

                $full_name = $studentInfo['full_name'];
                $emailid = $studentInfo['emailid'];
                $contact = $studentInfo['contact'];
                $address = $studentInfo['address'];

                //--- sms notification
                if (IS_LIVE) {
                    sendCourseEnrollmentSMS($full_name, $contact);
                }

                //--- email notification
                $message = "Dear " . $full_name . ",<br><br>";
                $message .= "Your Course Enrollment is successful !";
                $message .= "<br><br>";
                $message .= "login to 'Students Dashboard' to access your course.";
                $message .= "<br><br><br>";
                $message .= "Thanks,<br> Mourya";

                if (IS_LIVE) {
                    sendEmail($emailid, 'Course Enrollment - ' . COMPANY_NAME, $message, "", "", '', '', '');
                }

                //--- email notification student
                $message_company = "";

                $message_company = "Following Student has been enrolled for your program,<br><br>";
                $message_company .= "Student Name: " . $full_name;
                $message_company .= "<br><br>";
                $message_company .= "Mobile Number: " . $contact;
                $message_company .= "<br><br>";
                $message_company .= "Email Id: " . $emailid;
                $message_company .= "<br><br>";
                $message_company .= "Enrolled Course: " . $course_name;
                $message_company .= "<br><br>";
                $message_company .= "Course Purchasing Date: " . date('d/m/Y');
                $message_company .= "<br><br>";
                $message_company .= "Fee Paid: " . $paid_amount;
                $message_company .= "<br><br>";
                $message_company .= "Address: " . $address;
                $message_company .= "<br><br>";

                if (IS_LIVE) {
                    sendEmail(COMPANY_EMAIL, 'Course Enrollment - ' . COMPANY_NAME, $message_company, "", "", '', '', '');
                }

                $msg = 'Razorpay Success | ' . COMPANY_NAME;
                $msg .= "<h4>Your transaction is successful</h4>";
                $msg .= "<br/>";
                $msg .= "Transaction ID: " . $this->session->flashdata('razorpay_payment_id');
                $msg .= "<br/>";
                $msg .= "Order ID: " . $this->session->flashdata('merchant_order_id');
                $msg .= "<br/>";
                $msg .= "Course enrollment completed.";

                $res_status = true;
                $res_message = $msg;
            } else {
                $res_status = false;
                $res_message = "Your cart is empty";
            }
        } else {
            $res_status = false;
            $res_message = "Payment details not found...";
        }

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        $this->data['payment_status'] = $res_status;
        $this->data['message'] = $res_message;

        $this->load->studenttemplate('enrollment-payment-status', $this->data);
    }

    // failed method
    public function failed()
    {
        $msg = 'Razorpay Failed | ' . COMPANY_NAME;
        $msg .= "<h4>Your transaction got Failed</h4>";
        $msg .= "<br/>";
        $msg .= "Transaction ID: " . $this->session->flashdata('razorpay_payment_id');
        $msg .= "<br/>";
        $msg .= "Order ID: " . $this->session->flashdata('merchant_order_id');
        $msg .= "<br/>";
        $msg .= "Course enrollment Failed. Please try again";

        $res_status = false;

        $this->data['payment_status'] = $res_status;
        $this->data['message'] = $res_message;

        $this->load->studenttemplate('enrollment-payment-status', $this->data);
    }
}