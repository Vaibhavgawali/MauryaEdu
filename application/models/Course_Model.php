<?php

class Course_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    public function loadCourses($pagination,$additional_where = NULL){
        $sql = "SELECT course_master.*, course_category_master.* 
        FROM course_master 
        LEFT JOIN course_category_master ON course_master.course_category_id = course_category_master.course_category_id 
        WHERE course_master.course_status = '1'";

        if (!empty($additional_where)) {
            $sql .= $additional_where;
        }

        $sql .= " ORDER BY course_master.created_date DESC 
                LIMIT {$pagination['offset']}, {$pagination['limit']}";

        $result = $this->db->query($sql)->result_array();
        return $result;
    }

    public function totalCourses($additional_where = NULL){
        $where='';
        if (!empty($additional_where)) {
            $where .= $additional_where;
        }
        
        $sql = "SELECT COUNT(*) as total FROM course_master WHERE course_status = '1' $where";
        $result = $this->db->query($sql)->row_array();

        return $result;
    }

    public function getCourseDetailsById($course_id){
        $result = $this->db->query("SELECT cm.*, ccm.course_category_name, ccm.course_category_info 
                            FROM course_master as cm 
                            INNER JOIN course_category_master as ccm ON ccm.course_category_id = cm.course_category_id
                            WHERE cm.course_master_id = '".$course_id."' ")->row_array();
                            // WHERE cm.course_status = '1' AND cm.course_master_id = '".$course_id."' ")->row_array();

        return $result;
    }

    public function loadEnrolledCourses($pagination,$where){
        $result = $this->db->query("SELECT em.*, em.created_date as enrollment_date, cm.*, cctm.* 
                            FROM enrollment_master as em
                            INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id
                            INNER JOIN course_category_master as cctm ON cm.course_category_id = cctm.course_category_id
                            WHERE ".$where."  
                            LIMIT ".$pagination['offset'].",".$pagination['limit'])->result_array();

        return $result;
    }

    public function totalEnrolledCourses($where){
        $result = $this->db->query("SELECT COUNT(*) as total 
                            FROM enrollment_master as em 
                            INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id
                            WHERE ".$where."   ")->row_array();

        return $result;
    }

    public function getEnrolledCourseDetailsById($student_id,$course_id){
        //$today = date('Y-m-d H:i:s');

        $result = $this->db->query("SELECT em.*, cm.*, 
                            ccm.course_category_name, ccm.course_category_info
                            FROM enrollment_master as em
                            INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id
                            INNER JOIN course_category_master as ccm ON ccm.course_category_id = cm.course_category_id
                            WHERE em.student_id = '".$student_id."' AND em.course_master_id = '".$course_id."'")->row_array();

        return $result;
    }   

    public function getCourseVideoDetails($course_master_id){
        $result = $this->db->query("SELECT * 
                            FROM course_video_master 
                            WHERE course_master_id = '".$course_master_id."' ORDER BY created_date DESC")->result();

        return $result;   
    }

    public function getCourseChapterDetails($course_master_id){
        $result = $this->db->query("SELECT *  
                    FROM chapter_master 
                    WHERE course_master_id = '".$course_master_id."' ORDER BY created_date DESC")->result();

        return $result;   
    }

    public function getCourseChapterDocDetails($course_chapter_master_id){
        $result = $this->db->query("SELECT chapter_document_master_id, document_title, document_file,document_link, created_date as doc_created_date  
                    FROM chapter_document_master 
                    WHERE chapter_master_id = '".$course_chapter_master_id."' ORDER BY created_date DESC")->result();

        return $result;   
    }

    public function getCourseSubChapterDetails($course_chapter_master_id){
        $result = $this->db->query("SELECT sub_chapter_master_id, sub_chapter_name, sub_chapter_info, created_date as sub_chapter_created_date  
                    FROM sub_chapter_master 
                    WHERE chapter_master_id = '".$course_chapter_master_id."' ORDER BY created_date DESC")->result();

        return $result;   
    }

    public function getCourseSubChapterDocDetails($course_sub_chapter_master_id){
        $result = $this->db->query("SELECT sub_chapter_document_master_id, document_title, document_file, created_date as sub_doc_created_date  
                    FROM sub_chapter_document_master 
                    WHERE sub_chapter_master_id = '".$course_sub_chapter_master_id."' ORDER BY created_date DESC")->result();

        return $result;   
    }

    public function CheckCourseIfAlreadyBought($logged_in_student_id,$course_master_id){
        $today = date('Y-m-d H:i:s');

        // echo $sql = "SELECT * FROM enrollment_master WHERE student_id = '".$logged_in_student_id."' AND course_master_id = '".$course_master_id."' AND valid_upto >= '".$today."' ";
        // die();

        $result = $this->db->query("SELECT * FROM enrollment_master WHERE student_id = '".$logged_in_student_id."' AND course_master_id = '".$course_master_id."' AND valid_upto >= '".$today."' ")->result();

        return $result;
    }

    public function checkCoupon($coupon_code){
        $result = $this->db->query("SELECT * FROM discount_coupon_master WHERE discount_coupon_code = '".$coupon_code."' AND is_locked = '1' AND discount_coupon_status = '1' ")->result();

        return $result;
    }

    public function checkCouponUsedCount($discount_coupon_master_id){
        $result = $this->db->query("SELECT COUNT(*) as total FROM razor_payment_master WHERE discount_coupon_master_id = '".$discount_coupon_master_id."' ")->result();

        return $result;
    }



}//end of class

?>