<?php $postid = strtotime('now') . rand(100, 999) ?>
<?php
if(!$this->Models->user_announcement()){
    redirect(site_url());
}
$user = $this->Models->employee_info($this->session->userdata('user_session'));
$info = $user->result();
?>
<div class="col-6">

   <div class="post-main-container" data-bind="user-page">
      <?php 
       $data = $this->Models->posted_announcement_user($this->Models->user_announcement(),0, 5);
       $post = $data->result();
       foreach ($post as $value) {
           $user = $this->Models->employee_info($value->userid);
           $info = $user->result();
           ?>
          <div class="panel panel-post" id="post-<?php echo $value->postid ?>">
             <div class="panel-body">
                <div class="row">
                   <div class="col-6 post-user">
                      <div class="post-user-float post-user-image-con">
                         <img data-bind="image-<?php echo $info[0]->ID ?>" src="<?php echo ($info[0]->profile_photo ? site_url('uploads/' . $info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                      </div>
                      <div class="post-user-float ">
                         <a href="<?php echo site_url('announcement/user/' . $info[0]->ID) ?>" class="user-announcement"><?php echo $info[0]->first_name ?> <?php echo $info[0]->last_name ?></a><br>
                         <div class="muted"><?php echo $this->Models->time_range($value->date, strtotime('now')) ?></div>
                      </div>
                   </div>
                   <div class="col-6 text-right">
                       <?php if ($this->Models->user_access($value->userid)) { ?>
                          <div class="dropdown">
                             <a class="btn btn-outline-secondary btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                             </a>
                             <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item edit-anno"  href="<?php echo $value->postid ?>"><i class="fas fa-edit"></i> Edit Text</a>
                                <a class="dropdown-item delete-anno"  href="<?php echo $value->postid ?>"><i class="fas fa-trash"></i> Delete</a>
                             </div>
                          </div>
                      <?php } ?>
                   </div>
                </div>
                <div class="announcement-messege" id="announcement<?php echo $value->postid ?>">
                   <div class="inner-content limit-text">
                      <div class="inner-post">
                          <?php echo $value->post ?>
                      </div>
                   </div>
                </div>
                <div class="post-images" data-bind="<?php echo $value->postid ?>">
                   <div class="posted-images row">
                       <?php
                       $data_images = $this->Models->posted_images($value->postid);
                       $post_images = $data_images->result();
                       $post_nm = $data_images->num_rows();
                       if ($post_nm === 1) {
                           $col = 'col-12';
                       } else if ($post_nm === 2) {
                           $col = 'col-6';
                       } else if ($post_nm === 3) {
                           $col = 'col-4';
                       } else {
                           $col = 'col-3';
                       }
                       if ($post_nm > 0) {
                           foreach ($post_images as $val) {
                               ?>
                              <div class="<?php echo $col ?> cols">
                                  <?php if ($this->Models->user_access($value->userid)) { ?>
                                     <a href="<?php echo $val->PID ?>" class="close"><i class="fa fa-times"></i></a>
                                 <?php } ?>
                                 <?php if ($post_nm === 1) { ?>    
                                 <a href="<?php echo site_url('uploads/' . $val->photo_folder . '/' . $val->photo_name) ?>" class="swipebox" target="_blank"> <img class="img-thumbnail" src="<?php echo site_url('uploads/' . $val->photo_folder . '/' . $val->photo_name) ?>"  data-fullsize="<?php echo site_url('uploads/' . $val->photo_folder . '/' . $val->photo_name) ?>" data-thumbnail="<?php echo site_url('uploads/' . $val->photo_folder . '/200x200_' . $val->photo_name) ?>"></a>
                                 <?php } else { ?>
                                 <a href="<?php echo site_url('uploads/' . $val->photo_folder . '/' . $val->photo_name) ?>" class="swipebox" target="_blank"> <img class="img-thumbnail" src="<?php echo site_url('uploads/' . $val->photo_folder . '/200x200_' . $val->photo_name) ?>" data-fullsize="<?php echo site_url('uploads/' . $val->photo_folder . '/' . $val->photo_name) ?>" data-thumbnail="<?php echo site_url('uploads/' . $val->photo_folder . '/200x200_' . $val->photo_name) ?>"></a>
                                 <?php } ?>
                              </div>    
                              <?php
                          }
                      }
                      ?>
                   </div>
                </div>
                <div class="post-videos"  data-bind="<?php echo $value->postid ?>">
                   <div class="row">
                       <?php
                       $data_video = $this->Models->posted_videos_id($value->postid);
                       $post_video = $data_video->result();
                       $post_num = $data_video->num_rows();
                       if ($post_num > 0) {
                           ?>
                          <div class="col-12">
                              <?php
                              foreach ($post_video as $video) {
                                  echo $this->Models->getVideoDetails($video->video_url);
                              }
                              ?>
                          </div>
                      <?php } ?>
                   </div>
                </div>
                <div class="post-tag-groups" data-tag="<?php echo $value->postid ?>">
                    <?php
                    $data_tagged = $this->Models->tagged_group($value->postid);
                    $post_tagged = $data_tagged->result();
                    $tagged_num = $data_tagged->num_rows();
                    if ($tagged_num > 0) {
                        ?>

                       <?php
                       foreach ($post_tagged as $tagged) {
                           ?>
                           <span class="badge badge-info"><?php echo $tagged->group_name ?></span>
                           <?php
                       }
                       ?>
                   <?php } ?>
                </div>
             </div>
             <div class="panel-footer">
                <div class="row">
                   <div class="col-4">
                       <?php if ($this->Models->user_access($value->userid)) { ?>
                          <a href="<?php echo $value->postid; ?>" title="ADD PHOTOS" class="font-icon attached-image tooltip-title"><i class="fas fa-images" aria-hidden="true"></i></a>
                          <a href="<?php echo $value->postid; ?>" title="ADD VIDEOS"  class="font-icon attached-video tooltip-title"><i class="fas fa-video" aria-hidden="true"></i></a>
                          <a href="<?php echo $value->postid; ?>" title="TAG YOUR TEAMATES" class="font-icon tag-group tooltip-title"><i class="fas fa-users" aria-hidden="true"></i></a>
                      <?php } ?>
                   </div>
                   <div class="col-8 text-right like-section">
                       <?php $like = $this->Models->check_like('like_post', $value->postid); ?>
                       <?php $dislike = $this->Models->check_like('dislike', $value->postid); ?>
                       <?php $likeme = $this->Models->me_like('like_post', $value->postid); ?>
                       <?php $dislikeme = $this->Models->me_like('dislike', $value->postid); ?>
                      <a href="<?php echo $value->postid; ?>" class="font-icon  tooltip-like like-icon<?php echo ($likeme->num_rows() ? ' icon-active' : '') ?>" title="<?php echo $this->Models->like_conversion($like->result()); ?>"  title="I LIKE THIS">
                         <i class="fa fa-thumbs-up" aria-hidden="true"></i> <span class="font-12 like"><?php echo $like->num_rows() ?></span>
                      </a>
                      <a href="<?php echo $value->postid; ?>" class="font-icon tooltip-like dislike-icon<?php echo ($dislikeme->num_rows() ? ' icon-active' : '') ?>" title="<?php echo $this->Models->like_conversion($dislike->result()); ?>"  title="I DISLIKE THIS">
                         <i class="fa fa-thumbs-down" aria-hidden="true"></i> <span class="font-12 dislike"><?php echo $dislike->num_rows() ?></span>
                      </a>
                   </div>
                </div>   
             </div>
          </div>
          <?php
      }
      ?>
   </div>
   <div class="page-loading"><div class="loading-page-item"><i class="fas fa-spinner fa-pulse"></i> Loading....</div></div>
</div>
<?php if ($this->Models->module_posting()) { ?> 
    <div class="modal modal-upload-images modal-medium">
       <div class="modal-dialog" role="document">
          <div class="modal-content">
             <a href="#close" class="close"><i class="fa fa-times"></i></a>
             <div class="modal-body">
                <div class="post-user">
                   <div class="post-user-float post-user-image-con">
                      <img data-bind="image-<?php echo $info[0]->ID ?>" src="<?php echo ($info[0]->profile_photo ? site_url('uploads/' . $info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                   </div>
                   <div class="post-user-float ">
                      <?php echo $info[0]->first_name ?> <?php echo $info[0]->last_name ?><br>
                      <div class="muted"><?php echo $info[0]->job_title ?></div>
                   </div>
                </div>
                <form class="drop-images form-group"  method="post" enctype="multipart/form-data">
                   <input type="hidden" class="hide get_upload_id" name="get_upload_id">
                   <input type="file" name="file[]" class="input-drop-images" multiple="" accept="image/x-png,image/gif,image/jpeg">
                   <div class="drop-here text-center">
                      Drop images here<br>
                      or<br>
                      <button class="btn btn-primary">Select Files</button>
                   </div>
                </form>
                <div class="progress hide progress-upload">
                   <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 1%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="modal modal-upload-video modal-medium">
       <div class="modal-dialog" role="document">
          <div class="modal-content">
             <a href="#close" class="close"><i class="fa fa-times"></i></a>
             <div class="modal-body">
                <div class="post-user">
                   <div class="post-user-float post-user-image-con">
                      <img data-bind="image-<?php echo $info[0]->ID ?>" src="<?php echo ($info[0]->profile_photo ? site_url('uploads/' . $info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                   </div>
                   <div class="post-user-float ">
                      <?php echo $info[0]->first_name ?> <?php echo $info[0]->last_name ?><br>
                      <div class="muted"><?php echo $info[0]->job_title ?></div>
                   </div>
                </div>
                <div class="form-group">
                   <form class="input-group" id="add-new-video">
                      <input type="text" class="form-control form-control-sm video-url" name="video_url" placeholder="https://www.youtube.com/watch?v=9pe0_Qj_PXY">
                      <input type="hidden" class="hide get_upload_id" name="get_upload_id">
                      <span class="input-group-btn">
                         <button type="submit" class="btn btn-info btn-sm">Add URL</button>
                      </span>
                   </form>
                </div>
                <div  class="list-group" id="">
                </div>
             </div>
          </div>
       </div>
    </div>
    <div class="modal modal-update-post modal-medium">
       <div class="modal-dialog" role="document">
          <form class="modal-content update-announcement-form">
             <a href="#close" class="close"><i class="fa fa-times"></i></a>
             <div class="modal-body ">
                <div class="form-group">
                   <div class="post-user">
                      <div class="post-user-float post-user-image-con">
                         <img data-bind="image-<?php echo $info[0]->ID ?>" src="<?php echo ($info[0]->profile_photo ? site_url('uploads/' . $info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                      </div>
                      <div class="post-user-float ">
                         <?php echo $info[0]->first_name ?> <?php echo $info[0]->last_name ?><br>
                         <div class="muted"><?php echo $info[0]->job_title ?></div>
                      </div>
                   </div>
                   <input type="hidden" class="hide id-announcement" name="get_id"  />
                   <textarea class="update-announcement-textarea form-control" name="update_announcement" id="update-announcement"></textarea>
                </div>
             </div>
             <div  class="modal-footer text-right" id="">
                <button class="btn btn-primary btn-sm update-post-announcement">Edit Announcement</button>
             </div>
          </form>
       </div>
    </div>
    <div class="modal modal-tag modal-medium">
       <div class="modal-dialog" role="document">
          <div class="modal-content tag-form">
             <a href="#close" class="close"><i class="fa fa-times"></i></a>
             <div class="modal-body ">
                <div class="form-group">
                   <div class="post-user">
                      <div class="post-user-float post-user-image-con">
                         <img data-bind="image-<?php echo $info[0]->ID ?>" src="<?php echo ($info[0]->profile_photo ? site_url('uploads/' . $info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                      </div>
                      <div class="post-user-float ">
                         <?php echo $info[0]->first_name ?> <?php echo $info[0]->last_name ?><br>
                         <div class="muted"><?php echo $info[0]->job_title ?></div>
                      </div>
                   </div>
                   <input type="hidden" class="hide id-tag-group" name="get_id"  />
                   <div class="tag-options">
                      <span class="span-tag"></span>
                      <div class="tag-selector"><input type="text" class="tag-input" placeholder="Type and select group name"/></div>
                      <div class="selected-option">
                         <ul class="hide"></ul>
                      </div>
                   </div>   
                </div>
             </div>
          </div>
       </div>
    </div>
    <?php
}?>