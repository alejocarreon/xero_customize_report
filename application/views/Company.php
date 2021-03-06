
<?php
$id = $this->uri->segment('3');
$row = $this->Modules->xero_client_individual($id);
$data = $row->result();
foreach ($data as $key) {
    $template_idx = $key->template_id;
    $client = $key->account_name;
    //$key = $key->credentials;
//  $secret_txt = $key->sec_txt;
    $secrete = $key->secret;
    $key = $key->credentials;
}
//print_r($data);
$createdby = $this->session->userdata('user_session');

$date_text = isset($_POST['generate_report']) ? $_POST['generate_report'] : date("m/d/Y");


$rowxx = $this->Modules->get_pdf_files_num($id, $createdby);
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">My Company / <?php echo $client; ?></h5>
                <div class="fluid-container">
                    <form class="generate-report-form"  method="post">
                        <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3">
                            <div class="col-md-1">
                                <i class="fa fa-file-pdf-o text-danger icon-lg" style="font-size: 60px;"></i>
                            </div>
                            <div class="ticket-details col-md-6">
                                <div class="d-flex">
                                    <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">Total :</p>
                                    <p class="text-primary mr-1 mb-0"><?php echo $rowxx; ?></p>

                                </div>

                                <div class="row text-gray d-md-flex d-none">
                                    <div class="col-4 d-flex">
                                        <small class="mb-0 mr-2 text-muted text-muted">Last generated :</small>
                                        <small class="Last-responded mr-2 mb-0 text-muted text-muted">3 hours ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="ticket-actions col-md-3">
                                <div class="btn-group dropdown">
                                    <input type="hidden" name="key_txtfield" value="<?php echo $key; ?>" class="key_txtfield">
                                    <input type="hidden" name="secret_txtfield" value="<?php echo $secrete; ?>" class="secret_txtfield">
                                    <input type="hidden" name="client_id" value="<?php echo $id; ?>" class="client_id">
                                    <input type="hidden" name="template_id" value="<?php echo $template_idx; ?>" class="template_id">
                                    <input type="date" class="form-control" name="generate_report" value="<?php echo $date_text; ?>" id="reportdate" class="reportdate">
                                    <button type="submit" class="btn btn-primary btn-fw">Generate</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">

            <div class="col-lg-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <div class="widget-content body-filemanager">
                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="<?php echo site_url("Configuration/id/".$id); ?>" class="btn btn-inverse-secondary btn-fw" style="color:gray !important;padding:12px;"><i class="fa fa-plus-square-o"></i>Summary  Page</a>
                                </div>
                                <div class="col-lg-6">
                                    <input type="text" id="myInput" onkeyup="myFunction()" placeholder="Search Files" title="Type in a name">
                                </div>
                                <div class="col-lg-12">

                                    <div class="table-responsive">
                                        <form  method="post">
                                            <table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Filename</th>
                                                        <th>Time Generated</th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody tbody id="myTable">
                                                    <?php
                                                    $count = 0;
                                                    $rowx = $this->Modules->get_pdf_files($id, $createdby);
                                                    $datax = $rowx->result();
                                                    foreach ($datax as $keyx) {
                                                        $count++;
                                                        if ($keyx->status == "Final") {
                                                            $badge = "success";
                                                            $caption = "Finalized";
                                                        } else {
                                                            $badge = "warning";
                                                            $caption = "Report Draft";
                                                        }
                                                        ?>
                                                        <tr>
                                                            <td><?php echo $count; ?></td>
                                                            <td><a href="<?php echo site_url("application/views/pdf/" . $keyx->pdf_file); ?>"  target="_blank" title="<?php echo site_url("application/views/pdf/" . $keyx->pdf_file); ?>"><span><i class="fa fa-file-pdf-o" aria-hidden="true" style="color:red !important;"></i></span> <span class="name"><?php echo $keyx->pdf_file ?> </span><span style="font-size:11px;#f9f9f9 !important"> </span></a></td>
                                                            <td><?php echo $keyx->timestamp ?></td>
                                                            <td><label class="badge badge-<?php echo $badge; ?>"><?php echo $caption; ?></label></td>
                                                            <td>
                                                                <div class="dropdown">
                                                                    <button class="btn btn-block btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"><span class="caret"></span>
                                                                    </button>
                                                                    <ul class="dropdown-menu dropdown-menu-center" aria-labelledby="dropdownMenu1">
                                                                        <li style="padding: 2px;">&nbsp;<a class="finalize-report" data-id="<?php echo $keyx->ID; ?>">Save as Final</a></li>
                                                                        <li style="padding: 2px;">&nbsp;<a class="delete-report"  data-id-delete="<?php echo $keyx->ID; ?>">Delete</a></li>
                                                                    </ul>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                    }
                                                    ?>
                                                </tbody>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
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
                <i class="mdi mdi-heart text-danger"></i>
            </span>
        </div>
    </footer>
    <!-- partial -->
</div>
