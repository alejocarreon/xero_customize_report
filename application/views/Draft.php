<?php
//  echo  $this->Modules->template_reports("BalanceSheet", date('m-d-Y'), '5', '9URBCU0LBJGTEBEHIHR7ELV3QMYVS0', '9RDSMHHI87VEXVSWV4J3YTS3YNLH7I');

////$this->Modules->template_reports("BalanceSheet", date('m-d-Y'), '5', '9URBCU0LBJGTEBEHIHR7ELV3QMYVS0', '9RDSMHHI87VEXVSWV4J3YTS3YNLH7I');
//
//echo $this->Modules->trial_balance_library('Trial Balance' ,'5' , date('m-d-Y'), 'U3RBLDBESWZEWJQU8GNOKNKC93CHFR', 'HN1KQQSXSWEOANXQMUNT1UVDVG2FQ0');

//echo $this->Modules->template_reports('BalanceSheet' , date('m-d-Y'), '51','R6BRJI8YN4FFOHBO47A0QJAKIHXMEV', 'QVX4IAKKLIXYIKQBSJCQ2ICLMYCKCT', "6");
	//function get_balancesheet_report($id, $date, $client, $key, $secret, $months_needed){

  echo  $this->Modules->get_trial_balance('BalanceSheet' , "09-30-2018", '51','R6BRJI8YN4FFOHBO47A0QJAKIHXMEV', 'QVX4IAKKLIXYIKQBSJCQ2ICLMYCKCT', "6", "Sample Name");
  //function loop_trial_balance($id, $date, $client, $key, $secret, $timestamp);
  //$this->Modules->loop_trial_balance('BalanceSheet' , '06-09-2018', '51','R6BRJI8YN4FFOHBO47A0QJAKIHXMEV', 'QVX4IAKKLIXYIKQBSJCQ2ICLMYCKCT', "6", "Sample Name");

 ?>
