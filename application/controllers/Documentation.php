
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Documentation extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->database();
        $this->load->helper('cookie');
    }
    function index() {
        $this->load->view('includes/header');
        if (empty($this->session->userdata('user_session'))) {
            $this->load->view('includes/header-nav');
            $this->load->view('includes/sidemenu');
            $this->load->view('includes/doc');
        } else {
            $this->load->view('login');
        }
        $this->load->view('includes/footer');
    }
}


