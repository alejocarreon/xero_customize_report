<?php

//// EMERSON
defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function index() {

    }
    function verify_user($session_value){
         $query = $this->db->query('SELECT * FROM user_info WHERE email="'.$session_value.'" ');
         return $query->num_rows() ;
    }
    function check_files($category,$file_name){
        return $this->db->query('SELECT * FROM add_file WHERE category="'.$category.'" and file_name ="'.$file_name.'" ');
    }
    function delete_files($file_name,$file_id){
        return $this->db->query('DELETE FROM add_file WHERE file_name ="'.$file_name.'" and ID = '.$file_id);
    }
    function duplicate_file($folder_real,$file_name){
        return $this->db->query('SELECT * FROM add_file WHERE category = "' . $folder_real . '" and file_name ="'.$file_name.'" ');
    }
    function per_folder($folder_real) {
        return $this->db->query('SELECT * FROM add_file WHERE category = "' . $folder_real . '" ORDER BY `add_file`.`ID` DESC ');
    }
    function delete_real_folder($numbers) {
       $this->db->query('DELETE FROM add_file WHERE category = "' . $numbers . '" ');
       $this->db->query('DELETE FROM folders WHERE folder_real = "' . $numbers . '" ');
    }
    function real_folder($numbers) {
        return $this->db->query('SELECT * FROM folders WHERE folder_real = "' . $numbers . '" ');
    }
    function duplicate_folder($duplicate) {
        return $this->db->query('SELECT * FROM folders WHERE folder_name = "' . $duplicate . '" ');
    }

    function folders() {
        return $this->db->query('SELECT * FROM folders as A LEFT JOIN(SELECT * FROM user_info) as b on A.created_by = b.email ORDER BY A.ID DESC');
    }
    function folders_not_admin($value) {
        return $this->db->query('SELECT * FROM folders as A LEFT JOIN(SELECT * FROM user_info) as b on A.created_by = b.email  where A.created_by="'.$value.'" ORDER BY A.ID');
    }

    function create_folder() {
        $query = $this->duplicate_folder($this->input->post('create_folder'));
        if ($query->num_rows() > 0) {
            return 0;
        } else {
            $real_name = strtotime("NOW") . rand(10, 99);
            mkdir('./uploads/' . $real_name);
            //$this->db->insert('access', $data_access);
            $data = array(
                'folder_name' => $this->input->post('create_folder'),
                'folder_real' => $real_name,
                'folder_created' => strtotime("NOW"),
                'folder_update' => strtotime("NOW"),
                'created_by' => $this->session->userdata('user_session')
            );

            return $this->db->insert('folders', $data);
        }
    }

    function add_file($id_category, $category, $file_name) {
        $data = array(
            'id_category' => $id_category,
            'category' => $category,
            'file_name' => $file_name
        );
        $updt = array('folder_update' => strtotime("NOW"));
        $this->db->where('ID', $id_category);
        $this->db->update('folders', $updt);
        return $this->db->insert('add_file', $data);
    }

    function rename_folder() {
        $query = $this->duplicate_folder($this->input->post('fname'));
        if ($query->num_rows() > 0) {
            return 0;
        } else {
            $data = array(
                'folder_name' => $this->input->post('fname'),
                'folder_update' => strtotime("NOW")
            );
            $this->db->where('ID', $this->input->post('fid'));
            return $this->db->update('folders', $data);
        }
    }

}
