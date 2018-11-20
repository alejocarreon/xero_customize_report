<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->database();
        
    }


    public function index() {
        $data['title'] = '';
        $data['pageclass'] = '';
        if ($this->session->userdata('user_session')) {
            $data['title'] = "Welcome to TOA Portal";
            $this->load->view('includes/header_menu');
            $this->load->view('includes/bodytop');
            $this->load->view('left');
            $this->load->view('center');
            $this->load->view('right');
            $this->load->view('includes/bodybottom');
        } else {
            $data['title'] = "Login";
            $data['pageclass'] = "login-page";
            $this->load->view('login');
        }
        $this->load->view('includes/header', $data);
        $this->load->view('includes/footer');
    }

}
