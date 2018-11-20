<div class="col-3 ">
   <div class="panel panel-weather hide">
      <div class="panel-body">
         <div class="row">
            <div class="col-6 temperature_string text-center"></div>
            <div class="col-6 icon_url0 text-center"></div>
            <div class="col-12 title0 text-center"></div>
            <div class="col-12 fcttext0"></div>
            <div class="col-12 location"></div>
            <div class="col-12 next-weather"></div>
         </div>
      </div>
   </div>
   <div class="panel panel-birthday">
      <div class="heading birthday text-center">HAPPY BIRTHDAY</div>
      <div class="panel-body">
         <div class="birthday-carousel owl-carousel owl-theme">
             <?php
             $bday = $this->Models->employee();
             $data = $bday->result();
             $array = array();
             foreach ($data as $value) {
                 if (date('m', $value->date_of_birth) === date('m')) {
                     ?>
                    <div class="item">
                       <div class="pro-image">
                          <img  data-bind="image-<?php echo $value->ID ?>" src="<?php echo ($value->profile_photo ? site_url('uploads/' . $value->profile_photo) : site_url('images/profile.png')) ?>">
                       </div>
                       <div class="birthday text-center"><?php echo $value->first_name ?> <?php echo $value->last_name ?></div>
                       <div class="birthday text-center"><?php echo date('F d Y', $value->date_of_birth) ?></div>
                    </div>
                    <?php
                }
            }
            ?>
         </div>
      </div>
   </div>

   <div class="panel panel-archive">
      <div class="panel-heading">RECENT ANNOUNCEMENTS</div>

      <?php
      $data = $this->Models->recent_announcement();
      $row = $data->result();
      foreach ($row as $value) {

      }

      ?>

      <div class="panel-list">
         <ul>
            <li>
               <a href="">
                  <strong>IT TEAM</strong><br/>
                  <span class="muted"><i class="far fa-clock"></i> Active last 4 days ago</span>
               </a>
            </li>
            <li>
               <a href="">
                  <strong>HR TEAM</strong><br>
                  <span class="muted"><i class="far fa-clock"></i> Last post 4 days ago</span>
               </a>
            </li>
            <li>
               <a href=""><strong>ADMIN TEAM</strong><br>
                  <span class="muted"><i class="far fa-clock"></i> Last post 7 hours ago</span>
               </a>
            </li>
            <li>
               <a href=""><strong>TALENT TEAM</strong><br>
                  <span class="muted"><i class="far fa-clock"></i> Last post 3 days ago</span>
               </a>
            </li>
            <li>
               <a href=""><strong>FINANCE TEAM</strong><br>
                  <span class="muted"><i class="far fa-clock"></i> Last post 8 days ago</span>
               </a>
            </li>
         </ul>
      </div>
   </div>
</div>

<div class="radio-player">
   <div class="radio-opener" title="Listen Music"  data-placement="left" ><div class="fa-icon"><i class="fa fa-music" aria-hidden="true"></i></div></div>
   <div class="radio-body">
      <iframe data-bind="https://radio.toa.com.ph/player_system/player"></iframe>
   </div>
</div>
