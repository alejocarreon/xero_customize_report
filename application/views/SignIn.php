<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
    <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
      <div class="row w-100">
        <div class="col-lg-4 mx-auto">
          <div class="auto-form-wrapper">
              <form class="login userlogin" method="post" autocomplete="false">
                <div  class="form-group" style="text-align:center;"><img src="<?php echo site_url(); ?>images/scrubbed-login-icon.png" style="width:220px"></div>
              <div class="form-group">
                <label class="label">Username</label>
                <div class="input-group">
                  <input type="text" class="form-control" name="email_address" required="" autofocus="" placeholder="Email">
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="label">Password</label>
                <div class="input-group">
                    <input type="password" class="form-control" name="user_password" value="" placeholder="Password">
                  <div class="input-group-append">
                    <span class="input-group-text">
                      <i class="mdi mdi-check-circle-outline"></i>
                    </span>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <button class="btn btn-primary submit-btn btn-block">Login</button>
              </div>

              <div class="form-group">
                  <a href="<?=$google_login_url?>" class="btn-block g-login"><i class="fa fa-google left"></i><img class="mr-3" src="../../images/file-icons/icon-google.svg" alt="">Login with Google</button></a>

              </div>
            
            </form>
          </div>
          <ul class="auth-footer">
            <li>
              <a href="#">Conditions</a>
            </li>
            <li>
              <a href="#">Help</a>
            </li>
            <li>
              <a href="#">Terms</a>
            </li>
          </ul>
          <p class="footer-text text-center">Version 1.0 copyright © 2018 Scrubbed IT Department. </p>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->
<!-- plugins:js -->
<div>
