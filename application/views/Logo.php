
<?php
$createdby  =   $this->session->userdata('user_session');
 ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Client Logo</h4>
                  <div class="row">
                    <div class="panel-body">
                      <div class="input-group">

                           <input type='file' id="inputFile" />
                      </div>

                      <img id="image_upload_preview" src="<?php echo base_url("images/scrubbed.png"); ?>" alt="your image" width="30%" />

                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:partials/_footer.html -->
        <footer class="footer">
          <div class="container-fluid clearfix">
            <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright © 2018 Scrubbed.net
              </span>
            <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center">Scrubbed Reporting System v1.0
            </span>
          </div>
        </footer>
        <!-- partial -->
      </div>
