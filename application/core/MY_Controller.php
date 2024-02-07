<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller {

    function __construct() {
        parent::__construct();
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        error_reporting(-1);
        ini_set('error_reporting', E_ALL);

        $this->data['page_title'] = 'ChemCaliba Student Portal';
        $this->data['page_title'] = 'ChemCaliba Student Portal';
        $this->data['application_version'] = '?v=g101';
        $this->data['before_body'] = '';
        $this->data['css_files'] = array();
        $this->data['js_files'] = array();
        $this->data['page_name'] = "page_" . $this->router->fetch_class();
        $this->data['page_sub_name'] = "page_sub_" . $this->router->fetch_method();
        $this->load->library(array('session', 'form_validation', 'calendar', 'pagination', 'email', 'table', 'upload'));
        $this->load->helper(array('url', 'form', 'date', 'html', 'captcha', 'email', 'date', 'commonlanguage', 'common','common_helper'));
        $this->load->database();
        //$this->shop_db = $this->load->database('shop', TRUE);
        $this->load->model('Common_Model');
        //addCss(array("bootstrap.min.css","app.min.css","icons.min.css"));
        //addJs(array("vendor.min.js","app.min.js"));
    }
}

class Front_Controller extends MY_Controller {
    function __construct() {
        parent::__construct();
        $this->load->library(array('image_lib', 'encrypt'));
        $this->load->helper(array('common', 'security','common_helper'));
        $this->load->database();
        ///$this->load->model('Privileges_Model');
//        isUserLoggedIn();

        $meta_tags = array();
        $meta_tags['charset'] = 'UTF-8';
        $meta_tags['viewport'] = 'width=device-width, initial-scale=1.0';
        $meta_tags['description'] = 'ChemCaliba Student Portal';
        $meta_tags['keywords'] = 'ChemCaliba Student Portal';
        $meta_tags['author'] = 'ChemCaliba Student Portal';
        $meta_tags['language'] = 'English';
        $meta_tags['subject'] = 'ChemCaliba Student Portal';
        $meta_tags['robots'] = 'index, follow';
        $meta_tags['revisit-after'] = '1 days';
        $meta_tags['cache-control'] = 'no-cache';
        // $this->data['common_info'] = getContenData();
        $this->data['meta_tags'] = $meta_tags;
        $this->data['params'] = $this->uri->uri_to_assoc(3);
        // $this->data['today_date'] = getTodayDate();
    }

}

class Admin_Controller extends MY_Controller {



    function __construct() {
        parent::__construct();
        $this->load->library(array('image_lib', 'encrypt', 'email'));
        $this->load->helper(array('common'));
        $meta_tags = array();
        $meta_tags['viewport'] = 'width=device-width, initial-scale=1.0';
        $meta_tags['description'] = 'ChemCaliba Student Portal';
        $meta_tags['keywords'] = 'ChemCaliba Student Portal';
        $meta_tags['author'] = 'ChemCaliba Student Portal';
        $meta_tags['language'] = 'English';
        $meta_tags['subject'] = 'ChemCaliba Student Portal';
        $meta_tags['robots'] = 'index, follow';
        $meta_tags['revisit-after'] = '1 days';
        $meta_tags['cache-control'] = 'no-cache';
        $this->data['common_info'] = getContenData();
        $this->data['meta_tags'] = $meta_tags;
        $this->data['params'] = $this->uri->uri_to_assoc(4);


        //addCss(array('ionicons.min.css', 'admin/adminlte.min.css', 'admin/all-skins.min.css', 'admin/blue.css', 'admin/responsive.css', 'dataTables.bootstrap.min.css'));
        //addJs(array('admin/app.min.js','admin/validation.js', 'admin/main.js', 'admin/data.js', 'admin/adminlte.min.js', 'jquery.dataTables.min.js', 'dataTables.bootstrap.min.js', 'admin/admin_jquery.js', 'admin/jquery.slimscroll.min.js', 'admin/fastclick.js', 'admin/ic.js'));
    }

}

class My_Account extends Front_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library("pagination");
    }

}

class Static_Controller extends MY_Controller {
    function __construct() {
        parent::__construct();
    }
}
?>