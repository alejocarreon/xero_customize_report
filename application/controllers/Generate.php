<?php
ini_set("allow_url_fopen", 1);
defined('BASEPATH') OR exit('No direct script access allowed');
//header('Content-Type: application/json');

class Generate extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Modules');
        $this->load->model('Models');
        $this->load->database();
    }

    public function index() {
      $url = site_url('TrialBalance/connect');
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL,$url);
      $result = curl_exec($ch);
      curl_close($ch);
      $obj = json_decode($result , true);

    $ReportName = $obj["Reports"]["Report"]["ReportName"];
    $ReportDate = $obj["Reports"]["Report"]["ReportDate"];
    $Row = $obj["Reports"]["Report"]["Rows"]["Row"];
  //  $Rowinside = $obj["Reports"]["Report"]["Rows"]["Row"]["Rows"];
    //$cells = $obj["Reports"]["Report"]["Rows"]["Row"]["Cells"]["cell"];
?>
<table width="100%" cellspacing="0" cellpadding="0" >
<?php
foreach($Row as $key=>$value){
              //$rtype =  $value['RowType'];
             //echo $value['Title']  ."<br>"
            //$cellheader =  $value['Cells']['Cell'];
if($value['RowType'] == "Header"){

    $cellheader = $value['Cells']['Cell'];
?>
<tr class="<?php echo $value['RowType']; ?>">
   <td>Account Type</td>
<?php
    foreach($cellheader as $key=>$cellexpand){
  ?>
      <td><?php echo $cellexpand['Value'];?></td>
<?php
}
 ?>

</tr>
<?php
}elseif(isset($value['Title'])){
     $getRow = $value['Rows']['Row'];

       foreach($getRow as $key=>$cellvalue){

            if($cellvalue['RowType'] == "Row"){
               $getCells = $cellvalue['Cells']['Cell'];
              echo "<tr>";
                  echo "<td>".$value['Title']."</td>";
                  foreach($getCells as $key=>$cellvaluesmany){
                         if(isset($cellvaluesmany['Value'])){
                           echo "<td>".$cellvaluesmany['Value']."</td>";
                         }else{
                           echo "<td>-</td>";
                         }
                  }

                echo "<tr>";
            }

       }

}else{
    ?>
    <tr>
        <td>&nbsp;</td>
        <?php
        $celltotal = $value['Rows']['Row']['Cells']['Cell'];
          foreach($celltotal as $key=>$cellprint){
              echo "<td>".$cellprint['Value']."</td>";
          }

        ?>


    </tr>
    <?php
}
}
?>
</table>
<?php


    }

}
