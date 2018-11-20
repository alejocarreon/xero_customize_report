<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('Module');
    }
    function index() {
        $this->load->view('includes/header');
         if (strlen($this->session->userdata('user_session'))!= 0)   {
            $this->load->view('includes/header-nav');
            $this->load->view('includes/sidemenu');
            $this->load->view('Settings');
        } else {
            $this->load->view('Login');
        }
        $this->load->view('includes/footer');
    }

}
