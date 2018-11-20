<?php
$user = $this->Models->employee_info($this->session->userdata('user_session'));
$info = $user->result();
?>

<div class="col-3">
   <div class="panel">
      <div class="panel-body">
         <div style="text-align:right;">
            <button class="btn btn-outline-secondary btn-sm edit-profile"  href=""><i class="fas fa-cog"></i></button>
         </div>
         <div class="pro-image upload-profile-photo">
            <img data-bind="image-<?php echo $info[0]->ID ?>" src="<?php echo ($info[0]->profile_photo ? site_url('uploads/' . $info[0]->profile_photo) : site_url('images/profile.png')) ?>">
         </div>
         <div class="text-center"><a href="#" class="upload-profile-photo">Edit Profile Picture</a></div>
         <table class="pro-info-table">
            <tr>
               <td class="info-icon"><i class="fa fa-briefcase" aria-hidden="true"></i></td>
               <td><div class="pro-info"><?php echo $info[0]->job_title ?></div></td>
            </tr>
            <tr>
               <td class="info-icon"><i class="fa fa-home" aria-hidden="true"></i></td>
               <td><div class="pro-info"><?php echo $info[0]->permanent_address ?></div></td>
            </tr>
            <tr>
               <td class="info-icon"><i class="fa fa-birthday-cake" aria-hidden="true"></i></td>
               <td><div class="pro-info"><?php echo date("F d Y", $info[0]->date_of_birth) ?></div></td>
            </tr>
         </table>
      </div>
   </div>
   <div class="panel">
      <div class="panel-heading">EVENT CALENDAR</div>
       <?php if($info[0]->user_level == 4 || $info[0]->user_level == 3){?>
      <div class="calendar eventtoday">

      </div>
         <?php
            }else{
         ?>
      <div class="calendardemo">

      </div>
       <?php
           }
         ?>

      <div class="panel eventtoday">
         <div class="panel-heading">MONTH'S EVENTS</div>
         <div class="panel-list event eventbox">

            <ul class='mainul'>
                <?php
                $count_event = "";
                $todays_event = $this->Modules->get_event_today();
                $even_today_execute = $todays_event->result();
                foreach ($even_today_execute as $key_event) {
                    $count_event++;

                    if ($count_event <= 5) {
                        $show_validation = "";
                    } else {
                        $show_validation = "hide less";
                    }
                    ?>
                   <li class="calendarviewall <?php echo $show_validation; ?> <?php echo "e_".$key_event->ID; ?>">
                      <a >
                         <div class="row">
                            <div class="col-8">
                               <span class="muted" style="color:#49c4d0;font-weight:bold;"> <?php echo $key_event->month . "/" . $key_event->day . "/" . $key_event->year; ?></span>
                            </div>
                            <div class="col-4 " >
                              <div class="input-group text-right">
                               <button class="buttonnocss eventtoday " data-toggle="tooltip" title="Edit" data-identifier="<?php echo $key_event->ID; ?>"  ><i class="fas fa-pencil-alt"></i></button>
                               <button class="buttonnocss delete-calendar"  data-toggle="tooltip" title="Delete"  data-id="<?php echo $key_event->ID; ?>""  ><i class="far fa-trash-alt"></i></button>
                            </div>
                            </div>

                         </div>
                         <strong><?php echo $key_event->title; ?></strong> <span style="font-size:8px;">   By <?php echo $key_event->organizer; ?></span><br/>
                         <p>
                             <?php echo $key_event->description; ?>
                         </p>
                         <span class="muted" style="color:#49c4d0;">Start at <?php echo $key_event->start_time; ?> end at <?php echo $key_event->end_time; ?></span>

                      </a>
                   </li>
                   <?php
               }
               ?>
            </ul>
            <div class="row">
                 <div class="col-12 text-center">
                <a class="calendar_all_button leftlink">Show More ...</a>
                <a class="calendar_hide_button hide leftlink">... Show Less</a>
                 </div>
            </div>

         </div>

      </div>



      <button class="btn btn-success  calendar_view" style="width:100%; padding:5px">Calendar Summary</button>
   </div>

   <div class="panel">
      <div class="panel-heading">LINKS</div>
      <div class="panel-list">
         <ul>
            <li><a href="http://toa.com.ph/toaradio/Handbook/" target="_blank"><i class="fa fa-book" aria-hidden="true"></i>  Handbook</a></li>
            <li><a href="https://ticketing.theoutsourcedaccountant.ph/" target="_blank"><i class="fa fa-desktop" aria-hidden="true"></i> IT Ticketing system</a></li>
            <li><a href="https://www.hrhelpdesk.theoutsourcedaccountant.ph/" target="_blank"><i class="fa fa-users" aria-hidden="true"></i> HR Help Desk</a></li>
            <li><a href="http://radio.toa.com.ph/refer-a-mate-update/" target="_blank"><i class="fa fa-table" aria-hidden="true"></i> Time Tracking</a></li>
         </ul>
      </div>
   </div>
</div>


<div class="modal  modal_calendar_event modal-medium">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <a href="#close" class="close" data-dismiss="modal"><i class="fa fa-times"></i></a>
         <div class="modal-body">
            <div class="calendarcss">
               <div class="form-group">



                  <form class="calendar_event_create" id="calendar">

                     <div class="col-12" >

                        <br>
                        <div class="form-group">
                           <label>Date</label>
                           <input type="text" name="input_date_value" class="form-control input_date_value reset" id="input_date_value" readonly="">
                        </div>
                        <div class="form-group">
                           <label>Event Title</label>
                           <input type="hidden" value="" name="datevalue" class="datevalue">
                           <input type="hidden" value="" name="datevalueedit" class="datevalueedit">
                           <input type="hidden" value="" name="idcalendar" class="idcalendar reset" >
                           <input type="text" name="title" class="form-control title reset" id="title"
                                  <small id="emailHelp" class="form-text text-muted">This will serve as title caption.</small>
                        </div>
                        <div class="form-group">
                           <label>Event Organizer</label>
                           <input type="text" name="organizer" class="form-control organizer reset" id="organizer" >
                        </div>
                        <div class="form-group">
                           <label for="exampleTextarea">Description</label>
                           <textarea class="form-control description resetn" name="description" id="description"  rows="3"></textarea>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col-6" >

                                 <label>Start at <i class="far fa-clock"></i></label>
                                 <input  value=""  class="clockpicker form-control startat reset: value="7:00" name="startat" type="text" >
                              </div>
                              <div class="col-6" >
                                 <label>End at <i class="far fa-clock"></i></label>
                                 <input  value=""   class="clockpicker  form-control endat reset" name="endat" type="text">
                              </div>
                           </div>
                        </div>
                        <div class="form-group">
                           <div class="row">
                              <div class="col-6" >
                                 <label for="exampleTextarea">Location</label>
                                 <input  class="form-control location reset" name="location">

                              </div>
                              <div class="col-6" >
                                 <label for="exampleTextarea">Category</label>
                                 <select class="form-control category reset" name="category">
                                    <option id="category" value="">-Select-</option>
                                    <?php
                                    $row_count = $this->Modules->events_category();
                                    $count_data = $row_count->result();

                                    foreach ($count_data as $key_count) {
                                        ?>
                                        <option id="category" value="<?php echo $key_count->ID; ?>" ><?php echo $key_count->name; ?></option>
                                        <?php
                                    }
                                    ?>
                                 </select>
                              </div>
                           </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                     </div>

                  </form>


               </div>
            </div>
            <div  class="list-group" id="">

            </div>
         </div>
      </div>
   </div>
</div>




<div class="modal modal-profile modal-medium">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <a href="#close" class="close"><i class="fa fa-times"></i></a>
         <div class="modal-body">
            <ul class="nav nav-tabs info-tabs">
               <li class="nav-item">
                  <a class="nav-link active" href="#user-information"><i class="fas fa-info"></i> Accounts Information</a>
               </li>
               <li class="nav-item">
                  <a class="nav-link" href="#user-passaword"><i class="fas fa-key"></i> Change Password</a>
               </li>
            </ul>
            <div class="tab-content">
               <div class="tab-pane fade show active" id="user-information" role="tabpanel">
                  <form name="acountsinfoform" class="acountsinfoform" method="post">
                     <input type="hidden" name="sessionid" class="sessionid" value="<?php echo $this->session->userdata('user_session'); ?>">
                     <div class="form-group">
                        <label class="labelcaption">First Name</label>
                        <input type="text" name="fname" class="form-control "  id="fname" value="<?php echo $info[0]->first_name ?>">
                        <input type="hidden">
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">Middle Name</label>
                        <input type="text" name="mname" class="form-control"  id="mname" value="<?php echo $info[0]->middle_name ?>">
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">Last Name</label>
                        <input type="text" name="lname" class="form-control"  id="lname" value="<?php echo $info[0]->last_name ?>">
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">Email Address</label>
                        <input type="text" name="email" class="form-control"  id="lname" value="<?php echo $info[0]->email ?>">
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">Permanent Address</label>
                        <input type="text" name="address" class="form-control"  id="address"  value="<?php echo $info[0]->permanent_address ?>">
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">Contact No</label>
                        <input type="text" name="contact" class="form-control"  id="contact"  value="<?php echo $info[0]->contact ?>">
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">Date of Birth</label>
                        <input type="text" name="birthday" class="form-control date2"  id="birthday" value="<?php echo date("m/d/Y", $info[0]->date_of_birth) ?>" >
                     </div>
                     <div class="form-group text-right">
                        <button  type="submit" class="viewbtn accountinfobtn" style="text-align:right;">Update Information</button>
                     </div>
                  </form>
               </div>
               <div class="tab-pane fade" id="user-passaword" role="tabpanel">
                  <form name="passwordforminput" class="passwordforminput" method="post">
                     <input type="hidden" name="sessionid" class="sessionid" value="<?php echo $this->session->userdata('user_session'); ?>">
                     <div class="form-group">
                        <label class="labelcaption">Current Password</label>
                        <input type="password" name="cpassword" class="form-control"  id="cpassword" >
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">New Password</label>
                        <input type="password" name="npassword" class="form-control"  id="npassword" >
                        <input type="hidden" name="regid" class="form-control"  id="regid" >
                     </div>
                     <div class="form-group">
                        <label class="labelcaption">Re-type Password</label>
                        <input type="password" name="rpassword" class="form-control"  id="rpassword" >
                     </div>
                     <div class="form-group text-right">
                        <button type="submit"  class="viewbtn" style="text-align:right;" type="button">Apply Changes</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

<div class="modal modal_calendar modal-large">
   <div class="modal-dialog" role="document">
      <div class="modal-content ">
         <a href="#close" class="close"><i class="fa fa-times"></i></a>
         <div class="modal-body ">

           <div class="row">
                  <div class="col-12">
                      <p class="bigcaption" ><?php echo date('Y'); ?> CALENDAR LEGEND</p>
                        <div class='my-legend text-center'>
                           <span style="color:#1abc9c;"><i class="fas fa-circle"></i> Regular Holidays </span>
                           <span style="color:#3498db;"><i class="fas fa-circle"></i> Special Non Working Holidays </span>
                           <span style="color:#9b59b6;"><i class="fas fa-circle"></i> Local Holidays </span>
                           <span style="color:#5c6270;"><i class="fas fa-circle"></i> TOA Events </span>
                           <span style="color:#e67e22;"><i class="fas fa-circle"></i> Industry Events </span>
                           <span style="color:#E9D460;"><i class="fas fa-circle"></i> PH Social Events </span>
                        </div>
                  </div>

            </div>
            <br>
             <div class="row">
         <?php

              for ($x = 1; $x <= 12; $x++) {
             ?>

                  <div class="col-4">
                  <div class="panel monthbox" >
                  <div class="panel-heading caption_box_calendar text-center"  ><?php echo $this->Modules->calendar_caption($x ); ?></div>
                  <div class="wrapper">
                           <?php
                               $todays_events = $this->Modules->get_events_per_month(sprintf("%02d",$x), date('Y'));
                               $even_days_execute = $todays_events->result();
                               foreach ($even_days_execute as $events) {
                           ?>

                           <ul >
                           <li data-toggle="tooltip"  title="<?php echo  $events->description;?>" data-content="<?php echo  $events->description;?>" style="color:<?php echo $this->Modules->get_color($events->category); ?>"><strong><?php echo  $events->day;?></strong> <?php echo  $events->title;?><?php if(strlen($events->start_time)!=0){echo " (".$events->start_time."-".$events->end_time.")";}?>

                           </li>
                           </ul>
                           <?php
                           }
                           ?>

                  </div>
                  </div>
                  </div>

             <?php
               }
             ?>



            </div>


         </div>
      </div>
   </div>
</div>
<div class="modal modal-profile-upload modal-medium">
   <div class="modal-dialog" role="document">
      <div class="modal-content ">
         <a href="#close" class="close"><i class="fa fa-times"></i></a>
         <div class="modal-body ">
            <i class="fa fa-user"></i> Profile Picture
            <div class="image-editor">
               <div class="form-group">
                  <div class="cropit-preview" style="background-image: url('<?php echo ($info[0]->profile_photo ? site_url('uploads/' . $info[0]->profile_photo) : site_url('images/profile.png')) ?>"></div>
               </div>
               <div class="form-group">
                  <button class="btn btn-outline-primary btn-sm btn-block select-image-btn">Upload Image</button>
                  <div class="file-uploader"><input type="file" class="cropit-image-input"></div>
               </div>
               <div class="upload-controls hide">
                  <div class="form-group">
                     <table>
                        <tr>
                           <td><a href="#" class="rotate-left"><i class="fas fa-undo" title="Rotate left"></i></a></td>
                           <td><a href="#" class="rotate-right"><i class="fas fa-redo" title="Rotate right"></i></a></td>
                           <td><i class="fa fa-image fa-1x"></i></td>
                           <td><input type="range" class="cropit-image-zoom-input"></td>
                           <td><i class="fa fa-image fa-2x"></i></td>
                        </tr>
                     </table>
                  </div>
                  <button type="button" class="btn btn-outline-info export btn-sm btn-block">Set as profile image</button>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div class="modal modal_todays_event modal-medium">
   <div class="modal-dialog" role="document">
      <div class="modal-content ">
         <a href="#close" class="close"><i class="fa fa-times"></i></a>
         <div class="modal-body ">
            <form class="calendar_event_update" id="calendar_event_update">
               <div class="row">
                  <div class="col-12">
                     <h2 class="titleview"></h2>

                     <div class="form-group">
                        <label>Event Date</label>
                        <input type="text" value="" name="date_value" class="date_value form-control date1">
                        <input type="hidden" value="" name="dateid" class="dateid">


                     </div>
                     <div class="form-group">
                        <label>Event Title</label>
                        <input type="text" name="titleview" class="form-control titleview" id="titleview" >

                     </div>
                     <div class="form-group">
                        <label>Event Organizer</label>
                        <input type="text" name="organizeredit" class="form-control organizerfield" id="organizer" >

                     </div>
                     <div class="form-group">
                        <label for="exampleTextarea">Description</label>
                        <textarea class="form-control descriptionfield" name="descriptionfield" id="descriptionfield"  rows="3"></textarea>
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-6" >

                              <label>Start at <i class="far fa-clock"></i></label>
                              <input  value=""  class="clockpicker form-control clockpickerstart" value="7:00" name="startatedit" type="text" >
                           </div>
                           <div class="col-6" >
                              <label>End at <i class="far fa-clock"></i></label>
                              <input  value=""   class="clockpicker  form-control clockpickerend" name="endatedit" type="text">
                           </div>
                        </div>
                     </div>
                     <div class="form-group">
                        <div class="row">
                           <div class="col-6" >
                              <label for="exampleTextarea">Location</label>
                              <input  type="text" class="form-control locationedit" name="locationedit">

                           </div>
                           <div class="col-6" >
                              <label for="exampleTextarea">Category</label>
                              <select class="form-control categoryedit" name="categoryedit">
                                 <option id="category" value="">-Select-</option>
                                 <?php
                                 $row_count = $this->Modules->events_category();
                                 $count_data = $row_count->result();

                                 foreach ($count_data as $key_count) {
                                     ?>
                                     <option id="category" value="<?php echo $key_count->ID; ?>" ><?php echo $key_count->name; ?></option>
                                     <?php
                                 }
                                 ?>
                              </select>

                           </div>
                        </div>
                     </div>

                  </div>

               </div>
               <button type="submit" class="btn btn-primary updateevent">Update</button>
            </form>

         </div>
      </div>
   </div>
</div>
