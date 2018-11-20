
<form class="login userlogin" method="post" autocomplete="false" data-action="<?php echo site_url('response/login'); ?>">
    <div style="text-align: center">
        <img alt="toa" src="<?php echo site_url('images/cd-scrubbed.png'); ?>">
    </div>
    <div class="form-group">
        <label class="input-group input-add-group">
            <span class="input-group-addon"><i class="fa fa-user"></i></span>
            <input type="text" class="form-control" name="email_address" value="<?php echo $this->Module->remember_user(); ?>" placeholder="Email">
        </label>
    </div>
    <div class="form-group">
        <label class="input-group input-add-group">
            <span class="input-group-addon"><i class="fa fa-key" aria-hidden="true"></i></span>
            <input type="password" class="form-control" name="user_password" value="" placeholder="Password">
        </label>
    </div>
    <div class="checkbox">
        <div class="custom-input remember_me">
            <input type="checkbox" name="remember_me" value="1" id="remember"  <?php echo ($this->Module->remember() !== '') ? ' checked="checked " ' : ''; ?>><label for="remember">Remember me</label>
        </div>
    </div>
    <div class="form-group">
        <button class="btn btn-primary btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
    </div>
    <div class="form-group">
      		<a href="<?=$google_login_url?>" class="waves-effect waves-light btn red btn-block"><i class="fa fa-google left"></i>Google login</a>
    </div>
    <div class="output"></div>
</form>
