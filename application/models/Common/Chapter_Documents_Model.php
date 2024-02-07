<?php

class Chapter_Documents_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - chapter document details

    /*  Get chapter document Info using status  */
    function getAllChapterDocumentsDetailsByStatus($document_status){
        $result = $this->db->query("SELECT * FROM chapter_document_master WHERE document_status = '".$document_status."'")->result_array();

        return $result;
    }

    /*  Get chapter document Info from ID  */
    function getChapterDocumentsDetailsById($chapter_document_master_id){
        $result = $this->db->query("SELECT * FROM chapter_document_master WHERE chapter_document_master_id = $chapter_document_master_id.")->row_array();

        return $result;
    }

    // count all chapter document from list
    function countAllChapterDocumentsList($where){
        $sql = "SELECT COUNT(chapter_document_master.chapter_document_master_id) AS total 
            FROM chapter_document_master 
            LEFT JOIN chapter_master ON chapter_document_master.chapter_master_id = chapter_master.chapter_master_id 
            LEFT JOIN course_master ON chapter_document_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON chapter_document_master.course_category_id = course_category_master.course_category_id 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL chapter document from list
    function listChapterDocumentsQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT chapter_document_master.*, course_master.course_name, course_category_master.course_category_name, course_category_master.course_category_info, chapter_master.chapter_name 
            FROM chapter_document_master 
            LEFT JOIN chapter_master ON chapter_document_master.chapter_master_id = chapter_master.chapter_master_id 
            LEFT JOIN course_master ON chapter_document_master.course_master_id = course_master.course_master_id 
            LEFT JOIN course_category_master ON chapter_document_master.course_category_id = course_category_master.course_category_id 
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