<?php
defined('BASEPATH') or exit('No direct script access allowed');

class StudentEnroll extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Course_Category_Model');
        $this->load->model('Common/Course_Model');
        $this->load->model('Common/Chapter_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->helper('common_helper');
    }

    public function GetCourseDetails(){
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');

        $status = false;
        $course_details = array();
        $message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $course_master_id = filter_smart($post_data['course_master_id']);

        $get_Course_Details = $this->Course_Model->getCourseDetailsById($course_master_id);

        if(count($get_Course_Details) > 0){
            $status = true;
            $course_details = $get_Course_Details;
            $message = "Course details fetch successfully";
        }
        else{
            $status = false;
            $course_details = array();
            $message = "Course not available";
        }

        $response = array(
            'status'    => $status,
            'course_details'  => $course_details,
            'message'   => $message
        );

        echo json_encode($response, TRUE);
        exit;
    }

    public function AddStudentEnroll($student_id = '')
    {
        checkBranchAdminLoginSession();
        
        addJs(array("subadmin/student-enroll-list.js"));

        $login_detail = $this->session->userdata('login_detail');

        $this->data['login_detail'] = $login_detail;

        $branch_filter = "branch_id IN (1," . $login_detail['branch_id'] . ")";
        $get_not_enrolled_course_list = $this->Student_Details_Model->getNotEnrolledCourses($student_id,$branch_filter);
        // print_r_custom($get_not_enrolled_course_list,1);

        $this->data['course_master_list'] = $get_not_enrolled_course_list;
        $this->data['student_id'] = $student_id;       

        $this->load->subadmintemplate('enrollment/add-enrollment-details', $this->data);
    }

    public function StudentEnrollAddProcess()
    {
        checkBranchAdminLoginSession();

        $login_detail = $this->session->userdata('login_detail');
        $admin_id = $login_detail['admin_id'];
        $branch_id = $login_detail['branch_id'];
        
        $status = true;
        $res_message = "";

        $post_data = $this->input->post();

        //extract($post_data);
        $student_id = filter_smart($post_data['student_id']);
        $course_master_id = filter_smart($post_data['course_master_id']);
        $course_price = filter_smart($post_data['course_price']);
        $installment_number = filter_smart($post_data['installment_number']);
        $installment_amount = filter_smart($post_data['installment_amount']);

        $get_Student_Details = $this->Student_Details_Model->is_student_enrolled($student_id,$course_master_id);

        if(!$get_Student_Details){
            $payment_id = uniqid('PAYMENT_');
            $order_id = md5(uniqid());
            $payment_response = bin2hex(random_bytes(16));

            $insert_array = array(
                'student_id' => $student_id,
                'razor_payment_id' => $payment_id,
                'order_id' => $order_id,
                'amount' => $course_price,
                'payment_status' => ($installment_number === 1) ? "captured" : "Pending",
                'payment_method' => "offline",
                'payment_response' => $payment_response,
                'created_date' => date('Y-m-d H:i:s')
            );

            $table_name = 'razor_payment_master';

            $payment_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

            if($payment_master_id > 0){

                if ($installment_number > 1) {
                    for ($i = 1; $i <= $installment_number; $i++) {
                        $installment_insert_array = array(
                            'razor_payment_master_id'=>$payment_master_id,
                            'student_id' => $student_id,
                            'course_master_id' => $course_master_id,
                            'installment_amount' => ($i === 1) ? $installment_amount : 0,
                            'paid_status' => ($i === 1) ? 1 : 0,
                            'created_date' => date('Y-m-d H:i:s')
                        );
                        $installment_table_name = 'installment_master';
                        $this->Common_Model->insertIntoTable($installment_table_name, $installment_insert_array);
                    }
                }

                $get_Course_Details = $this->Course_Model->getCourseDetailsById($course_master_id);

                $insert_array = array(
                    'student_id' => $student_id,
                    'course_master_id' => $course_master_id,
                    'paid_price' => $course_price,
                    'no_of_days'=> $get_Course_Details['course_duration_number_of_days'],
                    'valid_upto' => date('Y-m-d H:i:s', strtotime($get_Course_Details['course_end_date'] . " 23:59:59")),
                    'payment_master_id' => $payment_master_id,
                    'created_date' => date('Y-m-d H:i:s'),
                    'created_by'=> $branch_id
                );
    
                $table_name = 'enrollment_master';
    
                $enrollment_master_id = $this->Common_Model->insertIntoTable($table_name, $insert_array);

                if($enrollment_master_id){
                    $status = true;
                    $res_message = "Enrollment added successfully.";
                }else{
                    $status = false;
                    $res_message = "Something went wrong! Please try again... ";
                }
            }
            else{
                $status = false;
                $res_message = "Something went wrong! Please try again... ";
            }
            
        }
        else{
            $status = false;
            $res_message = "Enrollment already exists in records, Please choose different course.";
        }
        
        $response = array(
            'status'    => $status,
            'message'   => $res_message
        );

        echo json_encode($response);
        exit;
    }

}