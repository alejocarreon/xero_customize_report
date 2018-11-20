<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: application/json');

class CXero extends CI_Controller {

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
      $this->session->unset_userdata('images_logo');
      $settings = array(
      'consumer'  => array(
          ////'key'   => 'YKLU91MO3YOQGV5EUKWLYXOEMPBEEZ',
          ///'secret' => 'QGWQQ1TTLTN3QFRVOUXS8AQPJRTVA8'
          'key'   => $this->input->post('APIKey'),
          'secret'  =>  $this->input->post('APISecret')
        ),
        'certs'   => array(
          'private'   => APPPATH.'certs/private-key.pem',
          'public'    => APPPATH.'certs/public-key.cer'
        ),
        'format'    => 'json'
    );

    $this->load->library('Xero', $settings);

    $result = $this->xero->Reports();
    $all_accounts = $this->xero->Accounts;
    $img = $this->input->post('srchvalue');
    $jsonvalue = $this->input->post('jsonvalue');

    $this->session->set_userdata('key', $this->input->post('APIKey'));
    $this->session->set_userdata('secret', $this->input->post('APISecret'));

     //$this->session->set_userdata('images_logo', $img);
    // $this->session->set_userdata('jsonvalue', $jsonvalue);

      $value = array("message" => "success", "text" => $result );
      print json_encode($value);
    }

}
