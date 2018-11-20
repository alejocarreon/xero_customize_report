<?php
//$this->uri->segment(3)
?>
<html>
<head>
    <title> Reports</title>
    <meta name="site" content="<?php echo site_url(); ?>">
    <link rel="stylesheet" href="<?php echo site_url('css/reports.css') ?>" >
            <link rel="stylesheet" href="<?php  echo site_url('css/bootstrap.css');?>">
  	        <link rel="stylesheet" href="<?php  echo site_url('jquery-ui/jquery-ui.structure.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('jquery-ui/jquery-ui.theme.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/bootstrap-datetimepicker.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('assets/css/jquery.timepicker.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/font-awesome.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/pnotify.custom.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/pignose.calendar.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/swipebox.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('assets/css/select2.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/animate.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/owl.carousel.min.css');?>">
            <link rel="stylesheet" href="<?php  echo site_url('css/owl.theme.default.min.css');?>">
    <link rel="stylesheet" href="<?php echo site_url('assets/style?ver=1') ?>" >
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>

<script src='<?php echo site_url('assets/script/script.js?ver=1'); ?>'></script>

<script src="<?php echo site_url('js/jquery.dotdotdot.js'); ?>"></script>
<script src="<?php echo site_url('js/jquery.form.min.js'); ?>"></script>
<script src="<?php echo site_url('js/popper.min.js'); ?>"></script>
<script src="<?php echo site_url('js/fontawesome-all.min.js'); ?>"></script></script>
<script src="<?php echo site_url('js/bootstrap.min.js'); ?>"></script>
<script src="<?php echo site_url('jquery-ui/jquery-ui.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/confirm.js'); ?>"></script>
<script src="<?php echo site_url('js/moment.min.js'); ?>"></script>
<script src="<?php echo site_url('js/bootstrap-datetimepicker.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/jquery.timepicker.min.js'); ?>"></script>
<script src="<?php echo site_url('js/pignose.calendar.full.min.js'); ?>"></script>
<script src="<?php echo site_url('js/jquery.swipebox.min.js'); ?>"></script>
<script src="<?php echo site_url('js/pnotify.custom.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/select2.full.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/pubnub.4.19.0.min.js'); ?>"></script>
<script src="<?php echo site_url('js/owl.carousel.min.js'); ?>"></script>
<script src="<?php echo site_url('js/jquery.cropit.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/javascript.js'); ?>"></script>
<script src="<?php echo site_url('assets/js/script.js'); ?>"></script>
<script src="<?php echo site_url('js/snaptime.js'); ?>"></script>

</head>
</head>
<div class="container-fluid">
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <a class="navbar-brand" ><img src="<?php echo base_url("images/scrubbed-header.png"); ?>" alt="Scrubbed">
                </a>
            </div>
            <div id="navbar1" class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="#">Home</a></li>

                </ul>
            </div>
            <!--/.nav-collapse -->
        </div>
        <!--/.container-fluid -->
    </nav>
</div>
<body>
<div class="container-fluid">
  <div class="row">
      <div class="col-lg-3">
              <br>
              <form class="xero-connect-form"  method="">

                <br>
                <div class="panel-group">
                   <div class="panel panel-default">
                     <div class="panel-heading">
                       <h4 class="panel-title">
                         <a data-toggle="collapse" href="#connection">Connection</a>
                       </h4>
                     </div>
                     <div id="connection" class="panel-collapse collapse">
                       <div class="panel-body">
                         <div class="panel-body">
                           <div class="input-group">
                               <span class="input-group-addon"> Client Name </span>
                               <input type="text" name="Clientname" class="form-control " placeholder="Enter Client Name">
                           </div>
                           <div class="input-group">
                               <span class="input-group-addon">API Key</span>
                                 <input type="text" name="APIKey" class="form-control APIKey" placeholder="...">
                           </div>
                           <div class="input-group">
                               <span class="input-group-addon">API Secret</span>
                                 <input type="text" name="APISecret" class="form-control APISecret" placeholder="...">
                           </div>

                           <div class="input-group right-box">
                             <div class="right-box">
                             <input type="hidden" name="srchvalue" class="srchvalue" value="">
                             <input type="hidden" name="jsonvalue" class="jsonvalue" value="">
                                   <button type="submit" class="btn btn-default xero-css" >Connect to <img class="xero-button" src="https://cdn2.hubspot.net/hubfs/3965515/Xero-logo-hires-RGB.png"></button>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>
                 </div>



          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#clientinformation">Client Information</a>
                </h4>
              </div>
              <div id="clientinformation" class="panel-collapse collapse">
                <div class="panel-body">
                  <div class="input-group">
                      <span class="input-group-addon">Client Logo </span>
                       <input type='file' id="inputFile" />
                  </div>

                  <img id="image_upload_preview" src="<?php echo base_url("images/scrubbed.png"); ?>" alt="your image" width="100%" />

                </div>
              </div>
            </div>
          </div>
          <div class="panel-group">
            <div class="panel panel-default">
              <div class="panel-heading">
                <h4 class="panel-title">
                  <a data-toggle="collapse" href="#pagesettings">Page Settings</a>
                </h4>
              </div>
              <div id="pagesettings" class="panel-collapse collapse">
                <div class="panel-body">
                  <ul class="nav nav-tabs ">
                      <li class="active"><a data-toggle="tab" href="#home">Templates</a></li>
                      <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
                      <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
                      <li><a data-toggle="tab" href="#menu3">Menu 3</a></li>
                  </ul>

<div class="tab-content">
 <div id="home" class="tab-pane fade in active">
   <br>
   <br>
   <span>
        <button class="btn btn-default" data-toggle="modal" data-target="#createpage">Create New</button>
  <span>
<br>
<br>
   <table class="table table-bordered">
    <thead>
      <tr>
        <th>Template Name</th>
        <th>Action</th>

      </tr>
    </thead>
    <tbody class="templatelist">
      <?php
      $row = $this->Modules->template_list();
      $data = $row->result();
      foreach ($data as $key) {
      ?>
    <tr>
      <td><?php echo $key->template_name; ?></td>
      <td></td>
    </tr>
    <?php
  }
     ?>
    </tbody>
  </table>
 </div>
 <div id="menu1" class="tab-pane fade">
   <h3>Menu 1</h3>
   <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
 </div>
 <div id="menu2" class="tab-pane fade">
   <h3>Menu 2</h3>
   <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
 </div>
 <div id="menu3" class="tab-pane fade">
   <h3>Menu 3</h3>
   <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
 </div>
</div>
                </div>
              </div>
            </div>
          </div>


            </form>

      </div>
      <div class="col-lg-9">
        <div class="row hide validationdefault">
            <div class="validationConnection">
                  <div class="alert alert-success">
                       <strong>Success!</strong> you are now connected to Xero API.
                  </div>

            </div>
        </div>
        <div class="row pdfframe">

                <div class="col-lg-12">
                       <iframe width="100%" style="height :780px;" frameBorder="0" class="reportframe" src="<?php echo base_url('PDFPage'); ?>">

                       </iframe>
                </div>
        </div>

      </div>
  </div>
</div>

<d
iv class="modal fade createpage" id="createpage" role="dialog">
  <form class="createtemplate">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Template</h4>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                  <div class="input-group">
               <span class="input-group-addon">Name</span>
               <input type="text" class="form-control templatefield" placeholder="Enter Template Name" name="template">
           </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
    </div>
  </form>
</div>
<footer>
  <script>

      (function (j) {
          j(function () {
              EM.script.init();
              AM.script.init();
          });

      })(jQuery);

/*
          function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#image_upload_preview').attr('src', e.target.result);
            }


        }
    }
    */

  </script>

</footer>
</body>
</html>
