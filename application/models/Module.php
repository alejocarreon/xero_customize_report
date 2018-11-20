<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Modules extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
        header('Access-Control-Allow-Origin: *');
    }

    function index() {

    }
    function find_report($id, $query) {
    //  $query = "&date=2018-09-31";

      //explode($query)
      $query_value = "&date=".$query;
      $key = $this->session->userdata('key');
      $secret = $this->session->userdata('secret');
      $endpoint = "?key=".$key."&secret=".$secret.$query_value;
      if($id == 'TrialBalance'){
        $url = site_url('TrialBalance/connect'.$endpoint);
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($result, true);

        $ProviderName = $obj["ProviderName"];
        $ReportDate = $obj["Reports"]["Report"]["ReportDate"];
        $Row        = $obj["Reports"]["Report"]["Rows"]["Row"];
         ob_start();
         ?>
         <table>
            <tr>
              <td align="center"><h1>Trial Balance</h2></td>
              </tr>
         </table>
         <table class="table table-responsive">
        <?php
          foreach ($Row as $key => $value){
            if ($value['RowType'] == "Header") {
                $cellheader = $value['Cells']['Cell'];
        ?>
        <tr class="<?php
                echo $value['RowType'];
        ?>">
        <td style="border-bottom:1px solid black;" ><font size="9">Account Type</font></td>
        <?php
                foreach ($cellheader as $key => $cellexpand) {
        ?>
        <td style="border-bottom:1px solid black;"><?php
                    echo $cellexpand['Value'];
        ?></td>
        <?php
                }
        ?>

        </tr>
        <?php
            }elseif (isset($value['Title'])) {
                $getRow = $value['Rows']['Row'];
                foreach ($getRow as $key => $cellvalue) {
                    if ($cellvalue['RowType'] == "Row") {
                        $getCells = $cellvalue['Cells']['Cell'];
                        echo "<tr>";
                        echo "<td>" . $value['Title'] . "</td>";
                        foreach ($getCells as $key => $cellvaluesmany) {
                            if (isset($cellvaluesmany['Value'])) {
                                echo "<td><font size='1'>" . $cellvaluesmany['Value'] . "</font></td>";
                            } else {
                                echo "<td>-</td>";
                            }
                        }

                        echo "</tr>";
                    }

                }
            }else {
        ?>
        <tr>
        <td>&nbsp;</td>
        <?php
                $celltotal = $value['Rows']['Row']['Cells']['Cell'];
                foreach ($celltotal as $key => $cellprint) {
                    echo "<td>" . $cellprint['Value'] . "</td>";
                }

        ?>


        </tr>
        <?php
            }
          }

        ?>
        </table>
        <?php
        $html = ob_get_clean();
      }elseif($id == 'ProfitAndLost'){

        $query_value = "&date=".$query;
        $endpoint = "?key=".$key."&secret=".$secret.$query_value;
        $url = site_url('ProfitAndLost/connect'.$endpoint);
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($result, true);

        $ReportName = $obj["Reports"]["Report"]["ReportName"];
        $ReportDate = $obj["Reports"]["Report"]["ReportDate"];
        $Row        = $obj["Reports"]["Report"]["Rows"]["Row"];

      // ob_start();

       ob_start();
      ?>
      <table>
         <tr>
           <td align="center"><h1>Profit and Lost</h2></td>
           </tr>
      </table>
      <table width="100%" cellSpacing="0" cellpadding="0">
      <?php
      foreach ($Row as $key => $value){
        if ($value['RowType'] == "Header") {
            $cellheader = $value['Cells']['Cell'];
       ?>
        <tr>
            <td>Section</td>
            <td>Account</td>
            <td>Amount</td>
            <td>YTD</td>
          <?php
                          foreach ($cellheader as $key => $cellexpands) {
          ?>
          <?php
                  if(isset($cellexpands['Value'])){
          ?>

          <?php
                  }
          ?>
          <?php
                         }
          ?>
        </tr>
        <?php
      }elseif (isset($value['Rows'])) {

        $getRow = $value['Rows']['Row'];

        foreach ($getRow as $key => $cellvalue) {
            if(isset($cellvalue['RowType'])){
            if ($cellvalue['RowType'] == "Row") {
                $getCells = $cellvalue['Cells']['Cell'];
                echo "<tr>";
                echo "<td>" . $value['Title'] . "</td>";
                foreach ($getCells as $key => $cellvaluesmany) {
                    if (isset($cellvaluesmany['Value'])) {
                        echo "<td>" . $cellvaluesmany['Value'] . "</td>";
                    } else {
                        echo "<td>-</td>";
                    }
                }

                echo "</tr>";
            }
          }

        }

      }
      }
       ?>
      </table>

      <?php
       $html = ob_get_clean();
      }elseif($id == 'BudgetSummary'){
        $query_value = "&date=".$query;
        $endpoint = "?key=".$key."&secret=".$secret.$query_value;

        $url = site_url('BudgetSummary/connect'.$endpoint);
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($result, true);

        $ReportName = $obj["Reports"]["Report"]["ReportName"];
        $ReportDate = $obj["Reports"]["Report"]["ReportDate"];
        $Row        = $obj["Reports"]["Report"]["Rows"]["Row"];

         ob_start();
         ?>
         <table>
            <tr>
              <td align="center"><h1>Budget Summary</h2></td>
              </tr>
         </table>
         <br>
         <table width="100%" cellSpacing="0" cellpadding="0">
         <?php
         foreach ($Row as $key => $value){
           if ($value['RowType'] == "Header") {
               $cellheader = $value['Cells']['Cell'];
          ?>
           <tr>

             <?php
                             foreach ($cellheader as $key => $cellexpands) {
             ?>
             <?php
                     if(isset($cellexpands['Value'])){
             ?>
                     <td><?php echo $cellexpands['Value']; ?></td>
             <?php
                     }
             ?>
             <?php
                            }
             ?>
           </tr>
           <?php
         }elseif ($value['RowType'] == "Section") {

           $getRow = $value['Rows']['Row'];
             foreach($getRow  as $key=> $rows){
               $cellcount = $getRow['Cells']['Cell'];
               ?>

               <tr>
                 <?php
                 foreach($cellcount  as $key=> $cellprint){
                   echo "<td>".$cellprint['Value']."</td>";

                 ?>

                 <?php
                 }
                  ?>
               </tr>
               <?php
             }


         }
         }
          ?>
         </table>
         <?php
         $html = ob_get_clean();
//  foreach ($Row as $key => $value){
      }elseif($id == 'BalanceSheet'){
        /*
        $query_value = "&date=".$query;
        $key = $this->session->userdata('key');
        $secret = $this->session->userdata('secret');
        $endpoint = "?key=".$key."&secret=".$secret.$query_value;
        */
        $query_value = "&date=".$query;
        $endpoint = "?key=".$key."&secret=".$secret.$query_value;
        $url = site_url('AR/connect'.$endpoint);
        $ch  = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        $result = curl_exec($ch);
        curl_close($ch);
        $obj = json_decode($result, true);

        $ReportName = $obj["Reports"]["Report"]["ReportName"];
        $ReportDate = $obj["Reports"]["Report"]["ReportDate"];
        $Row        = $obj["Reports"]["Report"]["Rows"]["Row"];


//  foreach ($Row as $key => $value){
 ob_start();
?>
<table>
   <tr>
     <td align="center"><h1>Balance Sheet</h2></td>
     </tr>
</table>
<br>
<br>
<table width="100%" cellSpacing="0" cellpadding="0">
<?php

foreach ($Row as $key => $value){
  if(isset($value['RowType'])){
  if ($value['RowType'] == "Header") {
      $cellheader = $value['Cells']['Cell'];
 ?>
  <tr>
      <td style="border-bottom:1px solid black;">Section</td>
      <td style="border-bottom:1px solid black;">Account</td>
      <td style="border-bottom:1px solid black;">Amount</td>
      <td style="border-bottom:1px solid black;">YTD</td>
    <?php
                    foreach ($cellheader as $key => $cellexpands) {
    ?>
    <?php
            if(isset($cellexpands['Value'])){
    ?>

    <?php
            }
    ?>
    <?php
                   }
    ?>
  </tr>
  <?php
}elseif (isset($value['Rows'])) {

  $getRow = $value['Rows']['Row'];

  foreach ($getRow as $key => $cellvalue) {
      if(isset($cellvalue['RowType'])){
      if ($cellvalue['RowType'] == "Row") {
          $getCells = $cellvalue['Cells']['Cell'];
          echo "<tr>";
          echo "<td >" . $value['Title'] . "</td>";
          foreach ($getCells as $key => $cellvaluesmany) {
              if (isset($cellvaluesmany['Value'])) {
                  echo "<td>" . $cellvaluesmany['Value'] . "</td>";
              } else {
                  echo "<td>-</td>";
              }
          }

          echo "</tr>";
      }
    }

  }

}
}
}
 ?>
</table>

<?php
        $html = ob_get_clean();
      }else{
          $html = $id;
      }
      return $html;
    }
    function update_template($id, $data) {
      $query = $this->db->query('SELECT * FROM template_db WHERE template_name="'.$data['template_name'].'" and ID != "'.$id.'"');
      $count = $query->num_rows();

       if ($count == 0) {
           $validation = 'success';
           $this->db->where('ID', $id);
           $this->db->update('template_db', $data);
       } else {
           $validation = 'exist';
       }

       return $validation = $validation;
    }
    function pc_info() {
            $computerId = $_SERVER['HTTP_USER_AGENT'].$_SERVER['LOCAL_ADDR'].$_SERVER['LOCAL_PORT'].$_SERVER['REMOTE_ADDR'];
            return $computerId;
    }
    function list_template(){
      return  $this->db->query('SELECT * FROM template_db');
    }
    function page_list_select($id){
      return  $this->db->query("
SELECT * FROM layout_pages_tbl as a LEFT JOIN(SELECT * FROM page_content_details_tbl) as b ON a.ID = b.layout_page_id where page_template='".$id."' and status='Active' ORDER BY sort");
    }

    function counttemplate(){
      $query = $this->db->query('SELECT * FROM template_db');
      $count = $query->num_rows();
      return  $count ;
    }
    function add_templates($data) {
      $validation = $data['template_name'];
      $query = $this->db->query('SELECT * FROM template_db WHERE template_name="'.$validation.'"');
      $count = $query->num_rows();
       if ($count == 0) {
           $this->db->insert('template_db', $data);
           $validation = 'success';
       } else {
           $validation = 'exist';
       }
       return $validation;
    }
    function add_layout($data) {
      $validation = $data['page_title'];
      $template_id = $data['template_id'];
      $query = $this->db->query('SELECT * FROM layout_pages_tbl WHERE page_title="'.$validation.'" and template_id="'.$template_id.'"');
      $count = $query->num_rows();
       if ($count == 0) {
           $this->db->insert('layout_pages_tbl', $data);
           $validation = 'success';
       } else {
           $validation = 'exist';
       }
       return $validation;
    }

    function add_tagged_group($data) {
        return $this->db->insert('tag_group', $data);
    }

    function delete_tagged_group($data) {
        $this->db->where($data);
        return $this->db->delete('tag_group');
    }

    function delete_profile($id) {
        $this->db->where('ID', $id);
        $this->db->delete('employee_info');
    }
    function delete_calendar($id) {
        $this->db->where('ID', $id);
        $this->db->delete('events_tbl');
    }
    function delete_template($id) {
        $this->db->where('ID', $id);
        $this->db->delete('template_db');
    }
    function pagination($limit, $pages, $total) {

        $set_val = $limit;
        $i_value = floor($total / $set_val);
        $i_remainder = $total % $set_val;
        if ($i_remainder != 0) {
            $total_value_loop = $i_value + 1;
        } else {
            $total_value_loop = $i_value;
        }

        $prev = $pages - 1;
        $next = $pages + 1;

        $to = $pages * $set_val;
        $from = $to - $set_val + 1;


        if (strlen($pages) == "" || $pages == 0 || $pages == 1) {
            $prev = "";
        } else {
            $prev = " <a href='" . site_url("Users/page/" . $prev) . "'>&laquo;</a>";
        }
        $page_number = "";
        for ($x = 1; $x <= $total_value_loop; $x++) {

            if ($x == $pages) {
                $class = "class='active'";
            } else {
                $class = "class=''";
            }

            $page_number = $page_number . "<a href='" . site_url('Users/page/' . $x) . "' " . $class . ">" . $x . "</a>";
        }

        if ($total_value_loop == $pages) {
            $next = "";
        } else {
            $next = "<a href='" . base_url("Users/page/" . $next) . "'>&raquo;</a>";
        }
        $bind_pagination = $prev . $page_number . $next;
        return $bind_pagination;
    }
    function calendar_caption($data){
                    $label ="";
                    if($data == '1'){
                        $label ="January";
                    }elseif($data == '2'){
                        $label ="February";
                    }elseif($data == '3'){
                        $label ="March";
                    }elseif($data == '4'){
                        $label ="April";
                    }elseif($data == '5'){
                        $label ="May";
                    }elseif($data == '6'){
                        $label ="June";
                    }elseif($data == '7'){
                        $label ="July";
                    }elseif($data == '8'){
                        $label ="August";
                    }elseif($data == '9'){
                        $label ="September";
                    }elseif($data == '10'){
                        $label ="October";
                    }elseif($data == '11'){
                        $label ="November";
                    }elseif($data == '12'){
                        $label ="December";
                    }else{
                         $label="";
                    }
                    return $label;
    }
    function get_color($data){
            if($data == '1'){
                        $color ="#1abc9c";
            }elseif($data == '2'){
                        $color ="#498db";
            }elseif($data == '3'){
                        $color ="#9b59b6";
            }elseif($data == '4'){
                        $color ="#5c6270";
            }elseif($data == '5'){
                        $color ="#e67e22";
            }elseif($data == '6'){
                        $color ="#E9D460";
            }else{
                        $color ="";
            }
            return $color;
    }
    function get_events_per_month($month , $year) {
        return $this->db->query("SELECT * FROM events_tbl where month='$month' and year='$year' order by day");
    }
    function login_script($data) {
        return $this->db->query("SELECT * FROM `employee_info` WHERE email ='" . $data['email'] . "' and password='" . $data['password'] . "' ");
    }
    function events_json() {
        return $this->db->query("SELECT category as name, CONCAT(year , '-', month, '-', day) as date  FROM events_tbl");
    }

    function sessions($data) {
        $sql = "SELECT * FROM `employee_info` WHERE email ='" . $data['email'] . "' and password='" . $data['password'] . "' ";
        $query = $this->db->query($sql);
        return $query;
    }

    function model_update($id, $object) {
        $this->db->where('ID', $id);
        $this->db->update('employee_info', $object);
    }
    function update_status_page($id, $object) {
        $this->db->where('ID', $id);
        $this->db->update('layout_pages_tbl', $object);
    }
    function sort_page($id, $object) {
        $this->db->where('ID', $id);
        $this->db->update('layout_pages_tbl', $object);
    }

    function model_delete_employee($id) {
        $this->db->where('ID', $id);
        $this->db->delete('employee_info');
    }

    function model_registration($data) {
        return $this->db->insert('employee_info', $data);
    }
    function pdf_log($data) {
        return $this->db->insert('pdf_files_tbl', $data);
    }
    function add_events($data) {
        return $this->db->insert('events_tbl', $data);
    }
    function addpage($data) {
        $validation = $data['layout_page_id'];
        $this->db->where('layout_page_id', $validation);
        $this->db->delete('page_content_details_tbl');
        return $this->db->insert('page_content_details_tbl', $data);
    }
    function update_events($id, $object) {
         $this->db->where('ID', $id);
         $this->db->update('events_tbl', $object);
    }

    function model_get_id() {
        return $this->db->query('SELECT ID FROM employee_info ORDER BY `employee_info`.`ID` DESC LIMIT 1');
    }
    function get_page($id) {
        return $this->db->query("SELECT a.*, b.template_name FROM layout_pages_tbl as a LEFT JOIN(SELECT * FROM template_db) as b ON a.template_id = b.ID where a.ID='".$id."'");
    }
    function user_info() {
        // $setLimit = $this->max_row();
        // $srh = explode(" ", $this->keyword());
        // $pageLimit = ($this->page() * $setLimit) - ($setLimit);
        //$conditions = array();
        // foreach ($srh as $field) {
//            if ($field) {
//                $conditions[] = "`employee_id_no` LIKE '%" . $field . "%'";
//                $conditions[] = "`first_name` LIKE '%" . $field . "%'";
//                $conditions[] = "`last_name` LIKE '%" . $field . "%'";
//                $conditions[] = "`email` LIKE '%" . $field . "%'";
//            }
//        }
//        $_query = "SELECT * FROM employee_info ";
//        if (count($conditions) > 0) {
//            $_query .= "WHERE " . implode(' || ', $conditions);
//        }
//        return $this->db->query($_query . " ORDER BY `last_name` LIMIT $pageLimit , $setLimit");
        return $this->db->query('SELECT ID FROM employee_info ORDER BY `employee_info`.`ID` DESC LIMIT 1');
    }
    function template_list() {
        return $this->db->query('SELECT * FROM template_db LIMIT 5 ');
    }
    function rowData($table) {
        return $this->db->query('SELECT * FROM '.$table.'');
    }
    function template_lists($limit) {
        return $this->db->query('SELECT * FROM template_db LIMIT '. $limit);
    }
    function user_list() {
        return $this->db->query('SELECT * FROM employee_info ');
    }

    function user_info_list($filter) {
        return $this->db->query("SELECT * FROM employee_info where ID='" . $filter . "'");
    }
     function user_tag($filter) {
        return $this->db->query(" SELECT * FROM tag_group as a LEFT JOIN(SELECT * FROM user_group) as b ON a.group_id = b.GID where user_id='" . $filter . "' and LENGTH(group_name) != 0");
    }

     function calendar_info($filter) {
        return $this->db->query("SELECT * FROM events_tbl where ID='" . $filter . "'");
    }

    function events_category() {
        return $query = $this->db->query("SELECT * FROM events_category_tbl");
    }

    function location() {
        return $query = $this->db->query("SELECT * FROM location_tbl");
    }

    function count_users() {
        return $query = $this->db->query("SELECT count(*) as count FROM employee_info ");
    }

    function user_list_w_page($val, $val2, $val3) {
        return $this->db->query("
            SELECT * FROM (select @rownum:=@rownum+1 nowef,
            p.* from employee_info p, (SELECT @rownum:=0) r ) MY_data
            where nowef BETWEEN '" . $val . "' AND '" . $val2 . "' and first_name LIKE'%" . $val3 . "%'
                or
                 last_name LIKE'%" . $val3 . "%'
                or
                 middle_name LIKE'%" . $val3 . "%'
                or
                 email LIKE'%" . $val3 . "%'
                or
                 department LIKE'%" . $val3 . "%'
             ");
    }

    function get_events($month, $year) {
        return $this->db->query("SELECT * FROM events_tbl where   month='".$month."' and year='".$year."'");
    }
    function password_validation($id, $password) {
        return $this->db->query("SELECT * FROM employee_info where   ID='".$id."' and password='".$password."'");
    }
    function get_event_today() {
        $day   =    date("d");
        $month =    date("m");
        $year  =    date("Y");

        return $this->db->query("SELECT * FROM events_tbl where  month='$month ' and year='$year' ORDER BY day ASC ");
    }
    function get_event_today_manual($month,  $year) {
        $query = $this->db->query("SELECT * FROM events_tbl where  month='$month' and year='$year' ORDER BY day ASC ");

          return $query->result();
    }
    function get_template_table() {
        return $this->db->query("SELECT * FROM layout_pages_tbl as a LEFT JOIN(SELECT * FROM page_content_details_tbl) as b ON a.ID = b.layout_page_id where status='Active' ORDER BY sort");
    }
}
