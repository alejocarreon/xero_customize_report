<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model("Module");
        $this->load->model('Models');
        $this->load->library('session');
       $this->load->library('google');
    }
    function index() {
      $data['google_login_url']=$this->google->get_login_url();

       $validate = $this->Models->verify_user($this->session->userdata('user_session'));
       //   $this->load->view('authenticate',$data);

        $this->load->view('includes/header');
        if (strlen($this->session->userdata('user_session'))!= 0)   {

            if($validate==0){
                unset($_SESSION['user_session']);
                $this->session->unset_userdata('user_session');
                session_destroy();
                unset($_SESSION['access_token']);
                $session_data=array(
                    'sess_logged_in'=>0);
                $this->session->set_userdata($session_data);
                $this->load->view('404');
            }else{
              $this->load->view('includes/header-nav');
              $this->load->view('includes/sidemenu');
                $this->load->view('Main');
            }
        } else {
            $this->load->view('Login', $data);
        }
        $this->load->view('includes/footer');
    }
    function folder(){
        $this->load->view('includes/header');
        if (strlen($this->session->userdata('user_session'))!= 0) {
            $this->load->view('includes/header-nav');
            $this->load->view('includes/sidemenu');
            $this->load->view('folder');
        } else {
            $this->load->view('Login');
        }
        $this->load->view('includes/footer');
    }
}
