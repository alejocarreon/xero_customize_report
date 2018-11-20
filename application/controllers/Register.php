<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');

        $this->load->database();
    }

    public function index() {
        $data['title'] = '';
        $data['pageclass'] = '';
        $this->load->view('includes/header', $data);
        if ($this->session->userdata('user_session')) {

            $data['title'] = "Register";
            //$this->load->view('includes/header_menu');
             //$this->load->view('includes/bodytop');
            $this->load->view('Register');
          
             //$this->load->view('includes/bodybottom');
        } else {
            $data['title'] = "Register";
            $data['pageclass'] = "login-page";
            $this->load->view('login');
        }

        $this->load->view('includes/footer');
    }

}
