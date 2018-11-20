<div class="side-menu">

    <div class="side-menu-content">
      <div>
        <?php
        if(isset($_SESSION['profile_pic'])){
        ?>
        <div class="profile-picture">
          <img class="add-profile" src="<?=$_SESSION['profile_pic']?>">
        </div>
        <?php
        }
        ?>
        <?php
        if(isset($_SESSION['name'])){
        ?>
          <div class="ticketing-username"> 	<?php echo $_SESSION['name']; ?></div>
        <?php
        }
        ?>
        <ul>
            <li>
                <a href="<?php echo site_url(); ?>connection">
                    <i class="fa fa-spinner" aria-hidden="true"></i> <span>GENERATE REPORT</span>
                </a>
            </li>

            <li>
                <a href="<?php echo site_url(); ?>templatesettings">
                    <i class="fa fa-search" aria-hidden="true"></i> <span>REPORT EXPLORER</span>
                </a>
            </li>
        </ul>
      </div>
    </div>
    <div class="side-panel-button fa fa-bars"></div>
</div>
