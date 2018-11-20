<div class="content">
  <div class="container-fluid">
    <div class="widget grid6">
      <div class="widget-header">
        <div class="widget-title">
          <strong>
            <i class="fa fa-folder-open-o" aria-hidden="true">
            </i>Connection
          </strong>
        </div>
      </div>
      <!-- /widget-header -->
      <div class="widget-content">
        <div class="row">
          <div class='col-lg-5'>
            <form class="xero-connect-form"  method="">
              <?php
$key = $this->session->userdata('key');
if($key == ''){
?>
              <div class="input-group">
                <span class="input-group-addon"> Client Name
                </span>
                <input type="text" name="Clientname" class="form-control " placeholder="Enter Client Name">
              </div>
              <br>
              <div class="input-group">
                <span class="input-group-addon">API Key
                </span>
                <input type="text" name="APIKey" class="form-control APIKey" placeholder="Enter Key">
              </div>
              <br>
              <div class="input-group">
                <span class="input-group-addon">API Secret
                </span>
                <input type="text" name="APISecret" class="form-control APISecret" placeholder="Enter Secret">
              </div>
              <br>
              <div class="input-group right-box">
                <div class="right-box">
                  <input type="hidden" name="srchvalue" class="srchvalue" value="">
                  <input type="hidden" name="jsonvalue" class="jsonvalue" value="">
                  <button type="submit" class="btn btn-info xero-css" >Connect to Xero
                  </button>
                </div>
              </div>
              <?php
}else{
?>
              <div class="alert alert-success">
                <strong>You are now connected with Xero.
                </strong>
              </div>
              <div class="row">
                <div class="col-lg-12" style="text-align:right;">
                  <a class="btn btn-info disconnect-xero">Disconnect
                  </a>
                </div>
              </div>
              <?php
}
?>
            </form>
          </div>
        </div>
      </div>
      <div class="widget-footer">
        &nbsp;
      </div>
    </div>
  </div>
</div>
