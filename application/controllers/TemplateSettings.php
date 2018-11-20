<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class TemplateSettings extends CI_Controller {
        public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model("Modules");
        $this->load->model('Models');
        $this->load->library('session');
       $this->load->library('google');
    }
    function index() {
        $this->load->view('includes/header-nav');
        $this->load->view('includes/header');
        $this->load->view('includes/sidemenu');
        $this->load->view('TemplateSettings');
        $this->load->view('includes/footer');
    }

}
