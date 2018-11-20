<?php

defined('BASEPATH') OR exit('No direct script access allowed');
header('Content-Type: application/json');

class Response extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model("Models");
        $this->load->model("Module");
        $this->load->model("Modules");
        $this->load->library('session');
    }

    function index() {

    }

    function add_users() {
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $middlename = $this->input->post('middlename');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $position = $this->input->post('user_type');
         $user_type = $this->input->post('position');
        $data = array(
            'email' => $email,
            'password' => sha1($password),
            'fname' => $firstname,
            'middle' => $middlename,
            'lastname' => $lastname,
            'position' => $position
        );

        $execute_data = $this->Module->add_user_info($data);
        if ($execute_data == 'exist') {
            $value = array(
                "message" => "success",
                "text" => "exist",
                "type" => "info"
            );
        } else {
            $value = array(
                "message" => "success",
                "text" => "success",
                "type" => "info"
            );
        }
        print json_encode($value);
    }

    function update_user() {
        $id = $this->input->post('user_value');
        $firstname = $this->input->post('firstname');
        $lastname = $this->input->post('lastname');
        $middlename = $this->input->post('middlename');
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $user_type = $this->input->post('user_type');
        $position = $this->input->post('position');

        $data = array(
            'fname' => $firstname,
            'middle' => $middlename,
            'lastname' => $lastname,
            'email' => $email,
            'position' => $position
        );

        $this->db->where('ID', $id);
        $this->db->update('user_info', $data);


        $value = array(
            "message" => "success",
            "text" => 'Updated Succesfully (' . $position . ")",
            "type" => "info"
        );
        print json_encode($value);
    }

    function reset_password() {
        $id = $this->input->post('password_id');
        $repassword = $this->input->post('repassword');
        $this->Module->reset_user_password($id, $repassword);

        $value = array(
            "message" => "success",
            "text" => 'Updated Succesfully (' . $id . ")",
            "type" => "info"
        );
        print json_encode($value);
    }
    function delete_user_r() {
        $id = $this->input->post('password_id');
        $repassword = $this->input->post('repassword');
        $this->Module->delete_user($id);

        $value = array(
            "message" => "success",
            "text" => 'Deleted Succesfully (' . $id . ")",
            "type" => "info"
        );
        print json_encode($value);
    }

    function logout_session(){

       $this->session->unset_userdata('user_session');
       session_destroy();
       unset($_SESSION['access_token']);
       $session_data=array(
           'sess_logged_in'=>0);
       $this->session->set_userdata($session_data);
        print '{ "message": "logout"  }';

    }
    function login() {
        $email_address = $this->input->post('email_address');
        $user_password = $this->input->post('user_password');
        $remember_me = $this->input->post('remember_me');



        $query = $this->Module->user_login($email_address, $user_password);
        if($query != 0){
           $caption = "Success";
           $this->load->library('session');
           $msg = "success";
           $sess = $this->session->set_userdata("user_session", $email_address);
           $session_retrieve = $this->session->userdata('user_session');
           if ($remember_me == 1) {
                $remember_me_session = $this->session->set_userdata('remember_me_session');
                $remember_me_user = $this->session->set_userdata("user_session_remember_me", $email_address);
            }else {
                $remember_me_session = $this->session->unset_userdata('remember_me_session');
                $remember_me_user = $this->session->unset_userdata('user_session_remember_me');
            }
        }else{
            $caption = "Invalid";
            $sess = "Invalid Session";
            $msg = "error";
            $session_retrieve = '';
        }


        $value = array(
            "message" => $msg,
            "text" => $session_retrieve,
            "type" => "info"
        );
        print json_encode($value);
    }

}
