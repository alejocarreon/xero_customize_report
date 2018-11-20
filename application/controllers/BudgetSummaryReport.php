<?php

defined('BASEPATH') OR exit('No direct script access allowed');



class BudgetSummaryReport extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Modules');
        $this->load->model('Models');
        $this->load->database();
    }

    public function index() {
                $this->load->view('BudgetSummaryReport');
    }


}
