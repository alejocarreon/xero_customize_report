<div class="content">
   <div class="container-fluid">
      <div class="widget">
         <div class="panel panel-info">
            <div class="panel-heading">Report Explorer</div>
            <div class="panel-body">
               <div class="widget-content body-filemanager">
                  <div class="filemanager">
                     <div class="search">
                        <input type="search" placeholder="Find a file.." style="display: none;">
                     </div>
                     <div class="breadcrumbs"><span class="folderName">Scrubbed</span></div>
                     <ul class="data animated" style="">
                        <li class="files"><a href="files/2018-10-10-02-55-27.pdf"  target="_blank" title="files/2018-10-10-02-55-27.pdf" class="files"><span class="icon file f-pdf">.pdf</span><span class="name">2018-10-10-02-55-27.pdf</span> <span class="details">203 KB</span></a></li>
                        <li class="files"><a href="files/2018-10-10-02-58-18.pdf"  target="_blank"  title="files/2018-10-10-02-58-18.pdf" class="files"><span class="icon file f-pdf">.pdf</span><span class="name">2018-10-10-02-58-18.pdf</span> <span class="details">203 KB</span></a></li>
                        <li class="files"><a href="files/Delivery Note.pdf"  target="_blank" title="files/Delivery Note.pdf" class="files"><span class="icon file f-pdf">.pdf</span><span class="name">Delivery Note.pdf</span> <span class="details">203 KB</span></a></li>
                        <li class="files"><a href="files/Delivery Note.pdf"  target="_blank" title="files/Delivery Note.pdf" class="files"><span class="icon file f-pdf">.pdf</span><span class="name">Delivery Note.pdf</span> <span class="details">203 KB</span></a></li>
                        <li class="files"><a href="files/Delivery Note.pdf"  target="_blank"   title="files/Delivery Note.pdf" class="files"><span class="icon file f-pdf">.pdf</span><span class="name">Delivery Note.pdf</span> <span class="details">203 KB</span></a></li>
                     </ul>
                     <div class="nothingfound" style="display: none;">
                        <div class="nofiles"></div>
                        <span>No files here.</span>
                     </div>
                  </div>
               </div>

            </div>
         </div>

      </div>
   </div>
</div>
<div class="modal fade sessionmodal" id="sessionmodal" role="dialog">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Login</h4>
            </div>
            <div class="modal-body">
                <div class="wrapper">
                    <form class="login userlogin" method="post" autocomplete="false">
                        <span><img src="<?php echo site_url(); ?>images/scrubbed-login-icon.png"></span>

                        <input type="text" class="form-control" name="email_address" required="" autofocus="" placeholder="Email">
                        <input type="password" class="form-control" name="user_password" value="" placeholder="Password">
                        <button class="btn btn-primary btn-block"><i class="fa fa-sign-in" aria-hidden="true"></i> Login</button>
                        <a href="<?=$google_login_url?>" class="waves-effect waves-light btn red btn-block"><i class="fa fa-google left"></i>Google login</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
