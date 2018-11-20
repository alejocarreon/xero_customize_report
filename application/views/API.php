<?php
        $url = site_url('TrialBalance/connect');
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

?>
<table width="100%" cellspacing="0" cellpadding="0" >
  <?php
          foreach ($Row as $key => $value){
              if ($value['RowType'] == "Header") {
                  $cellheader = $value['Cells']['Cell'];
  ?>
  <tr class="<?php
                  echo $value['RowType'];
  ?>">
     <td>Account Type</td>
  <?php
                  foreach ($cellheader as $key => $cellexpand) {
  ?>
        <td><?php
                      echo $cellexpand['Value'];
  ?></td>
  <?php
                  }
  ?>

  </tr>
  <?php
              } elseif (isset($value['Title'])) {
                  $getRow = $value['Rows']['Row'];

                  foreach ($getRow as $key => $cellvalue) {

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

              } else {
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
