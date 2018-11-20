<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: application/json');

class BudgetSummary extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Modules');
        $this->load->model('Models');
        $this->load->database();
    }

    public function index() {

    }

    function connect() {
      $key = $_GET['key'];
      $secret = $_GET['secret'];
      $settings = array(
      'consumer'  => array(
          'key'   => "" .$key. "",
          'secret' => "" .$secret. ""

        ),
        'certs'   => array(
          'private'   => APPPATH.'certs/private-key.pem',
          'public'    => APPPATH.'certs/public-key.cer'
        ),
        'format'    => 'json',
        'path'    => "/BudgetSummary"
    );

    $this->load->library('Xero', $settings);

    $result = $this->xero->Reports();
    ////	$result = $this->xero->Contacts(false, false, array("Name"=>"Test Account"));
    $all_accounts = $this->xero->Accounts;
    $value = array("message" => "success", "text" => $result );
    print $characters = json_encode($result);

    }

}
