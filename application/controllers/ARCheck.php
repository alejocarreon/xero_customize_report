<?php

defined('BASEPATH') OR exit('No direct script access allowed');
///header('Content-Type: application/json');

class ARCheck extends CI_Controller {

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

    function connect(){
      $id ="";
      $date = "11-23-2018";
      $client="51";
      $key = "R6BRJI8YN4FFOHBO47A0QJAKIHXMEV";
      $secret = "R6BRJI8YN4FFOHBO47A0QJAKIHXMEV";
      $timestamp = "R6BRJI8YN4FFOHBO47A0QJAKIHXMEV";
      $timestamp =  date('mdYhis');

      $query_value = "&date=" . $date;
      $endpoint = "?key=" . $key . "&secret=" . $secret . $query_value;
      $url = site_url('AR/connect' . $endpoint);
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL, $url);
      $result = curl_exec($ch);
      curl_close($ch);
      $obj = json_decode($result, true);
      $ReportName = $obj["Reports"]["Report"]["ReportName"];
      $ReportDate = $obj["Reports"]["Report"]["ReportDate"];
      $Row = $obj["Reports"]["Report"]["Rows"]["Row"];
      //  foreach ($Row as $key => $value){
      ob_start();
?>
<table>
 <tr>
   <td align="center" style= "font-family: helvetica !important;"><h1>Balance Sheet</h2></td>
   </tr>
   <tr>
       <td></td>
   </tr>
</table>
<br />
<br />
<table width="100%" cellSpacing="0" cellpadding="0" style= "font-family: helvetica !important;">
<?php
    foreach($Row as $key => $value) {
      if ($value['RowType'] == "Header") {
        $cellheader = $value['Cells']['Cell'];
?>
<tr>
    <td style="border-bottom:1px solid black;">Section</td>
    <td style="border-bottom:1px solid black;">Account</td>
    <td style="border-bottom:1px solid black;">Amount</td>
    <td style="border-bottom:1px solid black;">YTD</td>
  <?php
        foreach($cellheader as $key => $cellexpands) {
?>
  <?php
          if (isset($cellexpands['Value'])) {
?>

  <?php
          }
?>
  <?php
        }
?>
</tr>
<?php
      }
      elseif(isset($value['Title'])){
         if($value['Title'] == "Current Assets"){
            $getdata = $value['Rows']['Row'];
            foreach($getdata as $key => $getcell) {
                $getthiscell = $getdata['Cells']['Cell'];
                foreach($getthiscell as $key => $getcellprint) {
                }
            }
              $count = 0;
              foreach($getthiscell as $key => $getcellprint) {
                $count++;
                if($count == 1){
                    $account_name =   $getcellprint['Value'];
                }else{
                    $account_name =   "";
                }
                if($count == 2){
                    $amount =   $getcellprint['Value'];
                }else{
                    $amount =   "";
                }

              }
         }
      }
    }
?>
</table>

<?php
    $html = ob_get_clean();
    echo $html;
	}

}
