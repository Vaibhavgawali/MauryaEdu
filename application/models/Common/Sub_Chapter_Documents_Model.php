<?php

class Sub_Chapter_Documents_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - sub chapter document details

    /*  Get sub chapter document Info using status  */
    function getAllSubChapterDocumentsDetailsByStatus($document_status){
        $result = $this->db->query("SELECT * FROM sub_chapter_document_master WHERE document_status = '".$document_status."'")->result_array();

        return $result;
    }

    /*  Get sub chapter document Info from ID  */
    function getSubChapterDocumentsDetailsById($sub_chapter_document_master_id){
        $result = $this->db->query("SELECT * FROM sub_chapter_document_master WHERE sub_chapter_document_master_id = $sub_chapter_document_master_id.")->row_array();

        return $result;
    }

    // count all sub chapter document from list
    function countAllSubChapterDocumentsList($where){
        $sql = "SELECT COUNT(sub_chapter_document_master.sub_chapter_document_master_id) AS total 
            FROM sub_chapter_document_master 
            LEFT JOIN sub_chapter_master ON sub_chapter_document_master.sub_chapter_master_id = sub_chapter_master.sub_chapter_master_id
            LEFT JOIN chapter_master ON sub_chapter_document_master.chapter_master_id = chapter_master.chapter_master_id 
            LEFT JOIN course_master ON sub_chapter_document_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON sub_chapter_document_master.course_category_id = course_category_master.course_category_id 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL sub chapter document from list
    function listSubChapterDocumentsQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT sub_chapter_document_master.*, course_master.course_name, course_category_master.course_category_name, course_category_master.course_category_info, chapter_master.chapter_name, sub_chapter_master.sub_chapter_name 
            FROM sub_chapter_document_master 
            LEFT JOIN sub_chapter_master ON sub_chapter_document_master.sub_chapter_master_id = sub_chapter_master.sub_chapter_master_id
            LEFT JOIN chapter_master ON sub_chapter_document_master.chapter_master_id = chapter_master.chapter_master_id 
            LEFT JOIN course_master ON sub_chapter_document_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON sub_chapter_document_master.course_category_id = course_category_master.course_category_id 
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

}