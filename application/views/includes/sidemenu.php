<div class="side-menu">
    <div class="side-menu-content">
        <ul>
            <li>
                <a href="<?php echo site_url(); ?>connection">
                    <i class="fa fa-plug" aria-hidden="true"></i> <span>CONNECTION</span>
                </a>
            </li>
            <?php
            $key = $this->session->userdata('key');
            if($key != ''){
            ?>
            <li>
                <a href="<?php echo site_url(); ?>PDFReport">
                    <i class="fa fa-bar-chart" aria-hidden="true"></i> <span>REPORTS</span>
                </a>
            </li>
            <?php
             }
            ?>
            <li>
                <a href="<?php echo site_url(); ?>templatesettings">
                    <i class="fa fa-cog" aria-hidden="true"></i> <span>SETTINGS</span>
                </a>
            </li>
        </ul>
    </div>
    <div class="side-panel-button fa fa-bars"></div>
</div>
