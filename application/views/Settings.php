<?php
  $user = $this->Module->session_username($this->session->userdata('user_session')); 
  $validation = $this->Module->info_type($this->session->userdata('user_session'));
?>
<div class="content">
    <div class="container-fluid">
        <div class="widget grid6">
            <div class="widget-header">
                <div class="widget-header">
                    <div class="widget-title">
                        <strong><i class="fa fa-gear" aria-hidden="true"></i>Settings
                        <?php
                        echo $validation = $this->Module->info_type($this->session->userdata('user_session'));
                        ?>
                        </strong>
                    </div>
                </div>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <?php
                     if ($validation == 1) {
                ?>
                <div class="row">
                    <div class="col-sm-3 text-left">
                        <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#createnew">Create Users</button>
                    </div>
                    <div class="col-sm-9 text-center">
                        <form method="get">
                            <input type="hidden" class="hide" name="page" value="1" >
                            <div class="input-group">
                                <input type="text" class="form-control" name="search" value="<?php echo $this->Module->keywords() ?>" placeholder="Search for...">
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="submit">Go!</button>
                                </span>
                            </div><!-- /input-group -->
                        </form>

                    </div>
                </div>
                <?php
                     }
                ?>
                <div class="folders">
                    <div class="table">
                        <div class="tr th">
                            <div class="td">First name</div>
                            <div class="td">Middle name</div>
                            <div class="td">Last name</div>
                            <div class="td">Position</div>
                            <div class="td">Email Address</div>
                            <div class="td">Reset Password</div>
                            <?php
                            if($validation == 1){
                            $query = $this->Module->userinfo_details();
                            
                            ?>
                            <div class="td">Action</div>
                            <?php
                            }
                            ?>
                        </div>

                        <?php
                        $this->load->model("Module");
                        if($validation == 1){
                            $query = $this->Module->userinfo_details();
                        }else{
                            $query = $this->Module->userinfo_details_not_admin($this->session->userdata('user_session'));
                        }
                        foreach ($query->result() as $row) {
                            ?>
                            <form class="tr form-info" data-action="<?php echo site_url('response/update_user'); ?>">
                                <input type="hidden" name="user_value" value="<?php echo $row->ID; ?>">
                                <div class="td"><input type="text" name="firstname" value="<?php echo $row->fname; ?>"></div>
                                <div class="td"><input type="text" name="middlename" value="<?php echo $row->middle; ?>"></div>
                                <div class="td"><input type="text" name="lastname" value="<?php echo $row->lastname; ?>"></div>
                                  <?php  if ($validation == 1) { ?>
                                        <div class="td">
                                            <select name="position" data-select="<?php echo $row->position; ?>">
                                                <option value="">Select</option>
                                                <option value="0" <?php if($row->position == 0){ echo "selected='selected'";}?>>User</option>
                                                <option value="1" <?php if($row->position == 1){ echo "selected='selected'";}?>>Administrator</option>
                                            </select>
                                        </div>
                                    <?php } ?>
                                <div class="td"><input type="text" name="email" value="<?php echo $row->email; ?>"></div>
                                <div class="td text-center" ><button type="button" data-reset="<?php echo $row->ID; ?>" class="btn btn-default btn-xs btn-password">Reset Password</button></div>
                                <div class="td text-center" ><button class="btn btn-xs btn-blue" type="submit">Update</button>
                                    <?php  if ($validation == 1) { ?>
                                    <button type="button" data-reset="<?php echo $row->ID; ?>" class="btn btn-danger btn-xs btn-delete">Delete</button>
                                    <?php } ?>
                                </div>
                            </form>
                            <?php
                        }
                        ?>

                    </div>
                </div>
                <div class="panel-footer text-right">
                    <?php //echo $php->inbox_pagin(); ?>
                </div>
            </div>

            <div class="widget-footer" style="text-align: right;"> 
                
                <?php
                if($validation == 1){ 
                    $this->load->model("Module");
                    echo $this->Module->user_pagination();
                }
                ?>
            </div>
        </div> 
    </div>
</div>

<form class='formaddusers'>
    <div id="createnew" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;   </button>
                    <h4 class="modal-title"> Create Users</h4>

                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="firstname" placeholder="First Name" name="firstname">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="middlename" placeholder="Middle Name" name="middlename">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="lastname" placeholder="Last Name" name="lastname">
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email" placeholder="Email Address" name="email">
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" id="password" placeholder="Password" name="password">
                    </div>
                    <div class="custom-input">
                        <span><strong>User Type </strong> </span>
                    </div>
                    <div class="custom-input">
                        <input type="radio" id="radio-1" name="user_type" value="1"><label for="radio-1">Administrator</label>
                        <input type="radio" id="radio-2" name="user_type" value="0"><label for="radio-2">User</label>
                    </div>
                    <span class="output"></span>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-default usersadd" >Save</button>
                </div>
            </div>

        </div>
    </div>
</form>

<div class="modal reset-password">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reset Password</h4>
            </div>
            <div class="modal-body"> 
                <form class="reset-password-form" data-action="<?php echo site_url('Response/password_reset'); ?>">
                    <input type="hidden" class="hide password-id" name="password_id" />
                    <div class="form-group">
                        <input type="password" class="form-control" id="pass" placeholder="Password" name="password" />
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Re-password" name="repassword" />
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default btn-block">Reset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal delete_user_div">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Delete this user?</h4>
            </div>
            <div class="modal-body"> 
                <form class="delete-password-form" data-action="<?php echo site_url('Response/password_reset'); ?>">
                    <input type="hidden" class="hide delete-id" name="password_id" />
                    <div class="form-group" style="text-align: center !important; display:inline-block;width:100%">
                        <button class="btn btn-xs btn-blue" type="submit" name="delete" class="form-group">Yes</button>
                        <button class="btn btn-xs btn-default" type="submit" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



