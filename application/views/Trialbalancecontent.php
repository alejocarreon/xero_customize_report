<?php
$key = $this->session->userdata('key');
$secret = $this->session->userdata('secret');

$endpoint = "?key=".$key."&secret=".$secret;
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
