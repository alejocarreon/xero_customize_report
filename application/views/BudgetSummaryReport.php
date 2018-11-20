<?php
        $url = site_url('BudgetSummary/connect');
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
?>

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
