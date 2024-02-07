<?php

defined('BASEPATH') OR exit('No direct script access allowed');

Class Front extends CI_Controller {

    private $contentInfo = array();

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('common', 'url', 'form', 'commonlanguage'));
        $this->load->model(array('Common', 'Db_Utilities', 'First_model'));
        $this->contentInfo = getContenData();
    }

}
