
<?php
$createdby = $this->session->userdata('user_session');
$id = $this->uri->segment('3');
$row = $this->Modules->xero_client_individual($id);
$data = $row->result();
foreach ($data as $key) {
    $template_idx = $key->template_id;
    $client = $key->account_name;
    $secrete = $key->secret;
    $key = $key->credentials;
}
$summary_value = $this->Modules->summary_page($id);
$data_summary = $summary_value->result();
foreach ($data_summary as $key) {
    $html_content = $key->html_content;
}
?>
<script src="https://tinymce.cachefly.net/4.2/tinymce.min.js" type="text/javascript"></script>
<div class="main-panel">

    <div class="content-wrapper">
        <form class="newpages" name="newpages"> 
            <div class="row">
                <div class="col-lg-12 grid-margin">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title"><a href="<?php echo site_url(); ?>">My Company</a>/<a href="<?php echo site_url("Company/id/" . $id); ?>"> <?php echo $client; ?></a>/ Summary Page</h4>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="row ticket-card mt-3 pb-2 border-bottom pb-3 mb-3">
                                <div class="col-md-1">
                                    <i class="fa fa-file-word-o text-info icon-lg" style="font-size: 60px;"></i>
                                </div>
                                <div class="ticket-details col-md-6">
                                    <div class="d-flex">
                                        <p class="text-dark font-weight-semibold mr-2 mb-0 no-wrap">Total :</p>
                                        <p class="text-primary mr-1 mb-0">0</p>

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
                                        <button type="submit" class="btn btn-success btn-new-page">Save</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-12 grid-margin ">
                    <p class="notification"></p>
                    <textarea name="content" class="newpage" cols="40" rows="20">
                        <?php echo $html_content; ?>
                    </textarea>
                </div> 
            </div>
        </form>
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
