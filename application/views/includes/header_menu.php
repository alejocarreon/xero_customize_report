<?php
$user = $this->Models->employee_info($this->session->userdata('user_session'));
$info = $user->result();
?>
<nav>
   <div class="main-nav">
      <div class="container">
         <div class="row">
            <div class="col-2">
               <a href="<?php echo site_url() ?>"><img src="<?php echo site_url('images/scrubbed-header.png') ?>" class="header_logo"></a>
            </div>
            <div class="col-5">
               <input type="text" class="intra-search-bar" placeholder="Search by user or announcement..." data-bind="<?php echo $this->Models->user_announcement() ?>" value="<?php echo $this->Models->keyword() ?>">
            </div>
            <div class="col-5">
               <ul class="nav-menu">
                  <li><a href="<?php echo site_url() ?>" class="home"><i class="fa fa-home"></i></a></li>

                  <li>
                     <a href="#" class="drop-down">
                        <span class="nav-row">
                           <span class="post-user-float post-user-image-con">
                              <img data-bind="image-<?php echo $info[0]->ID ?>"  src="<?php echo ($info[0]->profile_photo?site_url('uploads/'.$info[0]->profile_photo):site_url('images/profile.png')) ?>" class="post-user-image">
                           </span>
                           <span class="post-user-float">
                              <span class="text"><?php echo $info[0]->first_name ?> <?php echo $info[0]->last_name ?></span>
                              <span class="muted"><?php echo $info[0]->job_title ?></span>
                           </span>
                        </span>
                     </a>
                     <ul class="child-menu">
                        <li><a href="<?php echo site_url() ?>"><i class="fas fa-home"></i> Home</a></li>
                        <?php if ($this->Models->admin_only()) { ?>
                            <li><a href="<?php echo site_url('users') ?>"><i class="fas fa-users"></i> Users Profile</a></li>
                            <li><a href="<?php echo site_url('settings') ?>"><i class="fas fa-cogs"></i> Settings</a></li>
                        <?php } ?>
                        <li><a href="#" class="logout logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                     </ul>
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </div>
</nav>
