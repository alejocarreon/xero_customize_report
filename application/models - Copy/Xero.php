<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Xero extends CI_Model {

    public function __construct() {
        parent::__construct();
        header('Access-Control-Allow-Origin: *');
    }

    function index() {

    }



}
