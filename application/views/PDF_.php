<?php
$date = "";
$image = $this->session->userdata('images_logo');
$imageData = base64_encode(file_get_contents($image));
$finfo = new finfo();
$fileinfo = $finfo->file($image, FILEINFO_MIME);
$src = 'data: '.$fileinfo.';base64,'.$imageData;
$src=str_replace(" ","",$src);
$jsonvalue = json_encode($this->session->userdata('jsonvalue'), true);
$de_jsonvalue = json_decode($jsonvalue);
 $date = 'August 30, 2018';
// $var = $jsonvalue[0];


$draft = site_url("images/draft.png");

 ob_start();  // turns on output buffering
 //print  $jsonvalue;
 ?>

<div class="container-fluid" style="background-image: url('<?php echo $draft; ?>');">
<div class="row">
    <div class="col-lg-2">
    </div>
    <div class="col-lg-8" style="text-align:center;">
      <img src="<?php echo  $src; ?>" style="width:240px; height:auto;">
    </div>
     <div class="col-lg-2">
    </div>
</div>
<div class="row">
    <div class="col-lg-2">
    </div>
    <div class="col-lg-8" style="text-align:left;">
      <p style="font-weight:bold; color:#214784;">Management Report</p>
       <p style="font-weight:light; ;"><?php echo $date; ?></p>
    </div>
     <div class="col-lg-2">
    </div>
</div>
</div>
 <?php
//ob_flush(); // send buffer output
$output = ob_get_clean();  // stores buffer contents to the variable


ob_start();  // turns on output buffering
//print  $jsonvalue;
?>
<table cellspacing="0" cellpadding="0" width="100%">
  <tr>
    <td><img src="<?php echo $src; ?>" style="width:200px;"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><span style="color:#003366;font-size: 30px; font-weight:bold; padding :15px;">Contents</span></td>
  </tr>


</table>
<hr>
<table>
  <tr>
    <td><div style="heigth:50px;"></div></td>
  </tr>
</table>
<table cellspacing="0" cellpadding="0" width="100%">

                <tr>
                    <td width="600" nowrap>Financial Dashboard and Narrative Report</td>
                    <td width="600" nowrap>1</td>
                </tr>
                <tr>
                    <td width="600" nowrap>Statements of Financial Position as of July 31, 2018</td>
                    <td width="600" nowrap>2</td>
                </tr>
                <tr>
                    <td width="600" nowrap>Budget vs. Actuals for the period ended July 31, 2018</td>
                    <td width="600" nowrap>3</td>
                </tr>
                <tr>
                    <td width="600" nowrap>Statement of Functional Expenses for the period ended July 31, 2018 </td>
                    <td width="600" nowrap>4</td>
                </tr>
                <tr>
                    <td width="600" nowrap>Statements of Cash Flows for the period ended July 31, 2018  </td>
                    <td width="600" nowrap>5</td>
                </tr>
                <tr>
                    <td width="600">Annexes </td>
                    <td width="600">6</td>
                </tr>


</table>

<?php
class MYPDF extends TCPDF {
    //Page header
    public function Header() {
        // get the current page break margin
        $bMargin = $this->getBreakMargin();
        // get current auto-page-break mode
        $auto_page_break = $this->AutoPageBreak;
        // disable auto-page-break
        $this->SetAutoPageBreak(false, 0);
        // set bacground image
        $img_file = $draft ;
        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
        // restore auto-page-break status
        $this->SetAutoPageBreak($auto_page_break, $bMargin);
        // set the starting point for the page content
        $this->setPageMark();
    }
}

//ob_flush(); // send buffer output
$pagetwo = ob_get_clean();  // stores buffer contents to the variable

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new MyCustomPDFWithWatermark(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
//$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Scrubbed.net');
$pdf->SetTitle('Xero Report');

$pdf->setPrintHeader(false);
$pdf->setPrintFooter(true);
// set default header data
//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage();

$html = $output ;

$pdf->writeHTML($html, true, false, true, false, '');
// add a page
$pdf->AddPage();

$html = $pagetwo;
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');
//
// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document
$pdf->AddPage();

$html = $pagetwo;
// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

//


// get the current page break margin
$bMargin = $pdf->getBreakMargin();
// get current auto-page-break mode
$auto_page_break = $pdf->getAutoPageBreak();
// disable auto-page-break
$pdf->SetAutoPageBreak(false, 0);
// set bacground image
$img_file = $draft;
$pdf->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);
// restore auto-page-break status
$pdf->SetAutoPageBreak($auto_page_break, $bMargin);
// set the starting point for the page content
$pdf->setPageMark();


// reset pointer to the last page
$pdf->lastPage();
//Close and output PDF document
ob_clean();
ob_flush();
$pdf->Output('example_007.pdf', 'I');
ob_end_flush();
ob_end_clean();
$pdf->SetLineStyle(array('width' => 0 / $this->k, 'cap' => 'butt', 'join' => 'miter', 'dash' => 0, 'color' => array(255, 255, 255)));
