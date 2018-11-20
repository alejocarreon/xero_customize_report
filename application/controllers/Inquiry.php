<?php

defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');
header('Content-Type: application/json');

class Inquiry extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('ImageResize');
        $this->load->database();
        $this->load->model('Modules');
        $this->load->model('Models');
        $this->load->library('session');
    }
    function new_summary_page(){
       $this->form_validation->set_rules('id', 'id', 'required');
       $this->form_validation->set_rules('content', 'content', 'required');
      // if ($this->form_validation->run() === TRUE) {
           $data = array(
                "client_id" => $this->input->post('id'),
                "html_content" => $this->input->post('content')
            );
           $validate = $this->Modules->new_summary_page($data);
           $value = array("message" => "success", "text" => $this->input->post('id'));
           print json_encode($value);
      // }
    }
    function index() {
        redirect(site_url());
    }
    function update_content_details() {
       $this->form_validation->set_rules('hiddenfield', 'hiddenfield', 'required');
       $this->form_validation->set_rules('hiddenfieldtemplate', 'hiddenfieldtemplate', 'required');
       if ($this->form_validation->run() === TRUE) {
           $id = $this->input->post('hiddenfield');
           $htmltxtarea = $this->input->post('htmltxtarea');
           $selectvalue = $this->input->post('selectvalue');
           $xeroreport = $this->input->post('xeroreport');
           $layout = $this->input->post('layout');
           $getdate = $this->input->post('getdate');
           $hiddenfieldtemplate = $this->input->post('hiddenfieldtemplate');

           if($selectvalue == 'xeroreports'){
              $content_value = $xeroreport;
                $validation = "success";
           }elseif($selectvalue == 'htmleditor'){
               $content_value = $htmltxtarea;
               if(strlen($content_value) == 0){
                    $validation = "failed";
               }else{
                      $validation = "success";
               }
           }

           $data = array(
               "layout_page_id" => $id,
               "content" => $content_value,
               "sequence" => "1",
               "type" => $selectvalue,
               "page_type" => $layout,
               "get_query" => $getdate,
               "page_template" => $hiddenfieldtemplate

           );
           if($validation == "success"){
             $this->Modules->addpage($data);
           }


           $value = array("message" => "success", "text" => $validation);
           print json_encode($value);
       }
   }
    function updatepagestatusactive(){
        $id = $this->input->post('get_id');
        $data = array(
            "status" => 'Active');
        $this->Modules->update_status_page($id, $data);
        $value = array("message" => "success", "text" => "success");
        print json_encode($value);
    }
    function session_images(){
        $id = $this->input->post('get_img');
      //   $this->session->set_userdata('logo',  $id);


        $imageData = base64_encode(file_get_contents($id));
        $finfo = new finfo();
        $fileinfo = $finfo->file($image, FILEINFO_MIME);
        $src = 'data: '.$fileinfo.';base64,'.$imageData;
        $src = str_replace(" ","",$src);

        $this->session->set_userdata('logo', $src);


      //  $imageData = base64_encode(file_get_contents($id));
        /*
        $finfo = new finfo();
        $fileinfo = $finfo->file($image, FILEINFO_MIME);
        $src = 'data: '.$fileinfo.';base64,'.$imageData;
        $src=str_replace(" ","",$src);
        */
      //  $this->session->set_userdata('logo', $this->input->post('get_id'));
        $value = array("message" => "success", "text" => $src);
        print json_encode($value);
    }
    function update_pdf_status(){
        $id = $this->input->post('get_id');
        $data = array(
            "status" => 'Final');
        $this->Modules->update_status_pdf($id, $data);
        $value = array("message" => "success", "text" => "success" );
        print json_encode($value);
    }
    function sortpage(){
        $id = $this->input->post('get_id');
        $value = $this->input->post('get_value');
        $data = array(
            "sort" => $value);
        $this->Modules->sort_page($id, $data);
        $value = array("message" => "success", "text" => "success");
        print json_encode($value);
    }
    function updatepagestatusdisable(){
        $id = $this->input->post('get_id');
        $data = array(
            "status" => 'Disabled');
        $this->Modules->update_status_page($id, $data);
        $value = array("message" => "success", "text" => "success");
        print json_encode($value);
    }
    function addlayout() {
        $this->form_validation->set_rules('tempalte_option', 'tempalte_option', 'required');
        $this->form_validation->set_rules('pagetitle', 'pagetitle', 'required');
        $this->form_validation->set_rules('pagelayout', 'pagelayout', 'required');
       if ($this->form_validation->run() === TRUE) {
         $validation_count = $this->input->post('tempalte_option');
        $pagelayout = $this->input->post('pagelayout');


        $html_header = "<div class='container-fluid'>";
        $html_body= "<div class='row'><div class='col-lg-12'><div class='content-body'> ['singleLayout'] </div></div></div>";
        $html_footer = "</div>";
        $siglelayout = $html_header. $html_body.$html_footer;

        if($pagelayout == "SingleLayout"){
              $htmllayout = $siglelayout;
        }
         $datatemplate = array(
             "type" => $this->input->post('pagelayout'),
             "page_title" => $this->input->post('pagetitle'),
              "template_id" => $this->input->post('tempalte_option'),
              "status" => "Active",
              "html" => $htmllayout
         );
          $layout = $this->input->post('pagelayout');
          //  $query = $this->Modules->add_layout($datatemplate);
          if($validation_count == "none" || $validation_count == ""){
              $value = array("message" => "notemplate", "text" =>"No template");
          }else{
              $query = $this->Modules->add_layout($datatemplate);
              $value = array("message" => $query, "text" => "Successfully Added!");
          }

            print json_encode($value);
        }
    }
    function template_list(){
      $query = $this->db->query('SELECT * FROM template_db');
      $count = $query->result();
      print json_encode($count);
    }
    function layout_list(){
      $template = $this->input->post('get_id');
      $query = $this->db->query('SELECT * FROM layout_pages_tbl where template_id="'.$template.'"');
      $count = $query->result();
      print json_encode($count);
    }


    function updatelisttemplate() {
      $this->form_validation->set_rules('editfield', 'editfield', 'required');
       if ($this->form_validation->run() === TRUE) {
           //$pc_id = $this->Modules->pc_info();
           $value = array("template_name" => $this->input->post('editfield'), "user" => "");
           $query = $this->Modules->update_template($this->input->post('idtemplatehfield'), $value);

           if($query == "exist"){
              $validation = array("message" => "exist", "status" => $this->input->post('idtemplatehfield'));
           }else{
              $validation = array("message" => "success", "status" => $this->input->post('idtemplatehfield'));
           }

          $status = $validation;
       }else{
           $status = array("message" => "failed", "status" => $this->input->post('idtemplatehfield'));
       }
         print json_encode($status);
    }
    function pagination_data() {

      //$this->form_validation->set_rules('valuepagination', 'valuepagination', 'required');
      // if ($this->form_validation->run() === TRUE) {
         $id = $this->input->post('insert_value') * 10;
         $add_increment = $id - 10;
         $query_text = "SELECT * FROM template_db where ID BETWEEN '$add_increment' and  '$id' ";
         $datatemplate = array(
             "template_name" => $query_text
         );
           $query = $this->db->query($query_text);
           $execute = $query->result();
           print json_encode($execute);
        //}
    }
    function addtemplate() {

        $this->form_validation->set_rules('template', 'template', 'required');
       if ($this->form_validation->run() === TRUE) {

         $datatemplate = array(
             "template_name" => $this->input->post('template')
         );
            $query = $this->Modules->add_templates($datatemplate);

            $value = array("message" => "success", "text" => $query);
            print json_encode($value);
        }
    }
    function getusersinfo() {
        $this->form_validation->set_rules('getusersinfo', 'getusersinfo', 'required');
        if ($this->form_validation->run() === TRUE) {
            $query = $this->Modules->user_info_list($this->input->post('getusersinfo'));
            $data = $query->result();
            print json_encode($data);
        }
    }

    function delete_profile() {
        $this->form_validation->set_rules('get_id', 'get_id', 'required');
        if ($this->form_validation->run() === TRUE) {
            $query = $this->Modules->delete_profile($this->input->post('get_id'));
            $value = array("message" => "success", "text" => "success");
            print json_encode($value);
        }
    }
     function delete_calendar() {
        $this->form_validation->set_rules('get_id', 'get_id', 'required');
        if ($this->form_validation->run() === TRUE) {
            $query = $this->Modules->delete_calendar($this->input->post('get_id'));
            $value = array("message" => "success", "text" => "success");
            print json_encode($value);
        }
    }
    function delete_template() {
       $this->form_validation->set_rules('get_id', 'get_id', 'required');
       if ($this->form_validation->run() === TRUE) {
           $query = $this->Modules->delete_template($this->input->post('get_id'));
           $value = array("message" => "success", "text" => "success");
           print json_encode($value);
       }
   }
   function delete_pdf() {
      $this->form_validation->set_rules('get_id', 'get_id', 'required');
      if ($this->form_validation->run() === TRUE) {
          $query = $this->Modules->delete_pdf($this->input->post('get_id'));
          $value = array("message" => "success", "text" => "success");
          print json_encode($value);
      }
  }
   function load_template() {
      $this->form_validation->set_rules('get_id', 'get_id', 'required');
      if ($this->form_validation->run() === TRUE) {
          $this->session->unset_userdata('template');
          $this->session->set_userdata('template', $this->input->post('get_id'));
          $value = array("message" => "success", "text" => "success");
          print json_encode($value);
      }
  }
   function getinformationpage() {
    $this->form_validation->set_rules('get_id', 'get_id', 'required');
      if ($this->form_validation->run() === TRUE) {
          $query = $this->Modules->get_page($this->input->post('get_id'));
          $data = $query->result();
          $html_header = "<div class='container-fluid'>";
          $html_body= "<div class='row'><div class='col-lg-12'><div class='content-body'></div></div></div>";
          $html_footer = "</div>";
          $siglelayout = $html_header. $html_body.$html_footer;

          foreach ($data as $key) {
                if($key->type == "SingleLayout"){
                    $htmlparts = $siglelayout;
                    $htmlinput = $key->html;
                    //  if (strpos($htmlinput, "['singleLayout']") !== false)
                          $select = "<input type='hidden' name='layout' value='".$key->type."'><select name='selectvalue' class='form-control selectvalue'><option value='' style='text-align:center'>Select</option><option value='xeroreports'>Xero Available Report</option><option value='htmleditor'>HTML contents</option></select>";
                          $text_area = "<div class='row'><div class='col-lg-12'>".$select."</div></div>";
                          $text_area .="<div class='row'><div class='col-lg-12'><div class='bind-content'></div></div></div>";
                          $text_area .="<div class='row'><div class='col-lg-12'><div class='date-field'></div></div></div>";
                          $input_html =  str_replace("['singleLayout']", $text_area, $htmlinput);
                //   }
                }

          }

            $valid_data = array("message" => "error",
            "html" =>  $input_html,
            "text" => "success",
            "type" => $key->type,
            "page_title" => $key->page_title,
            "status" => $key->status,
            "template_name" => $key->template_name


            );

          //  $value = array("message" => "error", "text" => $valid_data);
            print json_encode($valid_data);
      }
  }

    function tagging() {
        $this->form_validation->set_rules('get_id', 'get_id', 'required|numeric');
        $this->form_validation->set_rules('group_id', 'group_id', 'required|numeric');
        $this->form_validation->set_rules('type', 'type', 'required');
        if ($this->form_validation->run()) {
            if ($this->input->post('type') == 'add') {
                $data = array(
                    "user_id" => $this->input->post('get_id'),
                    "group_id" => $this->input->post('group_id'),
                );
                $this->Modules->add_tagged_group($data);
                $value = array("message" => "success", "text" => "Success add");
            } else if ($this->input->post('type') == 'remove') {
                $data = array(
                    "user_id" => $this->input->post('get_id'),
                    "group_id" => $this->input->post('group_id'),
                );
                $this->Modules->delete_tagged_group($data);
                $value = array("message" => "success", "text" => "Success remove");
            } else {
                $value = array("message" => "error", "text" => "error no tyle");
            }
        } else {
            $value = array("message" => "error", "text" => "error validation");
        }
        print json_encode($value);
    }

    function gettag() {

        $this->form_validation->set_rules('postid', 'postid', 'required');
        if ($this->form_validation->run() === TRUE) {
            $query = $this->Modules->user_tag($this->input->post('postid'));
            $data = $query->result();
            print json_encode($data);
        }
    }
    function setEvents() {

            $query = $this->Modules->events_json();
            $data = $query->result();
            print json_encode($data);

    }

    function getcalendarinfo() {

        $this->form_validation->set_rules('getcalendarid', 'getcalendarid', 'required');
        if ($this->form_validation->run() === TRUE) {
            $query = $this->Modules->calendar_info($this->input->post('getcalendarid'));
            //$query = $this->Modules->calendar_info('1');
            $data = $query->result();
            print json_encode($data);
        }
    }

    function eventbox() {
        $this->form_validation->set_rules('get_id', 'get_id', 'required');
        if ($this->form_validation->run() === TRUE) {
            $value = $this->input->post('get_id');
            $exploda_data = explode("-", $value);
            $year = $exploda_data[0];
            $month = $exploda_data[1];
            $day = $exploda_data[2];


            $get_event = $this->Modules->get_events($month, $year);
            $data = $get_event->result();
            print json_encode($data);
        }
    }

    function login() {

        $this->form_validation->set_rules('email_address', 'email_address', 'required|valid_email');
        $this->form_validation->set_rules('user_password', 'user_password', 'required');
        $password = md5(sha1($this->input->post('user_password')));

        if ($this->form_validation->run() === TRUE) {
            $data = array(
                "email" => $this->input->post('email_address'),
                "password" => sha1($this->input->post('user_password'))
            );
            $validate = $this->Modules->login_script($data);
            $count = $validate->num_rows();
            if ($count == 1) {
                $validate = $this->Modules->sessions($data);
                $data = $validate->result();
                $this->session->set_userdata('user_session', $this->input->post('email_address'));
                $this->session->set_userdata('email', $this->input->post('email_address'));
                $value = array(
                    "message" => "success",
                    "text" => "success",
                    "type" => $validate
                );
            } else {
                $value = array(
                    "message" => "error",
                    "text" => "Invalid email or password",
                    "type" => $validate
                );
            }
        }

          print json_encode($value);
    }

    function logout() {
      $this->session->unset_userdata('user_session');
       session_destroy();
       unset($_SESSION['access_token']);
       $session_data=array(
           'sess_logged_in'=>0);
       $this->session->set_userdata($session_data);
        $this->session->unset_userdata('user_session');
        $this->session->unset_userdata('user_position');
        $this->session->unset_userdata('key');
        $this->session->unset_userdata('secret');
        $value = array(
            "message" => "success",
            "text" => "logout",
        );
        print json_encode($value);
    }

    function get_id() {
        $row = $this->Modules->model_get_id();
        print json_encode($row->result());
    }

    function updateevent() {
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('organizer', 'organizer', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        //$this->form_validation->set_rules('category', 'category', 'required');
        // $this->form_validation->set_rules('location', 'location', 'required');
        $datevalue = $this->input->post("datevalue");
        $exp_value = explode("-", $datevalue);
        $year = $exp_value[0];
        $month = $exp_value[1];
        $day = $exp_value[2];


        if ($this->form_validation->run()) {
            $data = array(
                "title" => $this->input->post("title"),
                "description" => $this->input->post("description"),
                "organizer" => $this->input->post("organizer"),
                "category" => $this->input->post("category"),
                "day" => $day,
                "month" => $month,
                "year" => $year,
                "datestamp" => date('d/m/Y h:i:s'),
                "date" => strtotime($datevalue),
                "add_by" => $this->session->userdata('user_session'),
                "start_time" => $this->input->post("startat"),
                "end_time" => $this->input->post("endat"),
                "location" => $this->input->post("location"));
            $this->Modules->add_events($data);
            $value = array("message" => "success", "text" => "success", "type" => "update");
            print json_encode($value);
        }
    }

    function addevent() {
        $this->form_validation->set_rules('title', 'title', 'required');
        $this->form_validation->set_rules('organizer', 'organizer', 'required');
        $this->form_validation->set_rules('description', 'description', 'required');
        //$this->form_validation->set_rules('category', 'category', 'required');
        // $this->form_validation->set_rules('location', 'location', 'required');
        $datevalueedit = $this->input->post("datevalueedit");
        $datevalue = $this->input->post("datevalue");
        if ($this->form_validation->run()) {
            if (strlen($this->input->post("idcalendar")) != 0) {
                $exp_value = explode("-", $datevalueedit);
                $year = $exp_value[0];
                $month = $exp_value[1];
                $day = $exp_value[2];
                $data = array(
                    "title" => $this->input->post("title"),
                    "description" => $this->input->post("description"),
                    "organizer" => $this->input->post("organizer"),
                    "category" => $this->input->post("category"),
                    "day" => $day,
                    "month" => $month,
                    "year" => $year,
                    "datestamp" => date('d/m/Y h:i:s'),
                    "date" => strtotime($datevalue),
                    "add_by" => $this->session->userdata('user_session'),
                    "start_time" => $this->input->post("startat"),
                    "end_time" => $this->input->post("endat"),
                    "location" => $this->input->post("location"));
                $this->Modules->update_events($this->input->post("idcalendar"), $data);
                $value = array("message" => "success", "text" => "updated", "type" => "update");
            } else {
                $exp_value = explode("-", $datevalue);
                $year = $exp_value[0];
                $month = $exp_value[1];
                $day = $exp_value[2];
                $data = array(
                    "title" => $this->input->post("title"),
                    "description" => $this->input->post("description"),
                    "organizer" => $this->input->post("organizer"),
                    "category" => $this->input->post("category"),
                    "day" => $day,
                    "month" => $month,
                    "year" => $year,
                    "datestamp" => date('d/m/Y h:i:s'),
                    "date" => strtotime($datevalue),
                    "add_by" => $this->session->userdata('user_session'),
                    "start_time" => $this->input->post("startat"),
                    "end_time" => $this->input->post("endat"),
                    "location" => $this->input->post("location"));
                $this->Modules->add_events($data);
                $value = array("message" => "success", "text" => "added", "type" => "update");
            }
            print json_encode($value);
        }
    }
     function update_event() {
        $this->form_validation->set_rules('titleview', 'titleview', 'required');
        $this->form_validation->set_rules('dateid', 'dateid', 'required');
        //$this->form_validation->set_rules('category', 'category', 'required');
        // $this->form_validation->set_rules('location', 'location', 'required');
        $datevalueedit = $this->input->post("date_value");
        $datevalue = $this->input->post("dateid");
        if ($this->form_validation->run()) {
            if (strlen($this->input->post("dateid")) != 0) {

                $exp_value = explode("/", $datevalueedit);
                $year = $exp_value[2];
                $month = $exp_value[0];
                $day = $exp_value[1];

                $data = array(
                    "title" => $this->input->post("titleview"),
                    "description" => $this->input->post("descriptionfield"),
                    "organizer" => $this->input->post("organizeredit"),
                    "category" => $this->input->post("categoryedit"),
                    "day" => $day,
                    "month" => $month,
                    "year" => $year,
                    "datestamp" => date('d/m/Y h:i:s'),
                    "date" => strtotime($datevalueedit),
                    "add_by" => $this->session->userdata('user_session'),
                    "start_time" => $this->input->post("startatedit"),
                    "end_time" => $this->input->post("endatedit"),
                    "location" => $this->input->post("locationedit"));
                $this->Modules->update_events($datevalue, $data);

                $value = array("message" => "success", "text" => "updated" , "type" => "update");
            }
            }
            print json_encode($value);
       // }
    }
     function calendar_month() {



            $get_data = $this->Modules->get_event_today_manual( sprintf("%02d", $this->input->post("month_now")) , $this->input->post("year_now"));
            print json_encode($get_data);
       // print sprintf("%02d", $this->input->post("month_now"));
          //$value = array("message" => sprintf("%02d", $this->input->post("month_now")), "text" => $this->input->post("year_now"), "type" => "update");
       // print json_encode($value);
    }

    function updatedatacelendar() {
        //  $this->form_validation->set_rules('title', 'title', 'required');
        // $this->form_validation->set_rules('organizer', 'organizer', 'required');
        //$this->form_validation->set_rules('description', 'description', 'required');
        //$this->form_validation->set_rules('category', 'category', 'required');
        // $this->form_validation->set_rules('location', 'location', 'required');
        // $datevalue = $this->input->post("datevalue");
        //$exp_value = explode("-", $datevalue);
        //$year = $exp_value[0];
        // $month = $exp_value[1];
        // $day = $exp_value[2];
        //if ($this->form_validation->run()) {
        /*
          $data = array(
          "title" => $this->input->post("title"),
          "description" => $this->input->post("description"),
          "organizer" => $this->input->post("organizer"),
          "category" => $this->input->post("category"),
          "day" => $day,
          "month" => $month,
          "year" => $year,
          "datestamp" => date('d/m/Y h:i:s'),
          "date" => strtotime($datevalue),
          "add_by" => $this->session->userdata('user_session'),
          "start_time" =>$this->input->post("startat"),
          "end_time" => $this->input->post("endat"),
          "location" => $this->input->post("location"));
          $this->Modules->add_events($data);
         */
        $value = array("message" => "success", "text" => "success", "type" => "update");
        print json_encode($value);
        // }
    }

    function accountinfo() {
        $this->form_validation->set_rules('fname', 'fname', 'required');
        $this->form_validation->set_rules('lname', 'lname', 'required');
        $this->form_validation->set_rules('email', 'email', 'required|valid_email');
        if ($this->form_validation->run()) {
            $data = array(
                "first_name" => $this->input->post("fname"),
                "middle_name" => $this->input->post("mname"),
                "last_name" => $this->input->post("lname"),
                "email" => $this->input->post("email"),
                "permanent_address" => $this->input->post("address"),
                "contact" => $this->input->post("contact"),
                "date_of_birth" => strtotime($this->input->post("birthday"))
            );
            $this->Modules->model_update($this->session->userdata('user_session'), $data);
            $value = array("message" => "success", "text" => "Success", "type" => "register");
            print json_encode($value);
        }
    }
    function getsession(){
        print json_encode($_SESSION);
    }

    function passwordchange() {
        $this->form_validation->set_rules('cpassword', 'cpassword', 'required');
        $this->form_validation->set_rules('rpassword', 'rpassword', 'required');
        $this->form_validation->set_rules('npassword', 'npassword', 'required');
        if ($this->form_validation->run()) {
            $data = array(
                "ID" => $this->session->userdata('user_session'),
                "password" => md5(sha1($this->input->post("npassword")))
            );
            $validate = $this->Modules->password_validation($this->session->userdata('user_session'), md5(sha1($this->input->post("cpassword"))));
            $validate_num = $validate->num_rows();

            $np = $this->input->post("npassword");
            $rp = $this->input->post("rpassword");

            if ($validate_num != '1') {
                $value = array("message" => "currentpassword", "text" => $validate_num, "type" => "register");
                print json_encode($value);
            } elseif ($np != $rp) {
                $value = array("message" => "failed", "text" => $validate_num, "type" => "register");
                print json_encode($value);
            } elseif ($validate_num == '1') {
                $this->Modules->model_update($this->session->userdata('user_session'), $data);
                $value = array("message" => "success", "text" => $this->session->userdata('user_session'), "type" => "register");
                print json_encode($value);
            }
        }
    }

    function register() {
        $this->form_validation->set_rules('employee_id_no', 'employee_id_no', 'required');
        $this->form_validation->set_rules('first_name', 'first_name', 'required');
        $this->form_validation->set_rules('last_name', 'last_name', 'required');
        $this->form_validation->set_rules('civil_status', 'civil_status', 'required');
        $this->form_validation->set_rules('date_of_birth', 'date_of_birth', 'required');
        $this->form_validation->set_rules('contact', 'contact', 'required');
        $this->form_validation->set_rules('permanent_address', 'permanent_address', 'required');
        $this->form_validation->set_rules('email', 'email', 'required');
        $this->form_validation->set_rules('department', 'department', 'required');
        $this->form_validation->set_rules('employment_status', 'employment_status', 'required');
        $this->form_validation->set_rules('biometric_id', 'biometric_id', 'required');
        $this->form_validation->set_rules('hire_date', 'hire_date', 'required');
        $this->form_validation->set_rules('reports_to_employee_id_no', 'reports_to_employee_id_no', 'required');
        $this->form_validation->set_rules('tin_no', 'tin_no', 'required');
        $this->form_validation->set_rules('user_level', 'user_level', 'required');
        if ($this->form_validation->run()) {
            if (strlen($this->input->post("mainid") != 0) || $this->input->post("mainid") != "") {
                $data = array(
                    "employee_id_no" => $this->input->post("employee_id_no"),
                    "first_name" => $this->input->post("first_name"),
                    "middle_name" => $this->input->post("middle_name"),
                    "last_name" => $this->input->post("last_name"),
                    "gender" => $this->input->post("gender"),
                    "civil_status" => $this->input->post("civil_status"),
                    "date_of_birth" => strtotime($this->input->post("date_of_birth")),
                    "contact" => $this->input->post("contact"),
                    "permanent_address" => $this->input->post("permanent_address"),
                    "current_address" => $this->input->post("current_address"),
                    "email" => $this->input->post("email"),
                    "department" => $this->input->post("department"),
                    "client_name" => $this->input->post("client_name"),
                    "segment" => $this->input->post("segment"),
                    "department_id" => $this->input->post("department_id"),
                    "location" => $this->input->post("location"),
                    "site" => $this->input->post("site"),
                    "job_code" => $this->input->post("job_code"),
                    "job_title" => $this->input->post("job_title"),
                    "job_level_grade" => $this->input->post("job_level_grade"),
                    "payroll_type" => $this->input->post("payroll_type"),
                    "employee_type" => $this->input->post("employee_type"),
                    "employment_status" => $this->input->post("employment_status"),
                    "hr_status" => $this->input->post("hr_status"),
                    "hire_date" => strtotime($this->input->post("hire_date")),
                    "regularization_date" => strtotime($this->input->post("regularization_date")),
                    "separation_date" => strtotime($this->input->post("separation_date")),
                    "general_reason" => $this->input->post("general_reason"),
                    "specific_reason" => $this->input->post("specific_reason"),
                    "voluntary_involuntary" => $this->input->post("voluntary_involuntary"),
                    "biometric_id" => $this->input->post("biometric_id"),
                    "reports_to_employee_id_no" => $this->input->post("reports_to_employee_id_no"),
                    "second_level_supervisor" => $this->input->post("second_level_supervisor"),
                    "billability" => $this->input->post("billability"),
                    "employee_remarks" => $this->input->post("employee_remarks"),
                    "schedule_type" => $this->input->post("schedule_type"),
                    "payroll_pie_id" => $this->input->post("payroll_pie_id"),
                    "highest_education_attainment" => $this->input->post("highest_education_attainment"),
                    "college_degree" => $this->input->post("college_degree"),
                    "major" => $this->input->post("major"),
                    "institution" => $this->input->post("institution"),
                    "prior_work_experience" => $this->input->post("prior_work_experience"),
                    "previous_employer" => $this->input->post("previous_employer"),
                    "type_of_industry" => $this->input->post("type_of_industry"),
                    "prc_license_no" => $this->input->post("prc_license_no"),
                    "sss_no" => $this->input->post("sss_no"),
                    "tin_no" => $this->input->post("tin_no"),
                    "philhealth_no" => $this->input->post("philhealth_no"),
                    "pag_ibig_no" => $this->input->post("pag_ibig_no"),
                    "passport_no" => $this->input->post("passport_no"),
                    "tax_status" => $this->input->post("tax_status"),
                    "local_trunk_line" => $this->input->post("local_trunk_line"),
                    "local_trunk_line_pin" => $this->input->post("local_trunk_line_pin"),
                    "skype_id" => $this->input->post("skype_id"),
                    "emergency_contact_name" => $this->input->post("emergency_contact_name"),
                    "emergency_contact_no" => $this->input->post("emergency_contact_no"),
                    "emergency_contact_relationship" => $this->input->post("emergency_contact_relationship"),
                    "emergency_contact_address" => $this->input->post("emergency_contact_address"),
                    "bank_name" => $this->input->post("bank_name"),
                    "bank_account_no" => $this->input->post("bank_account_no"),
                    "basic_salary" => $this->input->post("basic_salary"),
                    "deminimis" => $this->input->post("deminimis"),
                    "transportation_allowance" => $this->input->post("transportation_allowance"),
                    "travel_allowance" => $this->input->post("travel_allowance"),
                    "other_allowance" => $this->input->post("other_allowance"),
                    "user_level" => $this->input->post("user_level")
                );
            } else {
                $data = array(
                    "employee_id_no" => $this->input->post("employee_id_no"),
                    "first_name" => $this->input->post("first_name"),
                    "middle_name" => $this->input->post("middle_name"),
                    "last_name" => $this->input->post("last_name"),
                    "gender" => $this->input->post("gender"),
                    "civil_status" => $this->input->post("civil_status"),
                    "date_of_birth" => strtotime($this->input->post("date_of_birth")),
                    "contact" => $this->input->post("contact"),
                    "permanent_address" => $this->input->post("permanent_address"),
                    "current_address" => $this->input->post("current_address"),
                    "email" => $this->input->post("email"),
                    "department" => $this->input->post("department"),
                    "client_name" => $this->input->post("client_name"),
                    "segment" => $this->input->post("segment"),
                    "department_id" => $this->input->post("department_id"),
                    "location" => $this->input->post("location"),
                    "site" => $this->input->post("site"),
                    "job_code" => $this->input->post("job_code"),
                    "job_title" => $this->input->post("job_title"),
                    "job_level_grade" => $this->input->post("job_level_grade"),
                    "payroll_type" => $this->input->post("payroll_type"),
                    "employee_type" => $this->input->post("employee_type"),
                    "employment_status" => $this->input->post("employment_status"),
                    "hr_status" => $this->input->post("hr_status"),
                    "hire_date" => strtotime($this->input->post("hire_date")),
                    "regularization_date" => strtotime($this->input->post("regularization_date")),
                    "separation_date" => strtotime($this->input->post("separation_date")),
                    "general_reason" => $this->input->post("general_reason"),
                    "specific_reason" => $this->input->post("specific_reason"),
                    "voluntary_involuntary" => $this->input->post("voluntary_involuntary"),
                    "biometric_id" => $this->input->post("biometric_id"),
                    "reports_to_employee_id_no" => $this->input->post("reports_to_employee_id_no"),
                    "second_level_supervisor" => $this->input->post("second_level_supervisor"),
                    "billability" => $this->input->post("billability"),
                    "employee_remarks" => $this->input->post("employee_remarks"),
                    "schedule_type" => $this->input->post("schedule_type"),
                    "payroll_pie_id" => $this->input->post("payroll_pie_id"),
                    "highest_education_attainment" => $this->input->post("highest_education_attainment"),
                    "college_degree" => $this->input->post("college_degree"),
                    "major" => $this->input->post("major"),
                    "institution" => $this->input->post("institution"),
                    "prior_work_experience" => $this->input->post("prior_work_experience"),
                    "previous_employer" => $this->input->post("previous_employer"),
                    "type_of_industry" => $this->input->post("type_of_industry"),
                    "prc_license_no" => $this->input->post("prc_license_no"),
                    "sss_no" => $this->input->post("sss_no"),
                    "tin_no" => $this->input->post("tin_no"),
                    "philhealth_no" => $this->input->post("philhealth_no"),
                    "pag_ibig_no" => $this->input->post("pag_ibig_no"),
                    "passport_no" => $this->input->post("passport_no"),
                    "tax_status" => $this->input->post("tax_status"),
                    "local_trunk_line" => $this->input->post("local_trunk_line"),
                    "local_trunk_line_pin" => $this->input->post("local_trunk_line_pin"),
                    "skype_id" => $this->input->post("skype_id"),
                    "emergency_contact_name" => $this->input->post("emergency_contact_name"),
                    "emergency_contact_no" => $this->input->post("emergency_contact_no"),
                    "emergency_contact_relationship" => $this->input->post("emergency_contact_relationship"),
                    "emergency_contact_address" => $this->input->post("emergency_contact_address"),
                    "bank_name" => $this->input->post("bank_name"),
                    "bank_account_no" => $this->input->post("bank_account_no"),
                    "basic_salary" => $this->input->post("basic_salary"),
                    "deminimis" => $this->input->post("deminimis"),
                    "transportation_allowance" => $this->input->post("transportation_allowance"),
                    "travel_allowance" => $this->input->post("travel_allowance"),
                    "other_allowance" => $this->input->post("other_allowance"),
                    "user_level" => $this->input->post("user_level"),
                    "password" => md5(sha1('toa2018'))
                );
            }
            if (strlen($this->input->post("mainid") != 0) || $this->input->post("mainid") != "") {
                $this->Modules->model_update($this->input->post("mainid"), $data);
                $value = array("message" => "success", "text" => "Success", "type" => "update");
            } else {
                $this->Modules->model_registration($data);
                $value = array("message" => "success", "text" => "Success", "type" => "register");
            }
        } else {
            $value = array("message" => "error", "text" => "Error");
        }
        print json_encode($value);
    }

}
