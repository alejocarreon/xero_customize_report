<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class PDFPage extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library('session');
        $this->load->database();
        $this->load->helper('form');
        $this->load->helper('url');
        $this->load->helper('cookie');
        $this->load->model('Modules');
        $this->load->model('Models');
    }
    function index() {


          $this->load->library('Pdf');
          $this->load->view('pdf');
        /*

           $old_limit = ini_set("memory_limit", "256M");
           $this->load->view('PDF');
           $this->load->library('Pdf');
           $this->pdf->load_view('PDF');

           $this->pdf->render();
           $this->pdf->stream("reservation.pdf", array("Attachment" => 0));
           $canvas =  $this->pdf->getCanvas();
                $canvas->page_script('$this->pdf->set_opacity(.5);$this->pdf->image("https://banner2.kisspng.com/20180420/soq/kisspng-postage-stamps-clip-art-draft-5ada04c738b019.3980996715242375112322.jpg", {x}, {y}, {w}, {h});');
                $this->pdf->setPaper('A4');

       */
   }

}
