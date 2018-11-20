<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Test extends CI_Controller
{
	public function __construct()
	{
		  parent::__construct();

	}

	public function index() {


		$config = array(
			'consumer'	=> array(
					////'key'		=> 'YKLU91MO3YOQGV5EUKWLYXOEMPBEEZ',
					///'secret'	=> 'QGWQQ1TTLTN3QFRVOUXS8AQPJRTVA8'
					'key'		=> '9URBCU0LBJGTEBEHIHR7ELV3QMYVS0',
					'secret'	=> '9RDSMHHI87VEXVSWV4J3YTS3YNLH7I'
				),
				'certs'		=> array(
					'private'  	=> APPPATH.'certs/private-key.pem',
					'public'  	=> APPPATH.'certs/public-key.cer'
				),
				'format'    => 'json'
		);


	$this->load->library('Xero');
			// automatically instantiates the Xero class with your key, secret
			// and paths to your RSA cert and key
			// according to the configuration options you defined in appication/config/xero.php


			// the input format for creating a new contact
			// see http://blog.xero.com/developer/api/contacts/ to understand more
			$new_contact = array(
				array(
					"Name" => "API TEST Contact",
					"FirstName" => "TEST",
					"LastName" => "Contact",
					"Addresses" => array(
						"Address" => array(
							array(
								"AddressType" => "POBOX",
								"AddressLine1" => "PO Box 100",
								"City" => "Someville",
								"PostalCode" => "3890"
							),
							array(
								"AddressType" => "STREET",
								"AddressLine1" => "1 Some Street",
								"City" => "Someville",
								"PostalCode" => "3890"
							)
						)
					)
				)
			);
			// create the contact
			$contact_result = $this->xero->Contacts($new_contact);

			// the input format for creating a new invoice (or credit note)
			// see [http://blog.xero.com/developer/api/invoices/]
			$new_invoice = array(
				array(
					"Type"=>"ACCREC",
					"Contact" => array(
						"Name" => "API TEST Contact"
					),
					"Date" => "2010-04-08",
					"DueDate" => "2010-04-30",
					"Status" => "AUTHORISED",
					"LineAmountTypes" => "Exclusive",
					"LineItems"=> array(
						"LineItem" => array(
							array(
								"Description" => "Just another test invoice",
								"Quantity" => "2.0000",
								"UnitAmount" => "250.00",
								"AccountCode" => "200"
							)
						)
					)
				)
			);
			// the input format for creating a new payment
			// see [http://blog.xero.com/developer/api/payments/] to understand more
			$new_payment = array(
				array(
					"Invoice" => array(
						"InvoiceNumber" => "INV-0002"
					),
					"Account" => array(
						"Code" => "[account code]"
					),
					"Date" => "2010-04-09",
					"Amount"=>"100.00",
				)
			);


			// raise an invoice
		//	$invoice_result = $this->xero->Invoices($new_invoice);

		//	$payment_result = $this->xero->Payments($new_payment);


			// get details of an account, with the name "Test Account"
			//
		//	$result = $this->xero->Contacts(false, false, array("Name"=>"Test Account"));
		$result = $this->xero->Reports();
			// the params above correspond to the "Optional params for GET Accounts"
			// on http://blog.xero.com/developer/api/accounts/

			// to do a POST request, the first and only param must be a
			// multidimensional array as shown above in $new_contact etc.

			// get details of all accounts
			$all_accounts = $this->xero->Accounts;

			// echo the results back

				// use this to see the source code if the $format option is "json" or not specified
				print json_encode($result, true) ;

		}

		public function get_pdf() {
			// first get an invoice number to use
			$org_invoices = $this->xero->Invoices;
			$invoice_count = sizeof($org_invoices->Invoices->Invoice);
			$invoice_index = rand(0,$invoice_count);
			$invoice_id = (string) $org_invoices->Invoices->Invoice[$invoice_index]->InvoiceID;
			if(!$invoice_id) {
				echo "You will need some invoices for this...";
			}

			// now retrieve that and display the pdf
			$pdf_invoice = $this->xero->Invoices($invoice_id, '', '', '', 'pdf');
			header('Content-type: application/pdf');
			header('Content-Disposition: inline; filename="the.pdf"');
			echo ($pdf_invoice);
		}
}
