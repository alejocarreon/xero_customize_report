<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class TrialBalanceContent extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Modules');
        $this->load->model('Models');
        $this->load->database();
    }

    public function index() {
        $data['title'] = '';
        $data['pageclass'] = '';
        $this->load->view('includes/header', $data);
        if ($this->session->userdata('user_session')) {

            $data['title'] = "Register";
            $this->load->view('includes/header_menu');
            $this->load->view('includes/bodytop');
            $this->load->view('Users');

            $this->load->view('includes/bodybottom');
        } else {
            $data['title'] = "Register";
            $data['pageclass'] = "login-page";
            $this->load->view('login');
        }

        $this->load->view('includes/footer');
    }

    function page() {
        $data['title'] = '';
        $data['pageclass'] = '';
        $this->load->view('includes/header', $data);
        $data['title'] = "Register";
        $this->load->view('includes/header_menu');
        $this->load->view('includes/bodytop');
        $this->load->view('Users');
        $this->load->view('includes/bodybottom');
         $this->load->view('includes/footer');
    }

}
