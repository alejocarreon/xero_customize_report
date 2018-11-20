<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Company extends CI_Controller {
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
    function index(){
    }
    function id() {
     $data['google_login_url']=$this->google->get_login_url();
      //$validate = $this->Models->verify_user($this->session->userdata('user_session'));
      if ($this->session->userdata('user_session')) {
      $this->load->view('themes/header');
      $this->load->view('themes/headernav');
      $this->load->view('themes/sidenav');
      //$this->load->view('filemanager', $data);
      $this->load->view('Company', $data);
      $this->load->view('themes/footer');
    }else{
      $data['google_login_url']=$this->google->get_login_url();
      //$validate = $this->Models->verify_user($this->session->userdata('user_session'));
       $this->load->view('themes/header');
       //$this->load->view('filemanager', $data);
     $this->load->view('SignIn', $data);
      $this->load->view('themes/footer');
    }
  }

}
