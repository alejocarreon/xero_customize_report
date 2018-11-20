<?php

//// EMERSON
defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    function index() {
        
    }

    function users() {
        return $this->db->query('SELECT * FROM user_info ORDER BY ID DESC');
    }

    function keywords() {
        if (isset($_GET['search'])) {
            return $this->quotes($_GET['search']);
        } else {
            return '';
        }
    }

    function user_info() {
        $srh = explode(" ", $this->keywords());
        $sql = array();
        foreach ($srh as $word) {
            $sql[] = "'%" . $word . "%' || fname LIKE '%" . $word . "%' || lastname LIKE '%" . $word . "%' || email LIKE";
        }
        $string = implode(' ', $sql);
        $string = substr($string, 0, -14);
        $setLimit = 10;
        $pageLimit = ($this->page() * $setLimit) - ($setLimit);
        return $this->db->query("SELECT * FROM `user_info` WHERE email LIKE $string ORDER BY ID DESC LIMIT $pageLimit , $setLimit");
    }
    function remember() {
            return $this->session->userdata('remember_me_session');
       
    }
     function remember_user() {
            return $this->session->userdata('user_session_remember_me');
       
    }
    function page() {
        if (isset($_GET['page']) and $_GET['page'] == 0) {
            header('location:index');
        } else if (isset($_GET['page']) and is_numeric($_GET['page'])) {
            return $_GET['page'];
        } else {
            return '1';
        }
    }

    function user_pagination() {
        $page = $this->page();
        $per_page = 10;
        $page_url = "settings?";
        $srh = explode(" ", $this->keywords());
        $sql = array();
        foreach ($srh as $word) {
            $sql[] = "'%" . $word . "%' || fname LIKE '%" . $word . "%' || lastname LIKE '%" . $word . "%' || email LIKE";
        }
        $string = implode(' ', $sql);
        $string = substr($string, 0, -14);
        $query = $this->db->query("SELECT * FROM `user_info` WHERE email LIKE $string");
        $total = $query->num_rows();
        $adjacents = "2";
        $page = ($page == 0 ? 1 : $page);
        $start = ($page - 1) * $per_page;
        $prev = $page - 1;
        $next = $page + 1;
        $setLastpage = ceil($total / $per_page);
        $lpm1 = $setLastpage - 1;
        $setPaginate = "";
        if ($setLastpage > 1) {
            $setPaginate .= "<ul class='pagination pagination-sm'>";
            $setPaginate .= "<li class='disabled'><a>Page $page of $setLastpage</a></li>";
            if ($setLastpage < 7 + ($adjacents * 2)) {
                for ($counter = 1; $counter <= $setLastpage; $counter++) {
                    if ($counter == $page)
                        $setPaginate.= "<li class='active'><a>$counter</a></li>";
                    else
                        $setPaginate.= "<li><a href='{$page_url}page=$counter&search=" . $this->keywords() . "'>$counter</a></li>";
                }
            }
            elseif ($setLastpage > 5 + ($adjacents * 2)) {
                if ($page < 1 + ($adjacents * 2)) {
                    for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li class='active btn-default'><a>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter&search=" . $this->keywords() . "'>$counter</a></li>";
                    }
                    $setPaginate.= "<li class='dot'><a>...</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1&search=" . $this->keywords() . "'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage&search=" . $this->keywords() . "'>$setLastpage</a></li>";
                }
                elseif ($setLastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2)) {
                    $setPaginate.= "<li><a href='{$page_url}page=1&search=" . $this->keywords() . "'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2&search=" . $this->keywords() . "'>2</a></li>";
                    $setPaginate.= "<li class='dot'><a>...</a></li>";
                    for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li class='active'><a>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter&search=" . $this->keywords() . "'>$counter</a></li>";
                    }
                    $setPaginate.= "<li class='dot'><a>..</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$lpm1&search=" . $this->keywords() . "'>$lpm1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=$setLastpage&search=" . $this->keywords() . "'>$setLastpage</a></li>";
                }
                else {
                    $setPaginate.= "<li><a href='{$page_url}page=1&search=" . $this->keywords() . "'>1</a></li>";
                    $setPaginate.= "<li><a href='{$page_url}page=2&search=" . $this->keywords() . "'>2</a></li>";
                    $setPaginate.= "<li class='dot'><a>..</a></li>";
                    for ($counter = $setLastpage - (2 + ($adjacents * 2)); $counter <= $setLastpage; $counter++) {
                        if ($counter == $page)
                            $setPaginate.= "<li class='active'><a>$counter</a></li>";
                        else
                            $setPaginate.= "<li><a href='{$page_url}page=$counter&search=" . $this->keywords() . "'>$counter</a></li>";
                    }
                }
            }

            if ($page < $counter - 1) {
                $setPaginate.= "<li><a href='{$page_url}page=$next&search=" . $this->keywords() . "'>Next</a></li>";
                $setPaginate.= "<li><a href='{$page_url}page=$setLastpage&search=" . $this->keywords() . "'>Last</a></li>";
            } else {
                $setPaginate.= "<li class='disabled'><a class='current_page'>Next</a></li>";
                $setPaginate.= "<li class='disabled'><a class='current_page'>Last</a></li>";
            }

            $setPaginate.= "</ul>\n";
        }
        return $setPaginate;
    }

    function user_by_id($id) {
        return $this->db->query("SELECT * FROM user_info WHERE ID = '" . $id . "'");
    }

    function userid() {
        if (isset($_SESSION['userid'])) {
            return $_SESSION['userid'];
        } else {
            header('location:index');
        }
    }
    function quotes($string) {
        $chars = array("'", '"', '\\');
        return str_replace($chars, '', $string);
    }
     function user_login($email, $password) {
        $sql = "SELECT * FROM user_info WHERE email ='" . $email . "' and password='" . sha1($password) . "' ";
        $execute = $this->db->query($sql);
        $count = $execute->num_rows();
        $_SESSION['user_session'] = $email;
        return $count;
       
    }
    function session_username($email) {
        $sql =' SELECT * FROM user_info WHERE email="' . $email . '"';
        $query = $this->db->query($sql);
         return  $query;
    }
    function userinfo_details() {
        $srh = explode(" ", $this->keywords());
        $sql = array();
        foreach ($srh as $word) {
            $sql[] = "'%" . $word . "%' || fname LIKE '%" . $word . "%' || lastname LIKE '%" . $word . "%' || email LIKE";
        }
        $string = implode(' ', $sql);
        $string = substr($string, 0, -14);
        $setLimit = 10;
        $pageLimit = ($this->page() * $setLimit) - ($setLimit);
        return $this->db->query("SELECT * FROM `user_info` WHERE email LIKE $string ORDER BY ID DESC LIMIT $pageLimit , $setLimit");
    }
    function userinfo_details_not_admin($id) {
        $srh = explode(" ", $this->keywords());
        $sql = array();
        foreach ($srh as $word) {
            $sql[] = "'%" . $word . "%' || fname LIKE '%" . $word . "%' || lastname LIKE '%" . $word . "%' || email LIKE";
        }
        $string = implode(' ', $sql);
        $string = substr($string, 0, -14);
        $setLimit = 10;
        $pageLimit = ($this->page() * $setLimit) - ($setLimit);
        return $this->db->query("SELECT * FROM `user_info` WHERE email='".$id."' ORDER BY ID DESC LIMIT $pageLimit , $setLimit");
    }
    
    

    function add_user_info($data) {
        
        $query = $this->db->query('SELECT * FROM user_info WHERE email="' . $data['email'] . '"');
        $count = $query->num_rows();
        if ($count === 0) {
            $this->db->insert('user_info', $data);
            $validation = 'success';
        } else {
            $validation = 'exist';
        }
        return $validation;
    }

    function reset_user_password($id, $password) {
        $data = array(
            'password' => sha1($password)
        );
        $this->db->where('ID', $id);
        $this->db->update('user_info', $data);
    }
    
    function delete_user($id) {
        $this->db->where('ID', $id);
        $this->db->delete('user_info');
    }
    function info_type($id){
        $query_sql = "SELECT * FROM `user_info` WHERE email='".$id."'";
        $execute =  $this->db->query($query_sql);
        foreach($execute->result() as $row){
            $type = $row->position;
        }
        return  $type;
    }

   

}
