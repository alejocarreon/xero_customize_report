
<?php
$createdby  =   $this->session->userdata('user_session');

 ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Dashboard</h4>
                  <div class="row">
                    <?php
                    $user_session = $this->session->userdata('user_session');
                    $row = $this->Modules->client_group($user_session);
                    $data = $row->result();
                    foreach ($data as $key) {
                      $rowxx = $this->Modules->get_pdf_files_num($key->xero_client_id, $createdby);


                     ?>
             <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body" style="border: 1px solid #cecece;">
                  <div class="clearfix">
                    <div class="float-left">
                      <i class="fa fa-file-pdf-o text-danger icon-lg" style="font-size: 60px;"></i>
                    </div>
                    <div class="float-right">
                      <p class="mb-0 text-right"><?php echo $key->account_name; ?></p>
                      <div class="fluid-container">
                        <h3 class="font-weight-medium text-right mb-0"><?php echo $rowxx ; ?></h3>
                      </div>
                    </div>
                  </div>
                  <p class="text-muted mt-3 mb-0">
                  <button type="button" class="btn btn-outline-primary btn-rounded btn-fw" onclick="location.href='<?php echo site_url("Company/id/").$key->xero_client_id; ?>' "  >View</button>
                  </p>
                </div>
              </div>
            </div>
              <?php
              }
              ?>
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
