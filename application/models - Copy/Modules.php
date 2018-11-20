<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Modules extends CI_Model

{
	public function __construct()

	{
		parent::__construct();
		$this->load->database();
		header('Access-Control-Allow-Origin: *');
	}
	function index()
	{
	}
	function test_trial_data($id, $date, $client, $key, $secret, $timestamp){
		$expolode_date = explode("-", $date);
		$date_new = $expolode_date[0] . "-" . $expolode_date[1] . "-" . $expolode_date[2];
		$date_month = $expolode_date[0];
		$query_value = "&date=" . $date;
		$key = $key;
		$secret = $secret;
		$endpoint = "?key=" . $key . "&secret=" . $secret . $query_value;
		$get_account = "";
		$debit_account = "";
		$credit_account = "";
		$debit_ytd_account = "";
		$credit_ytd_account = "";

		$url = site_url('TrialBalance/connect' . $endpoint);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		curl_close($ch);
		$obj = json_decode($result, true);
		$ProviderName = $obj["ProviderName"];
		$ReportDate = $obj["Reports"]["Report"]["ReportDate"];
		$Row = $obj["Reports"]["Report"]["Rows"]["Row"];
		ob_start();
?>
			 <table class="table table-responsive" style= "font-family: helvetica !important;">

			<?php
			foreach($Row as $key => $value) {
			if ($value['RowType'] == "Header") {

			}elseif(isset($value['Title'])){
				$getRow = $value['Rows']['Row'];
				foreach($getRow as $key => $cellvalue) {
					if ($cellvalue['RowType'] == "Row") {
						$getCells = $cellvalue['Cells']['Cell'];
						echo "<tr>";
						echo "<td>" . $value['Title'] . "</td>";
						foreach($getCells as $key => $cellvaluesmany) {
							if (isset($cellvaluesmany['Value'])) {
								echo "<td><font size='1'>" . $cellvaluesmany['Value'] . "</font></td>";
							}
							else {
								echo "<td>-</td>";
							}
						}
						echo "</tr>";
					}
				}

			}
?>
			</table>
			<?php

	}
	$html = ob_get_clean();
		return $html;
}
	function loop_trial_balance($id, $date, $client, $key, $secret, $timestamp){

		$expolode_date = explode("-", $date);
		$date_new = $expolode_date[0] . "-" . $expolode_date[1] . "-" . $expolode_date[2];
		$date_month = $expolode_date[0];
		$query_value = "&date=" . $date;
		$key = $key;
		$secret = $secret;
		$endpoint = "?key=" . $key . "&secret=" . $secret . $query_value;
		$get_account = "";
		$debit_account = "";
		$credit_account = "";
		$debit_ytd_account = "";
		$credit_ytd_account = "";

		$url = site_url('TrialBalance/connect' . $endpoint);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL, $url);
		$result = curl_exec($ch);
		curl_close($ch);
		$obj = json_decode($result, true);
		$ProviderName = $obj["ProviderName"];
		$ReportDate = $obj["Reports"]["Report"]["ReportDate"];
		$Row = $obj["Reports"]["Report"]["Rows"]["Row"];
		ob_start();
		foreach($Row as $key => $value) {
			if ($value['RowType'] == "Header") {

			}
			elseif (isset($value['Title'])) {
				$title = $value['Title'];
				$getRow = $value['Rows']['Row'];
				foreach($getRow as $key => $cellvalue) {
					if(isset($cellvalue['RowType'])){
					if ($cellvalue['RowType'] == "Row") {
						$getCells = $cellvalue['Cells']['Cell'];

						$count = 0;
						$value ="";
						foreach($getCells as $key => $cellvaluesmany) {
						$count++;
							if (isset($cellvaluesmany['Value'])) {
								$value =  $cellvaluesmany['Value'] ;
							}
							else {
								$value = 0 ;
							}

							if($count == 1){
								$get_account = $value;
							}

							if($count == 2){
								$debit_account = $value;
							}

							if($count == 3){
								$credit_account = $value;
							}

							if($count == 4){
								$debit_ytd = $value;
							}
							if($count == 5){
								$credit_ytd = $value;
								$data = array(
								"account" => $get_account,
								"account_type" => $title,
								"debit" => $debit_account,
								"credit" => $credit_account,
								"ytddebit" => $debit_ytd,
								"ytdcredit" => $credit_ytd,
								"date" => $expolode_date[0] . "/" . $expolode_date[1] . "/" . $expolode_date[2],
								"month" => $expolode_date[0],
								"day" => $expolode_date[1],
								"year" => $expolode_date[2] ,
								"reference" => $client . "-" .  $timestamp
							);
							  $this->db->insert('trial_balance_logs', $data);
								$sql =  "INSERT INTO trial_balance_logs ()
												VALUES
												('$get_account', '$title',  '$debit_account', '$credit_account', '$debit_ytd', '$credit_ytd')"."<br>";


							}
						}

					}
				}//set
			}
			}

		}
?>

			<?php

	}
	function loop_balance_sheet($id, $date, $client, $key, $secret, $timestamp){

		$expolde_date = explode("-", $date);
		$date_new = $expolde_date[0] . "-" . $expolde_date[1] . "-" . $expolde_date[2];
		$date_month = $expolde_date[0];
		$query_value = "&date=" . $date_new;
		$key = $key;
		$secret = $secret;
		$query_value = "&date=" . $date_new;
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
		$get_account ="";
		foreach($Row as $key => $value) {
			if ($value['RowType'] == "Header") {
				$cellheader = $value['Cells']['Cell'];
				foreach($cellheader as $key => $cellexpands) {
					if (isset($cellexpands['Value'])) {
					}
				}
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
								 $get_account =   $getcellprint['Value'];
						 }
						 if($count == 2){
								 $get_amount =   $getcellprint['Value'];
						 }

					 }
					 $data = array(
						 "section" => $value['Title'],
						 "account" => $get_account,
						 "amount_ytd" => "",
						 "client" => $client,
						 "add_by" => $this->session->userdata('user_session') ,
						 "date" => sprintf("%02d", $expolde_date[0]) . "/" . $expolde_date[1] . "/" . $expolde_date[2],
						 "month" => sprintf("%02d", $expolde_date[0]) ,
						 "day" => $expolde_date[1],
						 "year" => $expolde_date[2],
						 "reference" => $client . "-" .  $timestamp ,
						 "amount" => $get_amount
					 );
					 $this->db->insert('balance_sheet_data_logs', $data);
				  }else {
			    if(isset($value['Rows'])) {
					$getRow = $value['Rows']['Row'];
					foreach($getRow as $key => $cellvalue) {
						if (isset($cellvalue['RowType'])) {
							if ($cellvalue['RowType'] == "Row") {
								$getCells = $cellvalue['Cells']['Cell'];
								$count_td = 0;
								foreach($getCells as $key => $cellvaluesmany) {
									$count_td++;
									if($count_td == 1){
											 $get_account = $cellvaluesmany['Value']  ;
									}elseif($count_td == 2){
										 $get_amount = $cellvaluesmany['Value'] ;

										if (isset($cellvaluesmany['Value'])) {
											$data = array(
												"section" => $value['Title'],
												"account" => $get_account,
												"amount_ytd" => "",
												"client" => $client,
												"add_by" => $this->session->userdata('user_session') ,
												"date" => sprintf("%02d", $expolde_date[0]) . "/" . $expolde_date[1] . "/" . $expolde_date[2],
												"month" => sprintf("%02d", $expolde_date[0]) ,
												"day" => $expolde_date[1],
												"year" => $expolde_date[2],
												"reference" => $client . "-" .  $timestamp ,
												"amount" => $get_amount
											);
											$this->db->insert('balance_sheet_data_logs', $data);
									}
								}

								}
							}
						}
					}
				}//if row set
				}
			}

		}

	}
	function date_caption_convert($date){
				$date_explode = explode("/", $date);
				$datecaption = $this->calendar_caption($date_explode[0]);
				return $datecaption ." ".$date_explode[2];
	}
	function date_caption_convert_full($date){
				$date_explode = explode("/", $date);
				$datecaption = $this->calendar_caption_full($date_explode[0]);
				return $datecaption ." ".$date_explode[2];
	}
	function get_trial_balance($id, $date, $client, $key, $secret,  $loop,  $clientname){
		$timestamp =  date('mdYhis');
		$date_required = explode("-", $date);
		$reference =  $client."-".$timestamp ;

		$date_converted = $date_required[1]. "-".$date_required[0]. "-".$date_required[2];
				for ($x = 0; $x <= $loop; $x++) {
					  $newdate = strtotime ( '-'.$x.' month' , strtotime ($date_converted) ) ;
					  $newdate = date ( 'm-d-Y' , $newdate );
						$this->loop_trial_balance($id, $newdate, $client, $key, $secret, $timestamp);
				}


	}
	function get_date($id, $date, $client, $key, $secret,  $loop,  $clientname){
		  $timestamp =  date('mdYhis');
			$reference =  $client."-".$timestamp ;
		  $print_date ="";
			$concatenate_date="";
			$concat_script="";
			$date_required = explode("-", $date);
			$script_join="";

			$date_converted = $date_required[1]. "-".$date_required[0]. "-".$date_required[2];

			for ($x = 0; $x <= $loop; $x++) {
				$newdate = strtotime ( '-'.$x.' month' , strtotime ($date_converted) ) ;
				$newdate = date ( 'm-d-Y' , $newdate );
				 $this->loop_balance_sheet($id, $newdate, $client, $key, $secret, $timestamp);
				$date_explodeded = explode("-",$newdate);
				$concatenate_date .= $newdate ."|";
				$datacaption ="SQL".$x;
				$data_script = $datacaption.".NegativeTotal$datacaption, ".$datacaption.".PostiveTotal$datacaption, ".$datacaption.".date$datacaption ,";
				$concat_script .= $data_script;

				$script_join .= "LEFT JOIN(
					SELECT account,section, amount,date as date$datacaption,
					SUM(CASE WHEN amount<0 THEN amount ELSE 0 END) as NegativeTotal".$datacaption.",
					SUM(CASE WHEN amount>=0 THEN amount ELSE 0 END) as PostiveTotal".$datacaption." FROM balance_sheet_data_logs as a
					where month='".$date_explodeded[0]."' and year='".$date_explodeded[2]."' and client='".$client."'
					and reference='".$reference."' GROUP BY account, amount, section
					) as ".$datacaption."
					ON a.account = ".$datacaption.".account ";

			}
				$data_date = explode("|", $concatenate_date);
				$date_exploded = explode("-",$data_date[0]);
				$first_year = $date_exploded[2];
				$month_year = $date_exploded[0];
				$data_add_no_error = $concat_script . " CONCAT('y')as NoError";

				$sql = "SELECT a.account,a.section, ".$data_add_no_error."

				FROM balance_sheet_data_logs as a
				 ".$script_join."

				where a.client='".$client."' and a.reference='".$reference."'
				GROUP BY a.account";

			$query = $this->db->query($sql);
			$data = $query->result();
	   // foreach ($data as $key) {

	   //}
		   ob_start();
			 ?>
			 <table cellSpacing="0" cellpadding="0" width="100%">
				 <tr>
					 	<td align="center"><span style="font-weight: bold;" ><?php echo $clientname; ?></span></td>
				 </tr>
				 <tr>
					 	<td align="center"><span style="font-weight: bold;" >Balance Sheet</span></td>
				 </tr>
				 <tr>
					 <td align="center"><span style="font-weight: bold;" >as of <?php  echo $this->date_caption_convert_full($date_exploded[0]."/".$date_exploded[1]."/".$date_exploded[2]); ?></span></td>
				</tr>
				 <tr>
					 	<td align="center">&nbsp;</td>
				 </tr>
				 <tr>
					 <td align="center">&nbsp;</td>
				</tr>
			</table>
			 <table cellSpacing="0" cellpadding="0" width="100%">
				 		<tr>
								<th></th>
						<?php
							foreach ($data as $key){
							}
						?>
								<th style="text-align:right !important;"><span style="font-weight: bold;"><?php echo $this->date_caption_convert($key->dateSQL5); ?></span></th>
								<th style="text-align:right !important;"><span style="font-weight: bold;"><?php echo $this->date_caption_convert($key->dateSQL4); ?></span></th>
								<th style="text-align:right !important;"><span style="font-weight: bold;"><?php echo $this->date_caption_convert($key->dateSQL3); ?></span></th>
								<th style="text-align:right !important;"><span style="font-weight: bold;"><?php echo $this->date_caption_convert($key->dateSQL2); ?></span></th>
								<th style="text-align:right !important;"><span style="font-weight: bold;"><?php echo $this->date_caption_convert($key->dateSQL1);?></span></th>
								<th style="text-align:right !important;"><span style="font-weight: bold;"><?php echo $this->date_caption_convert($key->dateSQL0); ?></span></th>

						</tr>
						<tr>
							<th colspan="5"><span style="font-weight: bold; margin-left:10px;">Assets</span></th>
						</tr>
						<tr>
								<th colspan="5">&nbsp;&nbsp;&nbsp;<span style="font-weight: bold; margin-left:10px;">Current Assets</span></th>
						</tr>
						<tr>
							<th colspan="5">&nbsp;</th>
						</tr>

						<tr>
							<th colspan="5"><span style="font-weight: bold; margin-left:10px;">Cash</span></th>
						</tr>
						<?php
						$total5cash = 0 ;
						$total4cash = 0 ;
						$total3cash = 0 ;
						$total2cash = 0 ;
						$total1cash = 0 ;
						$total0cash = 0 ;
						foreach ($data as $key){
							if($key->section == "Cash and Cash Equivalents"){
								 $total5cash = $total5cash + $key->PostiveTotalSQL5 - $key->NegativeTotalSQL5;
								 $total4cash = $total4cash + $key->PostiveTotalSQL4 - $key->NegativeTotalSQL4;
								 $total3cash = $total3cash + $key->PostiveTotalSQL3 - $key->NegativeTotalSQL3;
								 $total2cash = $total2cash + $key->PostiveTotalSQL2 - $key->NegativeTotalSQL2;
								 $total1cash = $total1cash + $key->PostiveTotalSQL1 - $key->NegativeTotalSQL1;
								 $total0cash = $total0cash + $key->PostiveTotalSQL0 - $key->NegativeTotalSQL0;
						 ?>
				 		<tr>
								<td>&nbsp;<span style='margin-right:10px !important;'><?php echo $key->account?></span></td>
								<td style="text-align:right !important"><span style=';margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
						</tr>
						<?php
						}
					}
						 	?>
							<tr>
								<td><span style="font-weight: bold;">Total Cash</span></td>
			 				 	<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5cash, 0); ?></span></td>
			 					<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4cash, 0); ?></span></td>
			 					<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3cash, 0); ?></span></td>
			 					<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2cash, 0); ?></span></td>
			 					<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1cash, 0); ?></span></td>
			 					<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0cash, 0); ?></span></td>
			 			 </tr>
						 <tr>
 							<th colspan="5">&nbsp;</th>
 						</tr>

						<?php
						$total5receivable = 0 ;
						$total4receivable = 0 ;
						$total3receivable = 0 ;
						$total2receivable = 0 ;
						$total1receivable = 0 ;
						$total0receivable = 0 ;
						foreach ($data as $key){
							if($key->section == "Current Assets"){
								 $total5receivable = $total5receivable + $key->PostiveTotalSQL5 - $key->NegativeTotalSQL5;
								 $total4receivable = $total4receivable + $key->PostiveTotalSQL4 - $key->NegativeTotalSQL4;
								 $total3receivable = $total3receivable + $key->PostiveTotalSQL3 - $key->NegativeTotalSQL3;
								 $total2receivable = $total2receivable + $key->PostiveTotalSQL2 - $key->NegativeTotalSQL2;
								 $total1receivable = $total1receivable + $key->PostiveTotalSQL1 - $key->NegativeTotalSQL1;
								 $total0receivable = $total0receivable + $key->PostiveTotalSQL0 - $key->NegativeTotalSQL0;
						 ?>
						<tr>
								<td>&nbsp;<span style='margin-right:10px !important;'><?php echo $key->account?></span></td>
								<td style="text-align:right !important"><span style=';margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
								<td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
						</tr>
						<?php
						}
					}
							?>

						<tr>
							<th colspan="5">&nbsp;</th>
						</tr>
						 <tr>
							 <th colspan="5"><span style="font-weight: bold;">Inventories</span></th>
						 </tr>
						 <?php
						 $total5inventory = 0 ;
						 $total4inventory = 0 ;
						 $total3inventory = 0 ;
						 $total2inventory = 0 ;
						 $total1inventory = 0 ;
						 $total0inventory = 0 ;
						 foreach ($data as $key){
							 if($key->section == "Inventories"){
									$total5inventory = $total5inventory + $key->PostiveTotalSQL5 - $key->NegativeTotalSQL5;
									$total4inventory = $total4inventory + $key->PostiveTotalSQL4 - $key->NegativeTotalSQL4;
									$total3inventory = $total3inventory + $key->PostiveTotalSQL3 - $key->NegativeTotalSQL3;
									$total2inventory = $total2inventory + $key->PostiveTotalSQL2 - $key->NegativeTotalSQL2;
									$total1inventory = $total1inventory + $key->PostiveTotalSQL1 - $key->NegativeTotalSQL1;
									$total0inventory = $total0inventory + $key->PostiveTotalSQL0 - $key->NegativeTotalSQL0;
							?>
						 <tr>
								 <td>&nbsp;<span style='margin-left:10px !important;'><?php echo $key->account?></span></td>
								 <td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
								 <td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
								 <td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
								 <td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
								 <td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
								 <td style="text-align:right !important"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
						 </tr>
						 <?php
						 }
					 }
							 ?>
							 <tr>
								 <td ><span style="font-weight: bold;" nowrap>Total Inventories</span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5inventory, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4inventory, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3inventory, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2inventory, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1inventory, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0inventory, 0); ?></span></td>
							</tr>
						 <tr>
							 <th colspan="5">Other Current Assets</th>
						 </tr>
						 <?php
						 $total5other = 0 ;
						 $total4other = 0 ;
						 $total3other = 0 ;
						 $total2other = 0 ;
						 $total1other = 0 ;
						 $total0other = 0 ;
						 foreach ($data as $key){
							 if($key->section == "Other Current Assets"){
									$total5other = $total5other + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
									$total4other = $total4other + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
									$total3other = $total3other + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
									$total2other = $total2other + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
									$total1other = $total1other + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
									$total0other = $total0other + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);
							?>
						 <tr>
								 <td>&nbsp;<span style='margin-left:10px !important;'><?php echo $key->account?></span></td>
								 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
								 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
								 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
								 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
								 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
								 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
						 </tr>
						 <?php
						 }
					 }
							 ?>
							 <tr>
								 <td ><span style="font-weight: bold;">Total Other Current Assets</span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5other, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4other, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3other, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2other, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1other, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0other, 0); ?></span></td>
							</tr>

							 <tr>
								 	<td colspan="7">&nbsp;</td>
							 </tr>
							 <?php
 							$total5currentasset = 0 ;
 							$total4currentasset = 0 ;
 							$total3currentasset = 0 ;
 							$total2currentasset = 0 ;
 							$total1currentasset = 0 ;
 							$total0currentasset = 0 ;
 							foreach ($data as $key){
 								if($key->section == "Inventories" || $key->section == "Other Current Assets" || $key->section == "Cash and Cash Equivalents" || $key->section == "Current Assets"){
 									 $total5currentasset = $total5currentasset + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
 									 $total4currentasset = $total4currentasset + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
 									 $total3currentasset = $total3currentasset + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
 									 $total2currentasset = $total2currentasset + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
 									 $total1currentasset = $total1currentasset + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
 									 $total0currentasset = $total0currentasset + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);
 							 ?>

							<?php
						}
					}

							 ?>
							 <tr>
								 <td  ><span style="font-weight: bold;">Total Current Assets</span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5currentasset, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4currentasset, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3currentasset, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2currentasset, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1currentasset, 0); ?></span></td>
								 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0currentasset, 0); ?></span></td>
							</tr>
							<tr>
								<th colspan="5"></th>
							</tr>
							<tr>
									<th colspan="5"><span style='margin-left:10px !important;'>Non-current Assets</span></th>
							</tr>
							<tr>
								<th colspan="5"></th>
							</tr>
							<tr>
								<th colspan="5"><span style="font-weight: bold;">Property, Plant and Equipment</span></th>
							</tr>
							<?php
							$total5p = 0 ;
							$total4p = 0 ;
							$total3p = 0 ;
							$total2p = 0 ;
							$total1p = 0 ;
							$total0p = 0 ;
							foreach ($data as $key){
								if($key->section == "Non-Current Assets" && $key->account !='Security Deposits' && $key->account !='Accumulated Depreciation'){
									 $total5p = $total5p + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
									 $total4p = $total4p + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
									 $total3p = $total3p + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
									 $total2p = $total2p + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
									 $total1p = $total1p + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
									 $total0p = $total0p + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);
							 ?>
							<tr>
									<td>&nbsp;<span style='margin-left:10px !important;'><?php echo $key->account?></span></td>
									<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
									<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
									<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
									<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
									<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
									<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
							</tr>
							<?php
							}
						}
						?>
						<?php
						$total5n = 0 ;
						$total4n = 0 ;
						$total3n = 0 ;
						$total2n = 0 ;
						$total1n = 0 ;
						$total0n = 0 ;
						foreach ($data as $key){
							if($key->section == "Non-Current Assets" && $key->account !='Security Deposits' && $key->account !='Furniture and Fixtures'){
								 $total5n = $total5n + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
								 $total4n = $total4n + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
								 $total3n = $total3n + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
								 $total2n = $total2n + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
								 $total1n = $total1n + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
								 $total0n = $total0n + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);
						 ?>
						<tr>
								<td><span style='margin-left:10px !important;'><?php echo $key->account?></span></td>
								<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
								<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
								<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
								<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
								<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
								<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
						</tr>
						<?php
						}
					}
					?>
					<tr>
						<td ><span style="font-weight: bold;">Net Property, Plant and Equipment</span></td>
						<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4p - abs($total4n), 0); ?></span></td>
						<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4p - abs($total4n), 0); ?></span></td>
						<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3p - abs($total3n), 0); ?></span></td>
						<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2p - abs($total2n), 0); ?></span></td>
						<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1p - abs($total1n), 0); ?></span></td>
						<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0p - abs($total0n), 0); ?></span></td>
				 </tr>
				 <tr>
					 <td colspan="5">&nbsp;</td>
				 </tr>
				 <?php
				 $total5deposit = 0 ;
				 $total4deposit = 0 ;
				 $total3deposit = 0 ;
				 $total2deposit = 0 ;
				 $total1deposit = 0 ;
				 $total0deposit = 0 ;
				 foreach ($data as $key){
					 if( $key->account =='Security Deposits'){

						$total5deposit = $total5deposit + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
						$total4deposit = $total4deposit + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
						$total3deposit = $total3deposit + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
						$total2deposit = $total2deposit + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
						$total1deposit = $total1deposit + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
						$total0deposit = $total0deposit + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);

					?>
				 <tr>
						 <td>&nbsp;<span style='margin-left:10px !important;'><?php echo $key->account?></span></td>
						 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
						 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
						 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
						 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
						 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
						 <td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
				 </tr>
				 <?php
				 }
			 }
			 ?>
			 <tr>
				 <td colspan="5">&nbsp;</td>
			 </tr>

			 <?php
			 $total5call = 0 ;
			 $total4call = 0 ;
			 $total3call = 0 ;
			 $total2call = 0 ;
			 $total1call = 0 ;
			 $total0call = 0 ;
			 foreach ($data as $key){
				 if($key->section == "Non-Current Assets"){
						$total5call = $total5call + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
						$total4call = $total4call + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
						$total3call = $total3call + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
						$total2call= $total2call + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
						$total1call = $total1call + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
						$total0call = $total0call + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);
				?>

			 <?php
			 }
		 }
		 ?>
		 <tr>
				 <td><span style="font-weight: bold;margin-left:10px !important;">&nbsp;Total Non-current Assets</span></td>
				 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5call , 0);?></span></td>
				 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4call,  0)?></span></td>
				 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3call,  0)?></span></td>
				 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2call,  0)?></span></td>
				 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1call,  0)?></span></td>
				 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0call,  0)?></span></td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
 			 <td><span style="font-weight:bold; ">Total  Assets</span></td>
 			 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5call + $total5currentasset, 0);?></span></td>
 			 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4call + $total4currentasset,  0)?></span></td>
 			 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3call + $total3currentasset,  0)?></span></td>
 			 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2call + $total2currentasset,  0)?></span></td>
 			 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1call + $total1currentasset,  0)?></span></td>
 			 <td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0call + $total0currentasset,  0)?></span></td>
 	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<th colspan="5"><span style="font-weight:bold; ">Liabilities and Equity</span></th>
	</tr>
	<tr>
			<th colspan="5"><span style='margin-left:10px !important;font-weight:bold;'>&nbsp;Liabilities</span></th>
	</tr>
	<tr>
		<td colspan="5">&nbsp;</td>
	</tr>
	<tr>
		<th colspan="5"><span style="font-weight:bold; ">Current Liabilities</span></th>
	</tr>
	<?php
	$total5currentliability = 0 ;
	$total4currentliability = 0 ;
	$total3currentliability = 0 ;
	$total2currentliability = 0 ;
	$total1currentliability = 0 ;
	$total0currentliability = 0 ;
	foreach ($data as $key){
		if($key->section == "Current Liabilities"){
			 $total5currentliability = $total5currentliability + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
			 $total4currentliability = $total4currentliability + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
			 $total3currentliability = $total3currentliability + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
			 $total2currentliability = $total2currentliability + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
			 $total1currentliability = $total1currentliability + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
			 $total0currentliability = $total0currentliability + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);
	 ?>
	<tr>
			<td>&nbsp;<span style='margin-left:10px !important;'><?php echo $key->account?></span></td>
			<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
			<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
			<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
			<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
			<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
			<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
	</tr>
	<?php
	}
}
		?>
		<tr>
			<td><span style="font-weight:bold; ">Total  Current Liabilities</span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5currentliability , 0);?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0currentliability ,  0)?></span></td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<td><span style="font-weight:bold; ">Total Liabilities</span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5currentliability , 0);?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1currentliability ,  0)?></span></td>
			<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0currentliability ,  0)?></span></td>
		</tr>
		<tr>
			<td colspan="5">&nbsp;</td>
		</tr>
		<tr>
			<th colspan="5"><span style="font-weight:bold; ">Equity</span></th>
		</tr>
		<?php
		$total5equity = 0 ;
		$total4equity = 0 ;
		$total3equity = 0 ;
		$total2equity = 0 ;
		$total1equity = 0 ;
		$total0equity = 0 ;
		foreach ($data as $key){
			if($key->section == "Equity"){
				 $total5equity = $total5equity + $key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5);
				 $total4equity = $total4equity + $key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4);
				 $total3equity = $total3equity + $key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3);
				 $total2equity = $total2equity + $key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2);
				 $total1equity = $total1equity + $key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1);
				 $total0equity = $total0equity + $key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0);
		 ?>
		<tr>
				<td>&nbsp;<span style='margin-left:10px !important;'><?php echo $key->account?></span></td>
				<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL5 - abs($key->NegativeTotalSQL5),  0)?></span></td>
				<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL4 - abs($key->NegativeTotalSQL4),  0)?></span></td>
				<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL3 - abs($key->NegativeTotalSQL3),  0)?></span></td>
				<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL2 - abs($key->NegativeTotalSQL2),  0)?></span></td>
				<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL1 - abs($key->NegativeTotalSQL1),  0)?></span></td>
				<td style="text-align:right !important;"><span style='margin-left:10px !important;'><?php echo number_format($key->PostiveTotalSQL0 - abs($key->NegativeTotalSQL0),  0)?></span></td>
		</tr>
		<?php
		}
	}
			?>
			<tr>
				<td><span style="font-weight:bold; ">Total Equity</span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5equity , 0);?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4equity ,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3equity ,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2equity ,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1equity ,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0equity ,  0)?></span></td>
			</tr>
			<tr>
				<td colspan="5">&nbsp;</td>
			</tr>
			<tr>
				<td><span style="font-weight:bold; " nowrap>Total Liabilities and Equity</span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total5equity + $total5currentliability, 0);?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total4equity + $total4currentliability,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total3equity + $total3currentliability,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total2equity + $total2currentliability,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total1equity + $total1currentliability,  0)?></span></td>
				<td style="text-align:right !important;border-top:1px solid black;border-bottom:1px solid black;"><span style="font-weight: bold;"><?php echo number_format($total0equity + $total0currentliability,  0)?></span></td>
			</tr>
			 </table>

			 <?php
			 $html = ob_get_clean();
	     return $html;
	}

	function template_reports($id, $date, $client ,$key, $secret, $month_loop)
	{
    $timestamp =  date('mdYhis');
    if($id == "BalanceSheet"){

		$expolde_date = explode("-", $date);
		$date_new = $expolde_date[0] - 1 . "-" . $expolde_date[1] . "-" . $expolde_date[2];
		$query_value = "&date=" . $date_new;
		$key = $key;
		$secret =  $secret;
		$query_value = "&date=" . $date_new;
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
		foreach($Row as $key => $value) {
			if ($value['RowType'] == "Header") {
				$cellheader = $value['Cells']['Cell'];
				foreach($cellheader as $key => $cellexpands) {
					if (isset($cellexpands['Value'])) {
					}
				}
			}
			elseif (isset($value['Rows'])) {
				if (isset($value['Title'])) {
					$getRow = $value['Rows']['Row'];
					$VALUE_MONTH = $expolde_date[0] - 1;
					foreach($getRow as $key => $cellvalue) {
						if (isset($cellvalue['RowType'])) {
							if ($cellvalue['RowType'] == "Row") {
								$getCells = $cellvalue['Cells']['Cell'];
								$count_td = 1;
								foreach($getCells as $key => $cellvaluesmany) {
									$count_td++;
									if ($count_td != 4 && $count_td != 2) {
										if (isset($cellvaluesmany['Value'])) {
											$data = array(
												"section" => $value['Title'],
												"account" => "",
												"amount_ytd" => "",
												"client" => $client,
												"add_by" => $this->session->userdata('user_session') ,
												"date" => sprintf("%02d", $VALUE_MONTH) . "/" . $expolde_date[1] . "/" . $expolde_date[2],
												"month" => sprintf("%02d", $expolde_date[0] - 1) ,
												"day" => $expolde_date[1],
												"year" => $expolde_date[2],
												"reference" => $client . "-" . $timestamp ,
												"amount" => $cellvaluesmany['Value']
											);
											$this->db->insert('balance_sheet_data_logs', $data);
										}
										else {
										}
									}
								}
							}
						}
					}
					// }
				} // Title */
			}
		}
?>

<?php
		$expolde_date = explode("-", $date);
		$date_new = $expolde_date[0] . "-" . $expolde_date[1] . "-" . $expolde_date[2];
		$date_month = $expolde_date[0];
		$query_value = "&date=" . $date_new;
		$key = $_GET['key'];
		$secret = $_GET['secret'];
		$query_value = "&date=" . $date_new;
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
		foreach($Row as $key => $value) {
			if ($value['RowType'] == "Header") {
				$cellheader = $value['Cells']['Cell'];
				foreach($cellheader as $key => $cellexpands) {
					if (isset($cellexpands['Value'])) {
					}
				}
			}
			elseif (isset($value['Rows'])) {
				if (isset($value['Title'])) {
					$getRow = $value['Rows']['Row'];
					foreach($getRow as $key => $cellvalue) {
						if (isset($cellvalue['RowType'])) {
							if ($cellvalue['RowType'] == "Row") {
								$getCells = $cellvalue['Cells']['Cell'];
								$count_td = 1;
								foreach($getCells as $key => $cellvaluesmany) {
									$count_td++;
									if ($count_td != 4 && $count_td != 2) {
										if (isset($cellvaluesmany['Value'])) {
											$data = array(
												"section" => $value['Title'],
												"account" => "",
												"amount_ytd" => "",
												"client" => $client,
												"add_by" => $this->session->userdata('user_session') ,
												"date" => sprintf("%02d", $expolde_date[0]) . "/" . $expolde_date[1] . "/" . $expolde_date[2],
												"month" => sprintf("%02d", $expolde_date[0]) ,
												"day" => $expolde_date[1],
												"year" => $expolde_date[2],
												"reference" => $client . "-" .  $timestamp ,
												"amount" => $cellvaluesmany['Value']
											);
											$this->db->insert('balance_sheet_data_logs', $data);
										}
										else {
										}
									}
								}
							}
						}
					}
					// }
				} // Title */
			}
		}


    $expolde_date = explode("-", $date);
    $date_new = $expolde_date[0]-2 . "-" . $expolde_date[1] . "-" . $expolde_date[2];
    $date_month = $expolde_date[0];
    $query_value = "&date=" . $date_new;
    $key = $_GET['key'];
    $secret = $_GET['secret'];
    $query_value = "&date=" . $date_new;
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
    foreach($Row as $key => $value) {
      if ($value['RowType'] == "Header") {
        $cellheader = $value['Cells']['Cell'];
        foreach($cellheader as $key => $cellexpands) {
          if (isset($cellexpands['Value'])) {
          }
        }
      }
      elseif (isset($value['Rows'])) {
        if (isset($value['Title'])) {
          $getRow = $value['Rows']['Row'];
          foreach($getRow as $key => $cellvalue) {
            if (isset($cellvalue['RowType'])) {
              if ($cellvalue['RowType'] == "Row") {
                $getCells = $cellvalue['Cells']['Cell'];
                $count_td = 1;
                foreach($getCells as $key => $cellvaluesmany) {
                  $count_td++;
                  if ($count_td != 4 && $count_td != 2) {
                    if (isset($cellvaluesmany['Value'])) {
                      $data = array(
                        "section" => $value['Title'],
                        "account" => "",
                        "amount_ytd" => "",
                        "client" => $client,
                        "add_by" => $this->session->userdata('user_session') ,
                        "date" => sprintf("%02d", $expolde_date[0]-2) . "/" . $expolde_date[1] . "/" . $expolde_date[2],
                        "month" => sprintf("%02d", $expolde_date[0]-2) ,
                        "day" => $expolde_date[1],
                        "year" => $expolde_date[2],
                        "reference" => $client . "-" . $timestamp,
                        "amount" => $cellvaluesmany['Value']
                      );
                      $this->db->insert('balance_sheet_data_logs', $data);
                    }
                    else {
                    }
                  }
                }
              }
            }
          }
          // }
        } // Title */
      }
    }

    $expolde_date = explode("-", $date);
    $date_new = $expolde_date[0]-3 . "-" . $expolde_date[1] . "-" . $expolde_date[2];
    $date_month = $expolde_date[0];
    $query_value = "&date=" . $date_new;
    $key = $_GET['key'];
    $secret = $_GET['secret'];
    $query_value = "&date=" . $date_new;
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
    foreach($Row as $key => $value) {
      if ($value['RowType'] == "Header") {
        $cellheader = $value['Cells']['Cell'];
        foreach($cellheader as $key => $cellexpands) {
          if (isset($cellexpands['Value'])) {
          }
        }
      }
      elseif (isset($value['Rows'])) {
        if (isset($value['Title'])) {
          $getRow = $value['Rows']['Row'];
          foreach($getRow as $key => $cellvalue) {
            if (isset($cellvalue['RowType'])) {
              if ($cellvalue['RowType'] == "Row") {
                $getCells = $cellvalue['Cells']['Cell'];
                $count_td = 1;
                foreach($getCells as $key => $cellvaluesmany) {
                  $count_td++;
                  if ($count_td != 4 && $count_td != 2) {
                    if (isset($cellvaluesmany['Value'])) {
                      $data = array(
                        "section" => $value['Title'],
                        "account" => "",
                        "amount_ytd" => "",
                        "client" => $client,
                        "add_by" => $this->session->userdata('user_session') ,
                        "date" => sprintf("%02d", $expolde_date[0]-3) . "/" . $expolde_date[1] . "/" . $expolde_date[2],
                        "month" => sprintf("%02d", $expolde_date[0]-3) ,
                        "day" => $expolde_date[1],
                        "year" => $expolde_date[2],
                        "reference" => $client . "-" . $timestamp ,
                        "amount" => $cellvaluesmany['Value']
                      );
                      $this->db->insert('balance_sheet_data_logs', $data);
                    }
                    else {
                    }
                  }
                }
              }
            }
          }
          // }
        } // Title */
      }
    }
    ob_start();
    ?>

    <table cellspacing="0" cellpadding="0" width="100%">
    <?php
     $date = sprintf("%02d", $expolde_date[0]) . "/" . $expolde_date[1] . "/" . $expolde_date[2];
     $date2 = sprintf("%02d", $expolde_date[0]-1) . "/" . $expolde_date[1] . "/" . $expolde_date[2];
     $date3 = sprintf("%02d", $expolde_date[0]-2) . "/" . $expolde_date[1] . "/" . $expolde_date[2];
     $date4 = sprintf("%02d", $expolde_date[0]-3) . "/" . $expolde_date[1] . "/" . $expolde_date[2];

    $queryvalue = $this->db->query("SELECT ID,reference, date FROM balance_sheet_data_logs where client='$client' GROUP BY reference ORDER BY ID DESC LIMIT 1");
    $data_value = $queryvalue->result();

    foreach ($data_value as $key_cvalue) {
         $reference = $key_cvalue->reference;
    }

     $query = $this->db->query("SELECT MY_DATA.*, b.date,
       SUM(CASE WHEN b.amount>=0
       THEN b.amount ELSE 0 END) as secondPostiveTotal,
       SUM(CASE WHEN b.amount<0
       THEN b.amount ELSE 0 END) as secondNegativeTotal,

       c.date,
         SUM(CASE WHEN c.amount>=0
         THEN c.amount ELSE 0 END) as thirdPostiveTotal,
         SUM(CASE WHEN c.amount<0
         THEN c.amount ELSE 0 END) as thirdNegativeTotal,

         d.date,
           SUM(CASE WHEN c.amount>=0
           THEN c.amount ELSE 0 END) as fourthPostiveTotal,
           SUM(CASE WHEN c.amount<0
           THEN c.amount ELSE 0 END) as fourthNegativeTotal

       FROM(SELECT date,section,
       SUM(CASE WHEN amount<0 THEN amount ELSE 0 END) as NegativeTotal,
       SUM(CASE WHEN amount>=0 THEN amount ELSE 0 END) as PostiveTotal

       FROM balance_sheet_data_logs
       where date='$date' and client='$client' and reference='$reference'   GROUP BY section) as MY_DATA


         LEFT JOIN(SELECT amount,date,section,SUM(CASE WHEN amount<0
         THEN amount ELSE 0 END) as NegativeTotal,SUM(CASE WHEN amount>=0
         THEN amount ELSE 0 END) as PostiveTotal FROM balance_sheet_data_logs
         where date='$date2' and client='$client' and reference='$reference'  GROUP BY section) as b
         on MY_DATA.section = b.section

         LEFT JOIN(SELECT amount,date,section,SUM(CASE WHEN amount<0
         THEN amount ELSE 0 END) as NegativeTotal,SUM(CASE WHEN amount>=0
         THEN amount ELSE 0 END) as PostiveTotal FROM balance_sheet_data_logs
         where date='$date3' and client='$client' and reference='$reference'  GROUP BY section) as c
         on MY_DATA.section = c.section

         LEFT JOIN(SELECT amount,date,section,SUM(CASE WHEN amount<0
         THEN amount ELSE 0 END) as NegativeTotal,SUM(CASE WHEN amount>=0
         THEN amount ELSE 0 END) as PostiveTotal FROM balance_sheet_data_logs
         where date='$date4' and client='$client' and reference='$reference'  GROUP BY section) as d
         on MY_DATA.section = d.section

         GROUP BY MY_DATA.section");
     $total1 = 0;
     $total2 = 0;
     $total3 = 0;
     $total4 = 0;
     $data = $query->result();
     ?>
     <tr>
        <td colspan="5" align="center" style="font-size:20px; font-weight:bold;">  Statements of Financial Position</td>
     </tr>
     <tr>
        <td colspan="5" align="center" style="font-size:20px; font-weight:bold;">  as of <?php echo $date;?> </td>
     </tr>
     <tr>
       <th>ASSETS </td>
       <th><?php echo $this->calendar_caption($expolde_date[0]-3)." ". $expolde_date[2]; ?></td>
       <th><?php echo $this->calendar_caption($expolde_date[0]-2)." ". $expolde_date[2]; ?></td>
       <th><?php echo $this->calendar_caption($expolde_date[0]-1)." ". $expolde_date[2]; ?></td>
       <th><?php echo $this->calendar_caption($expolde_date[0])." ".$expolde_date[2]; ?></th>
     </tr>
     <?php
     foreach ($data as $key) {
     ?>
     <?php
     if($key->section == "Current Liabilities" || $key->section ==  "Equity" || $key->section == "Equity" || $key->section == "Non-Current Liabilities"){

       $total1 += $key->PostiveTotal - $key->NegativeTotal;
       $total2 += $key->secondPostiveTotal - $key->secondNegativeTotal;
       $total3 += $key->thirdPostiveTotal - $key->thirdNegativeTotal;
       $total4 +=  $key->fourthPostiveTotal - $key->fourthNegativeTotal;
      ?>
        <tr>
            <td style="padding-left:15px;"><?php echo $key->section; ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->fourthPostiveTotal - $key->fourthNegativeTotal, 2); ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->thirdPostiveTotal - $key->thirdNegativeTotal, 2); ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->secondPostiveTotal - $key->secondNegativeTotal, 2); ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->PostiveTotal - $key->NegativeTotal, 2); ?></td>

        </tr>
    <?php
    }
     ?>
    <?php
  }//
     ?>
     <tr>
        <td style="font-weight:bold;">TOTAL</td>
        <td style="font-weight:bold;"><?php echo $total4; ?></td>
        <td style="font-weight:bold;"><?php echo $total3; ?></td>
        <td style="font-weight:bold;"><?php echo $total2; ?></td>
        <td style="font-weight:bold;"><?php echo $total1; ?></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <th>LIABILITIES AND NET ASSETS  </td>
       <th>&nbsp;</td>
       <th>&nbsp;</td>
       <th>&nbsp;</td>
       <th>&nbsp;</th>
     </tr>
     <?php
     foreach ($data as $key) {
     ?>
     <?php
     if($key->section == "Cash and Cash Equivalents" || $key->section ==  "Current Assets" || $key->section == "Property, Plant and Equipment"){

       $total1 += $key->PostiveTotal - $key->NegativeTotal;
       $total2 += $key->secondPostiveTotal - $key->secondNegativeTotal;
       $total3 += $key->thirdPostiveTotal - $key->thirdNegativeTotal;
       $total4 +=  $key->fourthPostiveTotal - $key->fourthNegativeTotal;
      ?>
        <tr>
            <td style="padding-left:15px;"><?php echo $key->section; ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->fourthPostiveTotal - $key->fourthNegativeTotal, 2); ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->thirdPostiveTotal - $key->thirdNegativeTotal, 2); ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->secondPostiveTotal - $key->secondNegativeTotal, 2); ?></td>
            <td style="padding-left:15px;"><?php echo number_format($key->PostiveTotal - $key->NegativeTotal, 2); ?></td>

        </tr>
    <?php
    }
     ?>
    <?php
  }//
     ?>
     <tr>
        <td style="font-weight:bold;">TOTAL</td>
        <td style="font-weight:bold;"><?php echo $total4; ?></td>
        <td style="font-weight:bold;"><?php echo $total3; ?></td>
        <td style="font-weight:bold;"><?php echo $total2; ?></td>
        <td style="font-weight:bold;"><?php echo $total1; ?></td>
     </tr>

    </table>
    <?php
    $html = ob_get_clean();
    return $html;
  }
	}
	function find_report($id, $query)
	{
		//  $query = "&date=2018-09-31";
		// explode($query)
		$query_value = "&date=" . $query;
		// $key = $this->session->userdata('key');
		// $secret = $this->session->userdata('secret');
		$key = $_GET['key'];
		$secret = $_GET['secret'];
		$endpoint = "?key=" . $key . "&secret=" . $secret . $query_value;
		if ($id == 'TrialBalance') {
			$url = site_url('TrialBalance/connect' . $endpoint);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			$result = curl_exec($ch);
			curl_close($ch);
			$obj = json_decode($result, true);
			$ProviderName = $obj["ProviderName"];
			$ReportDate = $obj["Reports"]["Report"]["ReportDate"];
			$Row = $obj["Reports"]["Report"]["Rows"]["Row"];
			ob_start();
?>
         <table>
            <tr>
              <td align="center" style= "font-family: helvetica !important;"><h1>Trial Balance</h2></td>
              </tr>
         </table>
         <table class="table table-responsive" style= "font-family: helvetica !important;">
        <?php
			foreach($Row as $key => $value) {
				if ($value['RowType'] == "Header") {
					$cellheader = $value['Cells']['Cell'];
?>
        <tr class="<?php
					echo $value['RowType'];
?>">
        <td style="border-bottom:1px solid black;" ><font size="9">Account Type</font></td>
        <?php
					foreach($cellheader as $key => $cellexpand) {
?>
        <td style="border-bottom:1px solid black;"><?php
						echo $cellexpand['Value'];
?></td>
        <?php
					}
?>

        </tr>
        <?php
				}
				elseif (isset($value['Title'])) {
					$getRow = $value['Rows']['Row'];
					foreach($getRow as $key => $cellvalue) {
						if ($cellvalue['RowType'] == "Row") {
							$getCells = $cellvalue['Cells']['Cell'];
							echo "<tr>";
							echo "<td>" . $value['Title'] . "</td>";
							foreach($getCells as $key => $cellvaluesmany) {
								if (isset($cellvaluesmany['Value'])) {
									echo "<td><font size='1'>" . $cellvaluesmany['Value'] . "</font></td>";
								}
								else {
									echo "<td>-</td>";
								}
							}
							echo "</tr>";
						}
					}
				}
				else {
?>
        <tr>
        <td>&nbsp;</td>
        <?php
					$celltotal = $value['Rows']['Row']['Cells']['Cell'];
					foreach($celltotal as $key => $cellprint) {
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
		}
		elseif ($id == 'ProfitAndLost') {
			$query_value = "&date=" . $query;
			$endpoint = "?key=" . $key . "&secret=" . $secret . $query_value;
			$url = site_url('ProfitAndLost/connect' . $endpoint);
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
			// ob_start();
			ob_start();
?>
      <table>
         <tr>
           <td align="center" style= "font-family: helvetica !important;"><h1>Profit and Lost</h2></td>
        </tr>
        <tr>
            <td></td>
        </tr>
      </table>
      <table width="100%" cellSpacing="0" cellpadding="0" style= "font-family: helvetica !important;">
      <?php
			foreach($Row as $key => $value) {
				if ($value['RowType'] == "Header") {
					$cellheader = $value['Cells']['Cell'];
?>
        <tr>
            <td>Section</td>
            <td>Account</td>
            <td>Amount</td>
            <td>YTD</td>
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
				elseif (isset($value['Rows'])) {
					$getRow = $value['Rows']['Row'];
					foreach($getRow as $key => $cellvalue) {
						if (isset($cellvalue['RowType'])) {
							if ($cellvalue['RowType'] == "Row") {
								$getCells = $cellvalue['Cells']['Cell'];
								echo "<tr>";
								echo "<td>" . $value['Title'] . "</td>";
								foreach($getCells as $key => $cellvaluesmany) {
									if (isset($cellvaluesmany['Value'])) {
										echo "<td>" . $cellvaluesmany['Value'] . "</td>";
									}
									else {
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
		}
		elseif ($id == 'BudgetSummary') {
			$query_value = "&date=" . $query;
			$endpoint = "?key=" . $key . "&secret=" . $secret . $query_value;
			$url = site_url('BudgetSummary/connect' . $endpoint);
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
			ob_start();
?>
         <table>
            <tr>
              <td align="center" style= "font-family: helvetica !important;"><h1>Budget Summary</h2></td>
              </tr>
              <tr>
                  <td></td>
              </tr>
         </table>
         <br />
         <table width="100%" cellSpacing="0" cellpadding="0" style= "font-family: helvetica !important;">
         <?php
			foreach($Row as $key => $value) {
				if ($value['RowType'] == "Header") {
					$cellheader = $value['Cells']['Cell'];
?>
           <tr>

             <?php
					foreach($cellheader as $key => $cellexpands) {
?>
             <?php
						if (isset($cellexpands['Value'])) {
?>
                     <td><?php
							echo $cellexpands['Value']; ?></td>
             <?php
						}
?>
             <?php
					}
?>
           </tr>
           <?php
				}
				elseif ($value['RowType'] == "Section") {
					$getRow = $value['Rows']['Row'];
					foreach($getRow as $key => $rows) {
						$cellcount = $getRow['Cells']['Cell'];
?>

               <tr>
                 <?php
						foreach($cellcount as $key => $cellprint) {
							echo "<td>" . $cellprint['Value'] . "</td>";
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
		}
		elseif ($id == 'BalanceSheet') {
			/*
			$query_value = "&date=".$query;
			$key = $this->session->userdata('key');
			$secret = $this->session->userdata('secret');
			$endpoint = "?key=".$key."&secret=".$secret.$query_value;
			*/
			$query_value = "&date=" . $query;
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
				elseif (isset($value['Rows'])) {
					$getRow = $value['Rows']['Row'];
					foreach($getRow as $key => $cellvalue) {
						if (isset($cellvalue['RowType'])) {
							if ($cellvalue['RowType'] == "Row") {
								$getCells = $cellvalue['Cells']['Cell'];
								echo "<tr>";
								echo "<td >" . $value['Title'] . "</td>";
								foreach($getCells as $key => $cellvaluesmany) {
									if (isset($cellvaluesmany['Value'])) {
										echo "<td>" . $cellvaluesmany['Value'] . "</td>";
									}
									else {
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
		}
		elseif ($id == 'Title') {
			$query_value = "&date=" . $query;
			$endpoint = "?key=" . $key . "&secret=" . $secret . $query_value;
			$url = site_url('AR/connect' . $endpoint);
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_URL, $url);
			$result = curl_exec($ch);
			curl_close($ch);
			$obj = json_decode($result, true);
			$ReportName = $obj["ProviderName"];
			$ReportDate = $obj["Reports"]["Report"]["ReportDate"];
			$Row = $obj["Reports"]["Report"]["Rows"]["Row"];
			$html = $ReportName;
?>
<?php
		}
		else {
			$html = $id;
		}
		return $html;
	}
	function update_template($id, $data)
	{
		$query = $this->db->query('SELECT * FROM template_db WHERE template_name="' . $data['template_name'] . '" and ID != "' . $id . '"');
		$count = $query->num_rows();
		if ($count == 0) {
			$validation = 'success';
			$this->db->where('ID', $id);
			$this->db->update('template_db', $data);
		}
		else {
			$validation = 'exist';
		}
		return $validation = $validation;
	}
	function pc_info()
	{
		$computerId = $_SERVER['HTTP_USER_AGENT'] . $_SERVER['LOCAL_ADDR'] . $_SERVER['LOCAL_PORT'] . $_SERVER['REMOTE_ADDR'];
		return $computerId;
	}
	function list_template()
	{
		return $this->db->query('SELECT * FROM template_db');
	}
	function page_list_select($id)
	{
		return $this->db->query("
SELECT * FROM layout_pages_tbl as a LEFT JOIN(SELECT * FROM page_content_details_tbl) as b ON a.ID = b.layout_page_id where page_template='" . $id . "' and status='Active' ORDER BY sort");
	}
	function counttemplate()
	{
		$query = $this->db->query('SELECT * FROM template_db');
		$count = $query->num_rows();
		return $count;
	}
	function add_templates($data)
	{
		$validation = $data['template_name'];
		$query = $this->db->query('SELECT * FROM template_db WHERE template_name="' . $validation . '"');
		$count = $query->num_rows();
		if ($count == 0) {
			$this->db->insert('template_db', $data);
			$validation = 'success';
		}
		else {
			$validation = 'exist';
		}
		return $validation;
	}
	function add_layout($data)
	{
		$validation = $data['page_title'];
		$template_id = $data['template_id'];
		$query = $this->db->query('SELECT * FROM layout_pages_tbl WHERE page_title="' . $validation . '" and template_id="' . $template_id . '"');
		$count = $query->num_rows();
		if ($count == 0) {
			$this->db->insert('layout_pages_tbl', $data);
			$validation = 'success';
		}
		else {
			$validation = 'exist';
		}
		return $validation;
	}
	function add_tagged_group($data)
	{
		return $this->db->insert('tag_group', $data);
	}
	function delete_tagged_group($data)
	{
		$this->db->where($data);
		return $this->db->delete('tag_group');
	}
	function delete_profile($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete('employee_info');
	}
	function delete_calendar($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete('events_tbl');
	}
	function delete_template($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete('template_db');
	}
	function delete_pdf($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete('pdf_files_tbl');
	}
	function pagination($limit, $pages, $total)
	{
		$set_val = $limit;
		$i_value = floor($total / $set_val);
		$i_remainder = $total % $set_val;
		if ($i_remainder != 0) {
			$total_value_loop = $i_value + 1;
		}
		else {
			$total_value_loop = $i_value;
		}
		$prev = $pages - 1;
		$next = $pages + 1;
		$to = $pages * $set_val;
		$from = $to - $set_val + 1;
		if (strlen($pages) == "" || $pages == 0 || $pages == 1) {
			$prev = "";
		}
		else {
			$prev = " <a href='" . site_url("Users/page/" . $prev) . "'>&laquo;</a>";
		}
		$page_number = "";
		for ($x = 1; $x <= $total_value_loop; $x++) {
			if ($x == $pages) {
				$class = "class='active'";
			}
			else {
				$class = "class=''";
			}
			$page_number = $page_number . "<a href='" . site_url('Users/page/' . $x) . "' " . $class . ">" . $x . "</a>";
		}
		if ($total_value_loop == $pages) {
			$next = "";
		}
		else {
			$next = "<a href='" . base_url("Users/page/" . $next) . "'>&raquo;</a>";
		}
		$bind_pagination = $prev . $page_number . $next;
		return $bind_pagination;
	}
	function calendar_caption($data)
	{
		$label = "";
		if ($data == '1' || $data == '01') {
			$label = "Jan";
		}
		elseif ($data == '2' || $data == '02') {
			$label = "Feb";
		}
		elseif ($data == '3' || $data == '03') {
			$label = "Mar";
		}
		elseif ($data == '4' || $data == '04') {
			$label = "Apr";
		}
		elseif ($data == '5' || $data == '05') {
			$label = "May";
		}
		elseif ($data == '6' || $data == '06') {
			$label = "Jun";
		}
		elseif ($data == '7' || $data == '07') {
			$label = "Jul";
		}
		elseif ($data == '8') {
			$label = "Aug";
		}
		elseif ($data == '9' || $data == '09') {
			$label = "Sep";
		}
		elseif ($data == '10') {
			$label = "Oct";
		}
		elseif ($data == '11') {
			$label = "Nov";
		}
		elseif ($data == '12') {
			$label = "Dec";
		}
		else {
			$label = "";
		}
		return $label;
	}
	function calendar_caption_full($data)
	{
		$label = "";
		if ($data == '1' || $data == '01') {
			$label = "January";
		}
		elseif ($data == '2' || $data == '02') {
			$label = "February";
		}
		elseif ($data == '3' || $data == '03') {
			$label = "March";
		}
		elseif ($data == '4' || $data == '04') {
			$label = "April";
		}
		elseif ($data == '5' || $data == '05') {
			$label = "May";
		}
		elseif ($data == '6' || $data == '06') {
			$label = "June";
		}
		elseif ($data == '7' || $data == '07') {
			$label = "July";
		}
		elseif ($data == '8') {
			$label = "August";
		}
		elseif ($data == '9' || $data == '09') {
			$label = "September";
		}
		elseif ($data == '10') {
			$label = "October";
		}
		elseif ($data == '11') {
			$label = "November";
		}
		elseif ($data == '12') {
			$label = "December";
		}
		else {
			$label = "";
		}
		return $label;
	}
	function get_color($data)
	{
		if ($data == '1') {
			$color = "#1abc9c";
		}
		elseif ($data == '2') {
			$color = "#498db";
		}
		elseif ($data == '3') {
			$color = "#9b59b6";
		}
		elseif ($data == '4') {
			$color = "#5c6270";
		}
		elseif ($data == '5') {
			$color = "#e67e22";
		}
		elseif ($data == '6') {
			$color = "#E9D460";
		}
		else {
			$color = "";
		}
		return $color;
	}
	function get_events_per_month($month, $year)
	{
		return $this->db->query("SELECT * FROM events_tbl where month='$month' and year='$year' order by day");
	}
	function login_script($data)
	{
		return $this->db->query("SELECT * FROM `user_info` WHERE email ='" . $data['email'] . "' and password='" . $data['password'] . "' ");
	}
	function events_json()
	{
		return $this->db->query("SELECT category as name, CONCAT(year , '-', month, '-', day) as date  FROM events_tbl");
	}
	function sessions($data)
	{
		$sql = "SELECT * FROM `employee_info` WHERE email ='" . $data['email'] . "' and password='" . $data['password'] . "' ";
		$query = $this->db->query($sql);
		return $query;
	}
	function model_update($id, $object)
	{
		$this->db->where('ID', $id);
		$this->db->update('employee_info', $object);
	}
	function update_status_page($id, $object)
	{
		$this->db->where('ID', $id);
		$this->db->update('layout_pages_tbl', $object);
	}
	function update_status_pdf($id, $object)
	{
		$this->db->where('ID', $id);
		$this->db->update('pdf_files_tbl', $object);
	}
	function sort_page($id, $object)
	{
		$this->db->where('ID', $id);
		$this->db->update('layout_pages_tbl', $object);
	}
	function model_delete_employee($id)
	{
		$this->db->where('ID', $id);
		$this->db->delete('employee_info');
	}
	function model_registration($data)
	{
		return $this->db->insert('employee_info', $data);
	}
	function add_events($data)
	{
		return $this->db->insert('events_tbl', $data);
	}
	function addpage($data)
	{
		$validation = $data['layout_page_id'];
		$this->db->where('layout_page_id', $validation);
		$this->db->delete('page_content_details_tbl');
		return $this->db->insert('page_content_details_tbl', $data);
	}
	function update_events($id, $object)
	{
		$this->db->where('ID', $id);
		$this->db->update('events_tbl', $object);
	}
	function model_get_id()
	{
		return $this->db->query('SELECT ID FROM employee_info ORDER BY `employee_info`.`ID` DESC LIMIT 1');
	}
	function get_page($id)
	{
		return $this->db->query("SELECT a.*, b.template_name FROM layout_pages_tbl as a LEFT JOIN(SELECT * FROM template_db) as b ON a.template_id = b.ID where a.ID='" . $id . "'");
	}
	function user_info()
	{
		// $setLimit = $this->max_row();
		// $srh = explode(" ", $this->keyword());
		// $pageLimit = ($this->page() * $setLimit) - ($setLimit);
		// $conditions = array();
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
	function template_list()
	{
		return $this->db->query('SELECT * FROM template_db LIMIT 5 ');
	}
	function rowData($table)
	{
		return $this->db->query('SELECT * FROM ' . $table . '');
	}
	function template_lists($limit)
	{
		return $this->db->query('SELECT * FROM template_db LIMIT ' . $limit);
	}
	function user_list()
	{
		return $this->db->query('SELECT * FROM employee_info ');
	}
	function user_info_list($filter)
	{
		return $this->db->query("SELECT * FROM employee_info where ID='" . $filter . "'");
	}
	function user_tag($filter)
	{
		return $this->db->query(" SELECT * FROM tag_group as a LEFT JOIN(SELECT * FROM user_group) as b ON a.group_id = b.GID where user_id='" . $filter . "' and LENGTH(group_name) != 0");
	}
	function calendar_info($filter)
	{
		return $this->db->query("SELECT * FROM events_tbl where ID='" . $filter . "'");
	}
	function events_category()
	{
		return $query = $this->db->query("SELECT * FROM events_category_tbl");
	}
	function location()
	{
		return $query = $this->db->query("SELECT * FROM location_tbl");
	}
	function count_users()
	{
		return $query = $this->db->query("SELECT count(*) as count FROM employee_info ");
	}
	function user_list_w_page($val, $val2, $val3)
	{
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
	function get_events($month, $year)
	{
		return $this->db->query("SELECT * FROM events_tbl where   month='" . $month . "' and year='" . $year . "'");
	}
	function password_validation($id, $password)
	{
		return $this->db->query("SELECT * FROM employee_info where   ID='" . $id . "' and password='" . $password . "'");
	}
	function get_event_today()
	{
		$day = date("d");
		$month = date("m");
		$year = date("Y");
		return $this->db->query("SELECT * FROM events_tbl where  month='$month ' and year='$year' ORDER BY day ASC ");
	}
	function get_event_today_manual($month, $year)
	{
		$query = $this->db->query("SELECT * FROM events_tbl where  month='$month' and year='$year' ORDER BY day ASC ");
		return $query->result();
	}
	function get_template_table()
	{
		return $this->db->query("SELECT * FROM layout_pages_tbl as a LEFT JOIN(SELECT * FROM page_content_details_tbl) as b ON a.ID = b.layout_page_id where status='Active' ORDER BY sort");
	}
	function users_list($value)
	{
		return $query = $this->db->query("SELECT * FROM user_info where email='" . $value . "'");
	}
	function client_group($value)
	{
		return $query = $this->db->query("SELECT * FROM xero_reports_access_tbl as a LEFT JOIN (SELECT * FROM xero_client_list_tbl) as b ON a.xero_client_id = b.ID where a.email='" . $value . "'");
	}
	function xero_client_individual($id)
	{
		return $query = $this->db->query("SELECT * FROM xero_client_list_tbl where ID='" . $id . "'");
	}
	function pdf_log($data)
	{
		return $this->db->insert('pdf_files_tbl', $data);
	}
	function get_pdf_files($client, $user)
	{
		return $query = $this->db->query("SELECT * FROM pdf_files_tbl where client_id='" . $client . "' and user='" . $user . "' ORDER BY ID DESC");
	}
	function get_pdf_files_num($client, $user)
	{
		$query = $this->db->query("SELECT * FROM pdf_files_tbl where client_id='" . $client . "' and user='" . $user . "' ");
		return $count = $query->num_rows();
	}
}
