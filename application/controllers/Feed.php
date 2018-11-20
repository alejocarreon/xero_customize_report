<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Manila');
header('Content-Type: text/html; charset=utf-8');

class Feed extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('form_validation');
        $this->load->model('Modules');
        $this->load->model('Models');
        $this->load->library('session');
        $this->load->database();
    }

    function index() {
        redirect(site_url());
    }

    function link_preview() {
        $this->form_validation->set_rules('get_link', 'get_link', 'required');
        if ($this->form_validation->run()) {
            $html = '';
            $ch = @curl_init($this->input->post('get_link'));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $html = curl_exec($ch);
            echo $html;
            curl_close($ch);
        }
    }

    function _link_preview() {
        $this->form_validation->set_rules('get_link', 'get_link', 'required');
        if ($this->form_validation->run()) {
            $url = urldecode($this->input->post('get_link'));
            $url = 'http://' . str_replace('http://', '', $url);
            echo file_get_contents($url);
        }
    }

    function render_notification() {
        $this->form_validation->set_rules('notification', 'notification', 'required|numeric');
        if ($this->form_validation->run()) {
            $data = $this->Models->posted_announcement($this->input->post('notification'), 5);
            $post = $data->result();
            foreach ($post as $value) {
                $_user = $this->Models->employee_info($value->userid);
                $_info = $_user->result();
                ?>
                <li class="notification-message">
                   <a href="<?php echo site_url('announcement/id/' . $value->postid) ?>">
                      <strong><?php echo $_info[0]->first_name ?> <?php echo $_info[0]->last_name ?></strong>
                      <span class="muted pull-right"><?php echo $this->Models->time_range($value->date, strtotime('now')) ?></span>
                      <span class="post-notification-alert"><?php echo $this->Models->limit_text($this->Models->special_chars($value->post), 10) ?></span>
                   </a>
                </li>   
                <?php
            }
        }
    }

    function render_user_page() {
        $this->form_validation->set_rules('page', 'page', 'required|numeric');
        $this->form_validation->set_rules('keyword', 'keyword', 'required');
        if ($this->form_validation->run()) {
            $data = $this->Models->posted_announcement_user($this->input->post('keyword'), $this->input->post('page'), 5);
            $post = $data->result();
            foreach ($post as $value) {
                $_user = $this->Models->employee_info($value->userid);
                $_info = $_user->result();
                ?>
                <div class="panel panel-post" id="post-<?php echo $value->postid ?>">
                   <div class="panel-body">
                      <div class="row">
                         <div class="col-6 post-user">
                            <div class="post-user-float post-user-image-con">
                               <img data-bind="image-<?php echo $_info[0]->ID ?>" src="<?php echo ($_info[0]->profile_photo ? site_url('uploads/' . $_info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                            </div>
                            <div class="post-user-float ">
                               <a href="<?php echo site_url('announcement/user/' . $_info[0]->ID) ?>" class="user-announcement"><?php echo $_info[0]->first_name ?> <?php echo $_info[0]->last_name ?></a><br>
                               <span class="muted tooltip-title" title="<?php echo date("F d Y", $value->date) ?>"><?php echo $this->Models->time_range($value->date, strtotime('now')) ?></span>
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
        }
    }

    function render_search_pagination() {
        $this->form_validation->set_rules('page', 'page', 'required|numeric');
        $this->form_validation->set_rules('keyword', 'keyword', 'required');
        if ($this->form_validation->run()) {
            $data = $this->Models->search_posted_announcement($this->input->post('page'), 5, $this->input->post('keyword'));
            $post = $data->result();
            foreach ($post as $value) {
                $_user = $this->Models->employee_info($value->userid);
                $_info = $_user->result();
                ?>
                <div class="panel panel-post" id="post-<?php echo $value->postid ?>">
                   <div class="panel-body">
                      <div class="row">
                         <div class="col-6 post-user">
                            <div class="post-user-float post-user-image-con">
                               <img data-bind="image-<?php echo $_info[0]->ID ?>" src="<?php echo ($_info[0]->profile_photo ? site_url('uploads/' . $_info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                            </div>
                            <div class="post-user-float ">
                <?php echo $_info[0]->first_name ?> <?php echo $_info[0]->last_name ?><br>
                               <span class="muted tooltip-title" title="<?php echo date("F d Y", $value->date) ?>"><?php echo $this->Models->time_range($value->date, strtotime('now')) ?></span>
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
        }
    }

    function render_posted_pagination() {
        $this->form_validation->set_rules('page', 'page', 'required|numeric');
        if ($this->form_validation->run()) {
            $data = $this->Models->posted_announcement($this->input->post('page'), 5);
            $post = $data->result();
            foreach ($post as $value) {
                $_user = $this->Models->employee_info($value->userid);
                $_info = $_user->result();
                ?>
                <div class="panel panel-post" id="post-<?php echo $value->postid ?>">
                   <div class="panel-body">
                      <div class="row">
                         <div class="col-6 post-user">
                            <div class="post-user-float post-user-image-con">
                               <img data-bind="image-<?php echo $_info[0]->ID ?>" src="<?php echo ($_info[0]->profile_photo ? site_url('uploads/' . $_info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                            </div>
                            <div class="post-user-float ">
                               <a href="<?php echo site_url('announcement/user/' . $_info[0]->ID) ?>" class="user-announcement"><?php echo $_info[0]->first_name ?> <?php echo $_info[0]->last_name ?></a><br>
                               <span class="muted tooltip-title" title="<?php echo date("F d Y", $value->date) ?>"><?php echo $this->Models->time_range($value->date, strtotime('now')) ?></span>
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
        }
    }

    function render_posted_messege() {
        $this->form_validation->set_rules('get_id', 'get_id', 'required|numeric');
        if ($this->form_validation->run()) {
            $data = $this->Models->posted_announcement_id($this->input->post('get_id'));
            $post = $data->result();
            foreach ($post as $value) {
                $_user = $this->Models->employee_info($value->userid);
                $_info = $_user->result();
                ?>
                <div class="panel panel-post" id="post-<?php echo $value->postid ?>">
                   <div class="panel-body opacity-clear">
                      <div class="row">
                         <div class="col-6 post-user">
                            <div class="post-user-float post-user-image-con">
                               <img data-bind="image-<?php echo $_info[0]->ID ?>" src="<?php echo ($_info[0]->profile_photo ? site_url('uploads/' . $_info[0]->profile_photo) : site_url('images/profile.png')) ?>" class="post-user-image">
                            </div>
                            <div class="post-user-float ">
                               <a href="<?php echo site_url('announcement/user/' . $_info[0]->ID) ?>" class="user-announcement"><?php echo $_info[0]->first_name ?> <?php echo $_info[0]->last_name ?></a><br>
                               <span class="muted tooltip-title" title="<?php echo date("F d Y", $value->date) ?>"><?php echo $this->Models->time_range($value->date, strtotime('now')) ?></span>
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
                                    <div class="<?php echo $col ?>  cols">
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
                            <a href="<?php echo $value->postid; ?>" class="font-icon  tooltip-title like-icon<?php echo ($likeme->num_rows() ? ' icon-active' : '') ?>"  title="I LIKE THIS">
                               <i class="fa fa-thumbs-up" aria-hidden="true"></i> <span class="font-12 like"><?php echo $like->num_rows() ?></span>
                            </a>
                            <a href="<?php echo $value->postid; ?>" class="font-icon tooltip-title dislike-icon<?php echo ($dislikeme->num_rows() ? ' icon-active' : '') ?>"  title="I DISLIKE THIS">
                               <i class="fa fa-thumbs-down" aria-hidden="true"></i> <span class="font-12 dislike"><?php echo $dislike->num_rows() ?></span>
                            </a>
                         </div>
                      </div>   
                   </div>
                   <div class="panel-footer  hide">
                      <div class="row">
                         <div class="col-4">

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
        }
    }

    function search() {
        
    }

    function render_video_page() {
        $this->form_validation->set_rules('posted_videos_id', 'posted_videos_id', 'required|numeric');
        if ($this->form_validation->run()) {
            $data_video = $this->Models->posted_videos_id($this->input->post('posted_videos_id'));
            $post_video = $data_video->result();
            $post_num = $data_video->num_rows();
            if ($post_num > 0) {
                ?>
                <div class="col-12 video-output" >
                <?php
                foreach ($post_video as $video) {
                    echo $this->Models->getVideoDetails($video->video_url);
                }
                ?>
                </div>
                   <?php
               }
           } else {
               redirect(site_url());
           }
       }

   }
   