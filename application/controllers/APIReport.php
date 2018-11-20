<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class APIReport extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('Modules');
        $this->load->model('Models');
    }
    function index() {
          $this->load->library('Pdf');
          $this->load->view('APIReport');
   }

}
