<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Filemanager extends CI_Controller {
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
      $data['google_login_url']=$this->google->get_login_url();
      //$validate = $this->Models->verify_user($this->session->userdata('user_session'));
      $this->load->view('includes/header-nav');
      $this->load->view('includes/header');
      $this->load->view('includes/sidebar');
      $this->load->view('filemanager', $data);
      $this->load->view('includes/footer');
    }

}
