<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        checkAdminLoginSession();
        
        $login_detail = $this->session->userdata('login_detail');
        //print_r_custom($login_detail,1);
        $this->data['login_detail'] = $login_detail;
        $this->load->admintemplate('dashboard', $this->data);
    }

}