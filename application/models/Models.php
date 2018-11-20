<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Models extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        header('Access-Control-Allow-Origin: *');
    }

    function index() {
        
    }

    function style($array) {
        $style = '';
        foreach ($array as $value) {
            $style .= str_replace('', file_get_contents($value)) . "\n";
        }
        echo $style;
    }

    function scripts($array) {
        $js = '';
        foreach ($array as $value) {
            $js .= file_get_contents($value) . "\n";
        }
        echo $js;
    }

    function title() {
        if (($this->uri->segment(1))) {
            return ucfirst(str_replace('_', ' ', $this->uri->segment(1))) . ' | The Outsourced Accountant';
        } else {
            return 'The Outsourced Accountant';
        }
    }

    function from_date() {
        if (($this->uri->segment(6))) {
            return $this->uri->segment(6);
        } else {
            return date('m-d-Y');
        }
    }

    function time_range($unix_date, $now) {
        if (empty($unix_date)) {
            return "No date provided";
        }if (empty($now)) {
            return "No date provided";
        }
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60", "60", "24", "7", "4.35", "12", "10");

        if (empty($unix_date)) {
            return "Bad date";
        }
        if ($now > $unix_date) {
            $difference = $now - $unix_date;
            $tense = "ago";
        } else {
            $difference = $unix_date - $now;
            $tense = "from now";
        }
        for ($j = 0; $difference >= $lengths[$j] && $j < count($lengths) - 1; $j++) {
            $difference /= $lengths[$j];
        }
        $difference = round($difference);
        if ($difference != 1) {
            $periods[$j].= "s";
        }
        return "$difference $periods[$j] {$tense}";
    }

    function to_date() {
        if (($this->uri->segment(7))) {
            return $this->uri->segment(7);
        } else {
            return date('m-d-Y');
        }
    }

    function getVideoDetails($url) {
        $host = explode('.', str_replace('www.', '', strtolower(parse_url($url, PHP_URL_HOST))));
        $host = isset($host[0]) ? $host[0] : $host;
        switch ($host) {
            case 'vimeo':
                $video_id = substr(parse_url($url, PHP_URL_PATH), 1);
                $vid = "https://player.vimeo.com/video/{$video_id}/?color=fafafa&title=0&byline=0&portrait=0&badge=0";
                return "<iframe src='{$vid}' frameborder='0' webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
                break;
            case 'youtube':
                preg_match("/v=([^&#]*)/", parse_url($url, PHP_URL_QUERY), $video_id);
                if (isset($video_id[1])) {
                    $video_id = $video_id[1];
                    $vid = "https://www.youtube.com/embed/{$video_id}";
                    return "<iframe  src='{$vid}' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
                    break;
                } else {
                    return "<iframe  src='https://www.youtube.com/embed/toa' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>";
                }
        }
    }

    function max_row() {
        if (!($this->uri->segment(4))) {
            return '15';
        } else if (is_numeric($this->uri->segment(4))) {
            return ltrim(rtrim($this->uri->segment(4)));
        } else {
            return '15';
        }
    }

    function page() {
        if (!$this->input->get('page')) {
            return '1';
        } else if (is_numeric($this->input->get('page'))) {
            return ltrim(rtrim($this->input->get('page')));
        } else {
            return '1';
        }
    }

    function status() {
        if (!$this->input->get('status')) {
            return '1';
        } else if (is_numeric($this->input->get('status'))) {
            return ltrim(rtrim($this->input->get('status')));
        } else {
            return '1';
        }
    }

    function user_access($id) {
        if ($this->session->userdata('user_session') == $id || $this->session->userdata('user_position') == 4) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function module_posting() {
        if ($this->session->userdata('user_position') == 4 || $this->session->userdata('user_position') == 3) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function admin_only() {
        if ($this->session->userdata('user_position') == 4) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function limit_text($text, $limit) {
        $_space = array("\n", "&nbsp;");
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
            $text = str_replace('&nbsp;', ' ', $text);
        }
        return strip_tags(addslashes(str_replace($_space, ' ', $text)));
    }

    function special_chars($des) {
        $clear = strip_tags($des);
        $clear = html_entity_decode($clear);
        $clear = urldecode($clear);
        $clear = preg_replace('/[^A-Za-z0-9]/', ' ', $clear);
        $clear = preg_replace('/ +/', ' ', $clear);
        $clear = trim($clear);
        return $clear;
    }

    function quotes($string) {
        $chars = array("'", '"', '\\');
        return str_replace($chars, '', $string);
    }

    function start_date() {
        if ((!$this->input->get('start_date'))) {
            return date('m-d-Y');
        } else if (($this->input->get('start_date'))) {
            return ($this->input->get('start_date'));
        } else {
            return date('m-d-Y');
        }
    }

    function end_date() {
        if (!($this->input->get('end_date'))) {
            return date('m-d-Y');
        } else if (($this->input->get('end_date'))) {
            return ($this->input->get('end_date'));
        } else {
            return date('m-d-Y');
        }
    }

    function lctn() {
        if (!($this->input->get('location'))) {
            return '';
        } else if (($this->input->get('location'))) {
            return $this->input->get('location');
        } else {
            return '';
        }
    }

    function user_announcement() {
        if (!($this->uri->segment(3))) {
            return '';
        } else {
            if ($this->uri->segment(2) == 'user') {
                return $this->quotes(str_replace('%20', ' ', $this->uri->segment(3)));
            } else {
                return '';
            }
        }
    }

    function announcement() {
        if (!($this->uri->segment(3))) {
            return '';
        } else {
            if ($this->uri->segment(2) == 'id') {
                return $this->quotes(str_replace('%20', ' ', $this->uri->segment(3)));
            } else {
                return '';
            }
        }
    }

    function keyword() {
        if (!($this->uri->segment(3))) {
            return '';
        } else {
            if ($this->uri->segment(2) == 'announcement') {
                return $this->quotes(str_replace('%20', ' ', $this->uri->segment(3)));
            } else {
                return '';
            }
        }
    }

    function cc_search() {
        if (!($this->input->post('name'))) {
            return '';
        } else {
            return $this->quotes($this->input->post('name'));
        }
    }

    function save_image_sql($data) {
        $this->db->insert('upload_photos', $data);
    }

    function saved_images_show($folder) {
        return $this->db->query("SELECT * FROM `upload_photos`  WHERE photo_folder = '" . $folder . "' ");
    }

    function post_announcement($data) {
        $this->db->insert('announcement', $data);
    }

    function posted_announcement($page, $limit) {
        if ($this->module_posting()) {
            return $this->db->query("SELECT * FROM `announcement` ORDER BY PID DESC LIMIT {$page},{$limit}");
        } else {
            return $this->db->query("SELECT * FROM (SELECT a.*, b.gid FROM announcement as a LEFT JOIN(SELECT * FROM tagged_group) as b ON a.postid= b.postid) as MY_DATA LEFT JOIN (SELECT * FROM user_group) as group_list ON MY_DATA.gid = group_list.GID LEFT JOIN(SELECT * FROM tag_group) as tag On MY_DATA.GID = tag.group_id WHERE tag.user_id='" . $this->session->userdata('user_session') . "'  GROUP BY postid  ORDER BY PID DESC LIMIT {$page},{$limit}");
        }
    }

    function posted_announcement_id($id) {
        if ($this->module_posting()) {
            return $this->db->query("SELECT * FROM `announcement` WHERE postid='" . $id . "' ORDER BY PID DESC");
        } else {
            return $this->db->query("SELECT * FROM (SELECT a.*, b.gid FROM announcement as a LEFT JOIN(SELECT * FROM tagged_group) as b ON a.postid= b.postid) as MY_DATA LEFT JOIN (SELECT * FROM user_group) as group_list ON MY_DATA.gid = group_list.GID LEFT JOIN(SELECT * FROM tag_group) as tag On MY_DATA.GID = tag.group_id WHERE tag.user_id='" . $this->session->userdata('user_session') . "' and postid='" . $id . "' GROUP BY postid ORDER BY PID DESC");
        }
    }

    function posted_announcement_user($id, $page, $limit) {
        if ($this->module_posting()) {
            return $this->db->query("SELECT * FROM `announcement` WHERE userid='" . $id . "' ORDER BY PID DESC LIMIT {$page},{$limit}");
        } else {
            return $this->db->query("SELECT * FROM (SELECT a.*, b.gid FROM announcement as a LEFT JOIN(SELECT * FROM tagged_group) as b ON a.postid= b.postid) as MY_DATA LEFT JOIN (SELECT * FROM user_group) as group_list ON MY_DATA.gid = group_list.GID LEFT JOIN(SELECT * FROM tag_group) as tag On MY_DATA.GID = tag.group_id WHERE tag.user_id='" . $this->session->userdata('user_session') . "' and userid='" . $id . "' GROUP BY postid ORDER BY PID DESC LIMIT {$page},{$limit}");
        }
    }

    function search_posted_announcement($page, $limit, $keyword) {
        $srh = explode(" ", $keyword);
        $_query = '';
        $conditions = array();
        foreach ($srh as $field) {
            if ($field) {
                $conditions[] = "`post` LIKE '%" . $field . "%'";
                $conditions[] = "`first_name` LIKE '%" . $field . "%'";
            }
        }
        if ($this->module_posting()) {
            if (count($conditions) > 0) {
                $_query .= "WHERE " . implode(' || ', $conditions);
            }
            return $this->db->query("SELECT * FROM announcement as a LEFT JOIN(SELECT * FROM employee_info) as b ON a.userid = b.ID {$_query} ORDER BY PID DESC LIMIT {$page},{$limit}");
        } else {
            if (count($conditions) > 0) {
                $_query .= implode(' || ', $conditions);
                $_query = '(' . $_query . ') and ';
            }
            return $this->db->query("SELECT * FROM (SELECT a.*, b.gid FROM announcement as a LEFT JOIN(SELECT * FROM tagged_group) as b ON a.postid= b.postid) as MY_DATA LEFT JOIN (SELECT * FROM user_group) as group_list ON MY_DATA.gid = group_list.GID LEFT JOIN(SELECT * FROM tag_group) as tag On MY_DATA.GID = tag.group_id  LEFT JOIN(SELECT * FROM employee_info) as emp On MY_DATA.userid= emp.ID WHERE {$_query} tag.user_id='" . $this->session->userdata('user_session') . "'  GROUP BY postid  ORDER BY PID DESC LIMIT {$page},{$limit}");
        }
    }

    function posted_images($folder) {
        return $this->db->query("SELECT * FROM `upload_photos` WHERE photo_folder = '" . $folder . "' ORDER BY PID ASC");
    }

    function delete_announcement_id($id) {
        $this->db->where('postid', $id);
        $this->db->delete('announcement');
        $this->db->where('photo_folder', $id);
        $this->db->delete('upload_photos');
        $this->db->where('post_id', $id);
        $this->db->delete('videos');
        $folder = './uploads/' . $id;
        if (is_dir($folder)) {
            $files = glob($folder . '/*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
            rmdir($folder);
        }
    }

    function update_videos($id, $data) {
        $this->db->where('postid', $id);
        return $this->db->update('announcement', $data);
    }

    function posted_videos_id($id) {
        return $this->db->query("SELECT * FROM `videos` WHERE post_id = '{$id}' ");
    }

    function add_videos($data) {
        return $this->db->insert('videos', $data);
    }

    function delete_videos($data) {
        $this->db->where('VID', $data);
        return $this->db->delete('videos');
    }

    function delete_photo($data) {
        $this->db->where('PID', $data);
        return $this->db->delete('upload_photos');
    }

    function employee() {
        return $this->db->query("SELECT * FROM  `employee_info`");
    }

    function employee_info($id) {
        return $this->db->query("SELECT * FROM `employee_info` WHERE ID = '{$id}' ");
    }

    function delete_group($gid) {
        $this->db->where('GID', $gid);
        return $this->db->delete('user_group');
    }

    function update_group($data, $gid) {
        $this->db->where('GID', $gid);
        return $this->db->update('user_group', $data);
    }

    function add_group($data) {
        return $this->db->insert('user_group', $data);
    }

    function tag_group($key) {
        return $this->db->query("SELECT * FROM `user_group` WHERE `group_name` LIKE '%{$key}%'");
    }

    function tag_group_list() {
        return $this->db->query("SELECT * FROM `user_group` ORDER BY GID DESC");
    }

    function tag_group_list_limit() {
        return $this->db->query("SELECT * FROM `user_group` ORDER BY GID DESC LIMIT 0,1");
    }

    function tagged_group($id) {
        return $this->db->query("SELECT * FROM tagged_group as a LEFT JOIN(SELECT * FROM user_group) as b ON a.gid = b.GID WHERE postid = '{$id}'");
    }

    function add_tagged_group($data) {
        return $this->db->insert('tagged_group', $data);
    }

    function delete_tagged_group($data) {
        $this->db->where($data);
        return $this->db->delete('tagged_group');
    }

    function recent_announcement() {
        return $this->db->query("SELECT * FROM announcement as a LEFT JOIN(SELECT * FROM tagged_group)as b ON a.postid = b.postid WHERE LENGTH(TID) !=0");
    }

    function check_like($postid, $data) {
        return $this->db->query("SELECT * FROM like_post as a  LEFT JOIN(SELECT * FROM `employee_info`)  as b ON a.uid = b.ID WHERE  {$postid}=1 and  postid='{$data}' ");
    }

    function me_like($postid, $data) {
        return $this->db->query("SELECT * FROM like_post as a  LEFT JOIN(SELECT * FROM `employee_info`)  as b ON a.uid = b.ID WHERE (uid={$this->session->userdata('user_session')} and  {$postid}=1) and  postid='{$data}' ");
    }

    function delete_like($data) {
        return $this->db->query("DELETE FROM like_post WHERE uid ={$this->session->userdata('user_session')} and postid='{$data}' ");
    }

    function insert_like($data) {
        return $this->db->insert("like_post", $data);
    }

    function like_conversion($result) {
        $name = '';
        foreach ($result as $value) {
            $name .='<div>' . $value->first_name . ' ' . $value->last_name . '</div>';
        }
        return $name;
    }

}
