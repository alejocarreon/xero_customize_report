<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Models');
        $this->load->model('Modules');
        $this->load->database();
    }
    public function index() {
        
    }
    public function id() {
        $data['title'] = '';
        $data['pageclass'] = '';
        $this->load->view('includes/header', $data);
        if ($this->session->userdata('user_session')) {
            $data['title'] = "Welcome to TOA Portal";
            $this->load->view('includes/header_menu');
            $this->load->view('includes/bodytop');
            $this->load->view('left');
            $this->load->view('Announcement');
            $this->load->view('right');
            $this->load->view('includes/bodybottom');
        } else {
            $data['title'] = "Welcome to TOA Portal";
            $data['pageclass'] = "login-page";
            $this->load->view('login');
        }
        $this->load->view('includes/footer');
    }
    public function user() {
        $data['title'] = '';
        $data['pageclass'] = '';
        $this->load->view('includes/header', $data);
        if ($this->session->userdata('user_session')) {
            $data['title'] = "Welcome to TOA Portal";
            $this->load->view('includes/header_menu');
            $this->load->view('includes/bodytop');
            $this->load->view('left');
            $this->load->view('User-announcement');
            $this->load->view('right');
            $this->load->view('includes/bodybottom');
        } else {
            $data['title'] = "Welcome to TOA Portal";
            $data['pageclass'] = "login-page";
            $this->load->view('login');
        }
        $this->load->view('includes/footer');
    }

}
