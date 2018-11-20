<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Logout extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('Module');
    }
    function index() {

        unset($_SESSION['user_session']);
        $base = base_url();
       header('Location: '.$base);
    }
   
}
