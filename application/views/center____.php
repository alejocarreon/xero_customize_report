<?php $postid = strtotime('now') . rand(100, 999) ?>
<?php
$user = $this->Models->employee_info($this->session->userdata('user_session'));
$info = $user->result();
?>
<div class="col-6">
    <?php if ($this->Models->module_posting()) { ?>
       <div class="panel panel-post panel-main-post">
          <div class="panel-body">
             <div class="row">
                <div class="col-12 ">
                  <ul class="nav nav-tabs info-tabs">
                     <li class="nav-item">
                        <a class="nav-link active" href="#user-timeinput"><i class="fas fa-info"></i> Timeclock</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" href="#user-passaword"><i class="fas fa-key"></i> Timeclock Reports</a>
                     </li>
                  </ul>
                </div>
                <div class="tab-pane fade show active" id="user-timeinput" role="tabpanel">
                      <iframe src="<?php echo site_url("plugins/camera/index.php"); ?>">

                      </iframe>


                </div>

             </div>
             <form class="post-announcement-form" method="post">

             </form>

             <div class="link-preview-cont"></div>

             <div class="post-images" data-bind="<?php echo $postid ?>">
                <div class="row"></div>
             </div>
             <div class="post-videos" data-bind="<?php echo $postid ?>">
                <div class="row"></div>
             </div>
             <div class="post-tag-groups" data-tag="<?php echo $postid; ?>">

             </div>
          </div>
          <div class="panel-footer">
             <div class="row">

                <div class="col-12 text-right">

                </div>
             </div>
          </div>
       </div>
   <?php } ?>

</div>
