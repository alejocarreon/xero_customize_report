<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="site" content="<?php echo site_url(); ?>">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

      <script src='<?php echo site_url('ckeditor/ckeditor.js')?>'></script>
      <script src='<?php echo site_url('assets/script/script.js?ver=1'); ?>'></script>
      <title><?php echo (isset($title) ? $title : ''); ?></title>
   </head>
   <body class="<?php echo (!$this->session->userdata('user_session')?'login-page':''); ?>">
