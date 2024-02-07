<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends Front_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('Common_Model');
        $this->load->helper('common_helper');
    }

    public function index()
    {
        $this->load->view('home');
    }
}
