<?php
header('Content-Type: application/json');
defined('BASEPATH') OR exit('No direct script access allowed');



class Request extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Models');
    }

    function index() {
        
    }
    
    function get_num_items(){
        $value = array('n_rows'=>$this->Models->per_folder($this->input->post('get_num_items'))->num_rows());
        print json_encode($value);
    }
    function delete_folder() {
        $folder = $this->input->post('folder_category');
        if (is_numeric($folder)) {
            $src = 'uploads/' . $folder;
             if (is_dir($src)) {
                $dir = opendir($src);
                while (false !== ( $file = readdir($dir))) {
                    if (( $file != '.' ) && ( $file != '..' )) {
                        $full = $src . '/' . $file;
                        unlink($full);
                    }
                }
                closedir($dir);
                rmdir($src);
            }
            $this->Models->delete_real_folder($folder);
            $value = array(
                "message" => "success",
                "text" => "Invalid Input ",
                "type" => "info"
            );
        }else{
            $value = array(
                "message" => "error",
                "text" => "Error",
                "type" => "danger"
            ); 
        }
        print json_encode($value);
    }

    function zip() {
        if (is_numeric($this->uri->segment(3))) {
            $query = $this->Models->real_folder($this->uri->segment(3));
            if ($query->num_rows() > 0) {
                $data = $query->result();
                $dir = './uploads/' . $this->uri->segment(3);
                $zip_file = $this->uri->segment(3) . '.zip';
                $rootPath = realpath($dir);
                $zip = new ZipArchive();
                $zip->open($zip_file, ZipArchive::CREATE | ZipArchive::OVERWRITE);
                $files = new RecursiveIteratorIterator(
                        new RecursiveDirectoryIterator($rootPath), RecursiveIteratorIterator::LEAVES_ONLY
                );
                foreach ($files as $name => $file) {
                    if (!$file->isDir()) {
                        $filePath = $file->getRealPath();
                        $relativePath = substr($filePath, strlen($rootPath) + 1);
                        $zip->addFile($filePath, $relativePath);
                    }
                }
                $zip->close();
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename='" . $data[0]->folder_name . ".zip' ");
                readfile($zip_file);
                unlink($zip_file);
            }
        }
    }

    function download() {
        if (is_numeric($this->uri->segment(3))) {
            $query = $this->Models->check_files($this->uri->segment(3), $this->uri->segment(4));
            if ($query->num_rows() > 0) {
                $download = site_url('uploads/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                header('Content-Type: application/octet-stream');
                header("Content-Transfer-Encoding: Binary");
                header("Content-disposition: attachment; filename='" . $this->uri->segment(4) . "' ");
                readfile($download);
            }
        }
    }

    function login() {
        $value = array(
            "message" => "success",
            "text" => "Invalid Input ",
            "type" => "info"
        );
        print json_encode($value);
    }

    function update_folder_name() {
        if ($this->Models->rename_folder()) {
            $value = array(
                "message" => "success",
                "text" => "Folder has been renamed!",
                "type" => "info"
            );
        } else {
            $value = array(
                "message" => "error",
                "text" => "Folder name must contain only letters, numbers, dashes or your folder name is already used.",
                "type" => "danger"
            );
        }
        print json_encode($value);
    }

    function create_new() {
        if ($this->Models->create_folder()) {
            $value = array(
                "message" => "success",
                "text" => "Folder has been created!",
                "type" => "info"
            );
        } else {
            $value = array(
                "message" => "error",
                "text" => "Folder not created!",
                "type" => "danger"
            );
        }
        print json_encode($value);
    }
    function get_per_folder(){
        $query = $this->Models->per_folder($this->input->post('folder_category'));
        print json_encode($query->result());
    }
    
    function get_folders() {
        $query = $this->Models->folders();
        print json_encode($query->result());
    }
    function delete_file() {
        $data_id = $this->input->post('data_id');
        $data_file = $this->input->post('data_file');
        $data_folder = $this->input->post('data_folder');
        if (is_numeric($data_id) and is_numeric($data_folder)) {
            $this->Models->delete_files($data_file, $data_id);
            unlink('./uploads/' . $data_folder . '/' . $data_file);
            $value = array(
                "message" => "success",
                "text" => "File deleted",
                "type" => "info"
            );
        } else {
            $value = array(
                "message" => "error",
                "text" => "Error deleting file",
                "type" => "danger"
            );
        }
        print json_encode($value);
    }

    function file_upload() {
        $id_category = $this->input->post('id_category');
        $category = $this->input->post('category');
        if (is_numeric($id_category) and is_numeric($category)) {
            if (isset($_FILES['file'])) {
                $file_name = str_replace(' ','_',$_FILES['file']['name']);
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                if ($ext !== 'php') {
                    $query = $this->Models->duplicate_file($category,$file_name);
                    if ($query->num_rows() > 0){
                        $file_name = 'Copy_' . strtotime('now') . '_' . $file_name;
                    }
                    move_uploaded_file($_FILES['file']['tmp_name'], './uploads/' . $category . '/' . $file_name);
                    $this->Models->add_file($id_category, $category, $file_name);
                    $value = array(
                        "message" => "success",
                        "text" => $category,
                        "type" => "info",
                        "folder" => $category
                    );
                }else{
                    $value = array(
                        "message" => "error",
                        "text" => "Invalid file",
                        "type" => "danger"
                    );
                }
            }
        } else {
            $value = array(
                "message" => "error",
                "text" => 'Error uploading file',
                "type" => "warning"
            );
        }
        print json_encode($value);
    }

}
