<?php
        $url = site_url('AR/connect');
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

          echo "<tr>";
      }
    }

  }

}
}
   ?>
</table>
