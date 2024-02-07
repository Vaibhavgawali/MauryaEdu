<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->model('Common/Enrollment_Model');
        $this->load->model('Common/Student_Details_Model');
        $this->load->helper('common_helper');
        $this->load->model('Course_Model');
    }

    public function index()
    {
        checkStudentLoginSession();
        
        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;

        $this->data['live_video_lecture_link'] = '';
        $video_link_data = $this->Student_Details_Model->getLatestVideoLectureLink($login_detail['student_id']);
        // print_r_custom($video_link_data,1);
        if(count($video_link_data) == 1)
        {
            $this->data['live_video_lecture_link'] = $video_link_data[0]->video_link;
        }
        
        $this->load->studenttemplate('dashboard', $this->data);
    }

    public function live_lecture()
    {
        checkStudentLoginSession();

        addJs(array("student/video_lectures.js"));
        
        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        $this->data['validEnrollmentList'] = $validEnrollmentList;
    
        $this->load->studenttemplate('live_lecture', $this->data);

    }

    public function videolecturesListAjax()
    {
        $login_detail = $this->session->userdata('student_login_detail');
        $student_id  = $login_detail['student_id'];

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
            0=>'em.course_master_id',
            1=>'ccm.course_category_name',
            2=>'cm.course_name',
            3=>'cvm.video_title',
            4=>'cvm.video_link',
            5=>'em.valid_upto',
            6=>'cvm.created_date',
        ); 
        
        $order_by = $colums[$order[0]['column']];
        $order_dir = $order[0]['dir'];  /*Order by asc and desc*/
        /**/

        $where = " 1=1 AND em.student_id = '".$student_id."' ";

        $current_datetime = date('Y-m-d H:i:s');
        $where .= " AND em.valid_upto >= '".$current_datetime."' "; 

        // $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($student_id);

        // $course_category_array = array();
        // for($i=0; $i<count($validEnrollmentList); $i++){

        //     $course_category_id = $validEnrollmentList[$i]['course_category_id'];

        //     if($i==0){
        //         $where .= " AND (FIND_IN_SET ($course_category_id, announcement_master.course_category_id) ";
        //     }
        //     else{
        //         $where .= " OR (FIND_IN_SET ($course_category_id, announcement_master.course_category_id))";
        //     }

        //     if($i==(count($validEnrollmentList)-1) || count($validEnrollmentList)==1){
        //         $where .= " )";
        //     }
            
        // }
        
        /*Saerch common search*/
        if (!empty($searchTerm)) {
            $where .= "AND (";
            $where .= " cm.course_name like '%$searchTerm%'  OR
                        ccm.course_category_name like '%$searchTerm%' OR 
                        cvm.video_title like '%$searchTerm%' ";
            $where .= ") ";
        }

        /*Count Table result*/
        $total_count_array = $this->Student_Details_Model->countAllVideoLectureList($where);
        $totalData = $total_count_array->total;
        /*Total Filter Record and fetch data*/
        $list_array = $this->Student_Details_Model->listVideoLinksQuery($where, $order_by, $start, $length, $order_dir);
        $totalFiltered = (!empty($searchTerm)) ? $list_array['Result_total_filter'] : $totalData;
        $result = $list_array['Result'];
        $data = array();

        foreach ($result as $main) {
            $start++;

            $nestedData = array();
            
            $nestedData['course_master_id'] = $start;
            $nestedData['course_name'] = $main['course_name'];
            $nestedData['video_title'] = $main['video_title'];
            $nestedData['video_link'] = "<a href = '".$main['video_link']."' target='_blank'> View </a>";
            $nestedData['valid_upto'] = $main['valid_upto'];
            $nestedData['uploaded_date'] = $main['uploaded_date'];
            $nestedData['course_category_name'] = $main['course_category_name'];

            // $course_category_id = $main['course_category_id'];
            // $course_category_list = $this->Course_Category_Model->getCourseCategoryDetailsById($course_category_id);
            // $nestedData['course_category_name'] = $course_category_list['course_category_name'];

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

    public function theory_booklet(){
        checkStudentLoginSession();
        
        // header("Location: ".APP_LINK);
        // die();
        
        addJs(array("student/booklet.js"));

        $login_detail = $this->session->userdata('student_login_detail');

        $studentInfo = $this->Student_Details_Model->getStudentDetailsById($login_detail['student_id']);

        $validEnrollmentList = $this->Enrollment_Model->getValidEnrollmentDetailsByStudentId($login_detail['student_id']);

        $this->data['login_detail'] = $login_detail;
        $this->data['studentInfo'] = $studentInfo;
        
        if(count($validEnrollmentList) > 0)
        {   
            for($v=0;$v<count($validEnrollmentList);$v++)
            {
                //course chapters
                $validEnrollmentList[$v]['course_chapter'] = $this->Course_Model->getCourseChapterDetails($validEnrollmentList[$v]['course_master_id']);

                if(count($validEnrollmentList[$v]['course_chapter'])>0)
                {                    
                    for($i=0;$i<count($validEnrollmentList[$v]['course_chapter']);$i++)
                    {
                        //chapter documents                        
                        $course_chapter_doc_details = $this->Course_Model->getCourseChapterDocDetails($validEnrollmentList[$v]['course_chapter'][$i]->chapter_master_id);
                        $validEnrollmentList[$v]['course_chapter'][$i]->chapter_doc = count($course_chapter_doc_details) > 0 ? $course_chapter_doc_details : array();   

                        //sub chapter
                        // $course_subchapter_details = $this->Course_Model->getCourseSubChapterDetails($course_chapter_details[$i]->chapter_master_id);

                        $course_subchapter_details = $this->Course_Model->getCourseSubChapterDetails($validEnrollmentList[$v]['course_chapter'][$i]->chapter_master_id);
                        $validEnrollmentList[$v]['course_chapter'][$i]->sub_chapters = count($course_subchapter_details) > 0 ? $course_subchapter_details : array();

                        
                        //sub chapter documents
                        if(count($course_subchapter_details) > 0)
                        {
                            for($p=0;$p<count($course_subchapter_details);$p++)
                            {
                                $course_sub_chapter_doc_details = $this->Course_Model->getCourseSubChapterDocDetails($course_subchapter_details[$p]->sub_chapter_master_id);
                                $course_subchapter_details[$p]->sub_chapter_doc = count($course_sub_chapter_doc_details) > 0 ? $course_sub_chapter_doc_details : array();   
                            }
                        }
                    }
                }

            }

            
            // print_r_custom($validEnrollmentList,1);
        }

        $this->data['validEnrollmentList'] = count($validEnrollmentList) > 0 ? $validEnrollmentList : array();
        // $this->data['validEnrollmentList'] = $validEnrollmentList;
        // print_r_custom($this->data['course_chapter_details'],1);

        $this->load->studenttemplate('theory-booklet', $this->data);

    }

}