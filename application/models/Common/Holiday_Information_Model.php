<?php

class Holiday_Information_Model extends CI_Model {

    function __construct() {
        parent::__construct();
    }
    
    //--- [START]  - Holiday Information details

    /*  Get Holiday Information Info using status  */
    function getAllHolidayInformationDetailsByStatus($holiday_information_status){
        $result = $this->db->query("SELECT * FROM holiday_information_master WHERE holiday_information_status = '".$holiday_information_status."'")->result_array();

        return $result;
    }

    /*  Get Holiday Information Info from ID  */
    function getHolidayInformationById($holiday_information_master_id){
        $result = $this->db->query("SELECT * FROM holiday_information_master WHERE holiday_information_master_id = $holiday_information_master_id.")->row_array();

        return $result;
    }

    // count all Holiday Information from list
    function countAllHolidayInformationList($where){
        $sql = "SELECT COUNT(holiday_information_master.holiday_information_master_id) AS total 
            FROM holiday_information_master 
            WHERE $where";
        $result = $this->db->query($sql);
        return $result->row();
    }


    // GET LIST OF ALL Holiday Information from list
    function listHolidayInformationQuery($where, $order_by, $start, $length, $order_dir){
        $sql = "SELECT holiday_information_master.*
            FROM holiday_information_master 
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

    /*  Get test records Info from student id & test rec status  */
    function getHolidayInformationByCourseCategoryIdAndHolidayInformationStatus($course_category_id=NULL, $holiday_information_status=NULL){

        $sql = "SELECT * FROM holiday_information_master WHERE 1=1 ";

        if($course_category_id != NULL){
            $sql .= " AND course_category_id=$course_category_id ";
        }

        if($holiday_information_status != NULL){
            $sql .= " AND holiday_information_status='".$holiday_information_status."'";
        }

        $result = $this->db->query($sql)->row_array();

        return $result;
    }

}