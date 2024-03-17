<?php

class Student_Details_Model extends CI_Model {
    function __construct() {
        parent::__construct();
    }

    //--- [START]  - Student details

    /*  Get Student status list  */
    function getStudentStatusMasterList(){
        $sql = "SELECT * FROM student_status_master";
        
        // if($branch_id !== '' && $branch_id !== null && $branch_id !== NULL){
        //     $sql .= " WHERE branch_id = $branch_id";
        // }
    
        $result = $this->db->query($sql)->result_array();
    
        return $result;
    }

    /*  Get all student list from status  */
    function getStudentDetailsByStatus($status = NULL){

        $sql = "SELECT * FROM student_master WHERE 1=1 ";

        if($status!='' && $status!=null && $status!=NULL){
            $sql .= " AND  status=$status ";
        }

        $result = $this->db->query($sql)->result_array();

        return $result;
    }

    /*  Get Student Info from EMAIL  */
    function getStudentDetailsByEmail($emailid){
        $result = $this->db->query("SELECT * FROM student_master WHERE emailid = '".$emailid."'")->row_array();

        return $result;
    }

    /*  Get Student Info from ID  */
    function getStudentDetailsById($student_id){
        $result = $this->db->query("SELECT * FROM student_master WHERE student_id = '".$student_id."'")->row_array();

        return $result;
    }

    /*  Get Student Info from PHONE   */
    function getStudentDetailsByPhone($contact){
        $result = $this->db->query("SELECT * FROM student_master WHERE contact = '".$contact."' AND shop_id=$shop_id")->result_array();

        return $result;
    }

    /*  Get Student Info from emailid & user id  */
    function getStudentsInfoFromEmailWithOtherUserId($emailid, $student_id){
        $result = $this->db->query("SELECT * FROM student_master WHERE emailid = '".$emailid."' AND student_id != $student_id")->row_array();

        return $result;
    }

     //  Delete Syudent Info by ID  
     function deleteStudentById($student_id){
        $result = $this->db->query("Delete FROM student_master WHERE student_id = $student_id");
        return $result;
    }

    /* Get Latest video lecture link */
    function getLatestVideoLectureLink($student_id){
        $current_datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("SELECT em.course_master_id, em.student_id, em.valid_upto, cvm.video_link, cvm.video_title
                                    FROM `enrollment_master` as em 
                                    INNER JOIN course_video_master as cvm ON cvm.course_master_id = em.course_master_id
                                    WHERE em.student_id = '".$student_id."' AND
                                    em.valid_upto >= '".$current_datetime."' 
                                    ORDER by cvm.created_date DESC limit 1")->result();
        return $result;
    }


    /* Get all active video lecture links */
    function getVideoLectureLinks($student_id){
        $current_datetime = date('Y-m-d H:i:s');

        $result = $this->db->query("SELECT em.course_master_id, em.student_id, em.valid_upto, cvm.video_link, cvm.video_title,                        cm.course_name 
                                    FROM `enrollment_master` as em 
                                    INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id 
                                    INNER JOIN course_video_master as cvm ON cvm.course_master_id = em.course_master_id
                                    WHERE em.student_id = '".$student_id."' AND
                                    em.valid_upto >= '".$current_datetime."' 
                                    ORDER by cvm.created_date DESC ")->result();
        return $result;
    }


    // count all Video lectures from list
    function countAllVideoLectureList($where){
        $sql = "SELECT COUNT(*) AS total 
            FROM `enrollment_master` as em 
            INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id 
            INNER JOIN course_video_master as cvm ON cvm.course_master_id = em.course_master_id
            INNER JOIN course_category_master as ccm ON cm.course_category_id = ccm.course_category_id 
            WHERE $where";
            
        $result = $this->db->query($sql);
        return $result->row();
    }

    // GET LIST OF ALL Video lectures from list
    function listVideoLinksQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT em.course_master_id, em.student_id, em.valid_upto, cvm.video_link, cvm.video_title, cm.course_name, cm.course_category_id, cvm.created_date as uploaded_date, ccm.course_category_name  
                FROM `enrollment_master` as em 
                INNER JOIN course_master as cm ON cm.course_master_id = em.course_master_id 
                INNER JOIN course_video_master as cvm ON cvm.course_master_id = em.course_master_id
                INNER JOIN course_category_master as ccm ON cm.course_category_id = ccm.course_category_id 
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
   
    // Get all courses not enrolled by student
    public function getNotEnrolledCourses($student_id, $branch_filter) {
        $this->db->select(array('course_master_id','course_name'));
        $this->db->from('course_master');

        $this->db->where('course_master_id NOT IN (SELECT course_master_id FROM enrollment_master WHERE student_id = ' . $student_id . ')', NULL, FALSE);
        $this->db->where($branch_filter);
        $this->db->where('course_status',1);
    
        $query = $this->db->get();
        return $query->result_array();
    }

    // Check if a student is enrolled in a course
    public function is_student_enrolled($student_id, $course_master_id)
    {
        $this->db->select('course_master_id');
        $this->db->from('enrollment_master');
        $this->db->where('student_id', $student_id);
        $this->db->where('course_master_id', $course_master_id);
        $query = $this->db->get();

        // Check if any rows returned
        if ($query->num_rows() > 0) {
            return TRUE; 
        } else {
            return FALSE;
        }
    }

}//end of class

?>