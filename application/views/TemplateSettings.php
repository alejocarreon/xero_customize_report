<div class="content">
  <div class="container-fluid">
    <div class="widget grid6">
      <div class="widget-header">
        <div class="widget-title">
          <strong>
            <i class="fa fa-folder-open-o" aria-hidden="true">
            </i>Settings
          </strong>
        </div>
      </div>
      <!-- /widget-header -->
      <div class="widget-content">
        <div class="row">
          <div class='col-lg-5'>
            <ul class="nav nav-tabs ">
<li class="active">
  <a data-toggle="tab" href="#home">Template
  </a>
</li>
<li>
  <a data-toggle="tab" href="#page">Pages
  </a>
</li>
</ul>

<div class="tab-content">
 <div id="home" class="tab-pane fade in active">
   <br>
   <span>
        <button class="btn btn-default" data-toggle="modal" data-target="#createpage" data-backdrop="static">Create New</button>
  <span>
  <div id="home" class="tab-pane fade in active">
  </div>
<br>
<br>
<form class="edit-template" method="post">
   <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Template Name</th>
      </tr>
    </thead>
    <tbody class="templatelist">
      <?php
      $count= 0 ;
      $row = $this->Modules->template_list();
      $data = $row->result();
      foreach ($data as $key) {
      $count++;
      ?>
    <tr>
      <td><?php echo $count; ?></td>
      <td><input type="text" value="<?php echo $key->template_name; ?>"  class="form-control noborder" ></td>

    </tr>
    <?php
  }
     ?>
    </tbody>
  </table>
</form>
  <div>
    <div class="row">
        <div class="col-lg-9"><h5 class="strong"><strong>Total Template : <?php echo  $this->Modules->counttemplate(); ?></strong></h5></div>
        <div class="col-lg-3"><?php ?></div>
    </div>
    <br>
    <div class="row">
        <div class="col-lg-3"></div>
        <div class="col-lg-6"><a class="btn btn-default" data-toggle="modal" data-target="#templatelist" data-backdrop="static">View All</a></div>
        <div class="col-lg-3"></div>
    </div>
  </div>
 </div>
 <div id="page" class="tab-pane fade">
   <br>



   <span>
        <button class="btn btn-default" data-toggle="modal" data-target="#selectpage" data-backdrop="static">Add Page</button>
  </span>
  <p style="padding:5px;">

  <select class="form-control select_template_view" name="select_template_view">
     <option value="none"></option>
     <?php
     $row = $this->Modules->list_template();
     $data = $row->result();
     foreach ($data as $key) {
      ?>
     <option value="<?php echo $key->ID; ?>"><?php echo $key->template_name; ?></option>
     <?php
   }
      ?>
  </select>
</p>
<div class="bind-dragable">
<p class="dragable">
  <h5 class="hide labeldragabble"><strong>Active Pages</strong></h5>
<span class="a">
<ul id="a" class="connectedSortable ">
</ul>
</span>
 <h5 class="hide labeldragabble"><strong>Disabled Pages</strong></h5>
<span class="b">
<ul id="b" class="connectedSortable ">
</ul>
</span>
</p>
</div>
 </div>
 <div id="menu2" class="tab-pane fade">
   <h3>Menu 2</h3>
   <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
 </div>
 <div id="menu3" class="tab-pane fade">
   <h3>Menu 3</h3>
   <p>Eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</p>
 </div>
</div>

<div class="modal fade editpagesmodal" id="editpage" role="dialog">
  <form class="pageedit" method="post">
    <input type='hidden' value='' name='hiddenfield' class='hiddenfield'>
    <input type='hidden' value='' name='hiddenfieldtemplate' class='hiddenfieldtemplate'>
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title page-title-modal"></h4>
            </div>
            <div class="modal-body">

                  <input type="hidden" name="pagegivenvalue" value="" class="pagegivenvalue">
                  <div class="container-fluid bodypage">

                  </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
    </div>
  </form>
</div>

<div class="modal fade selectpage" id="selectpage" role="dialog">
  <form class="create_layout" method="post">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Page</h4>
            </div>
            <div class="modal-body">

              <div class="input-group">
                  <span class="input-group-addon">Template</span>
                  <select class="form-control" name="tempalte_option">
                     <option value="none"></option>
                     <?php
                     $row = $this->Modules->list_template();
                     $data = $row->result();
                     foreach ($data as $key) {
                      ?>
                     <option value="<?php echo $key->ID; ?>"><?php echo $key->template_name; ?></option>
                     <?php
                   }
                      ?>
                  </select>

              </div>
              <br>
              <div class="input-group">
                  <span class="input-group-addon">Page Title</span>
                  <input type="text" class="form-control" name="pagetitle">

              </div>
                <br>
                    <div class="row">
                        <div class="col-md-3">
                          <div class="panel panel-info">
                                <div class="panel-heading">Single Column</div>
                                <div class="panel-body">
                                      <div class="row center-my-text box-layout" >
                                            <div class="col-lg-12 center-my-text grid-padding">


                                            </div>
                                      </div>
                                </div>
                                <div class="panel-footer">
                                  <input type="radio" name="pagelayout" value="SingleLayout" checked="checked">Single Layout<br>
                                </div>
                          </div>
                        </div>
                        <div class="col-md-3 hide">
                          <div class="panel panel-info">
                                <div class="panel-heading">Two Column</div>
                                <div class="panel-body">
                                      <div class="row center-my-text  box-layout" >
                                            <div class="col-sm-6 center-my-text grid-padding">

                                            </div>
                                            <div class="col-sm-6 center-my-text grid-padding">

                                            </div>
                                      </div>
                                </div>
                                <div class="panel-footer">
                                  <input type="radio" name="pagelayout" value="TwoColumn">Two Column<br>
                                </div>
                          </div>
                        </div>
                        <div class="col-md-3 hide">
                          <div class="panel panel-info">
                                <div class="panel-heading">Two Row</div>
                                <div class="panel-body">
                                  <div class="row center-my-text box-layout" >
                                        <div class="col-lg-12 center-my-text grid-padding-half">


                                        </div>
                                  </div>
                                  <div class="row center-my-text box-layout" >
                                        <div class="col-lg-12 center-my-text grid-padding-half">


                                        </div>
                                  </div>
                                </div>
                                <div class="panel-footer">
                                <input type="radio" name="pagelayout" value="TwoRow">Two Rows<br>
                                </div>
                          </div>
                        </div>
                        <div class="col-md-3 hide">
                          <div class="panel panel-info">
                            <div class="panel-heading">Three Row</div>
                            <div class="panel-body">
                              <div class="row center-my-text box-layout" >
                                    <div class="col-lg-12 center-my-text grid-padding-third">


                                    </div>
                              </div>
                              <div class="row center-my-text box-layout" >
                                    <div class="col-lg-12 center-my-text grid-padding-third">


                                    </div>
                              </div>
                              <div class="row center-my-text box-layout" >
                                    <div class="col-lg-12 center-my-text grid-padding-third">


                                    </div>
                              </div>
                            </div>
                            <div class="panel-footer">
                                <input type="radio" name="pagelayout" value="ThreeRows">Three Row<br>
                            </div>
                          </div>
                        </div>
                    </div>
            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
    </div>
  </form>
</div>

<div class="modal fade createpage" id="createpage" role="dialog">
  <form class="createtemplate" method="post">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Template</h4>
            </div>
            <div class="modal-body">
                <div class="input-group mb-3">
                  <div class="input-group">
               <span class="input-group-addon">Name</span>
               <input type="text" class="form-control templatefield" placeholder="Enter Template Name" name="template">
           </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-info">Save</button>
            </div>
        </div>
    </div>
  </form>
</div>
<div id="templatelist" class="modal fade templatelist" role="dialog">
  <div class="modal-dialog modal-md">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Template List</h4>
      </div>
      <div class="modal-body">
<?php
$countlist = 0;
 ?>


<div class="container-fluid">
<form class="edit-template" method="post">
<div class='row'>
  <div class='col-lg-12'>
    <div class="panel panel-default">
    <div class="panel-heading">Template</div>
    <div class="panel-body">
      <div class="input-group">
          <input type="editfield" class="form-control editfield" value="" title="Template Name" name="editfield">
          <input type="hidden" class="form-control idtemplatehfield" value="" title="Template Name" name="idtemplatehfield">
      <span class="input-group-btn">
      <button class="btn btn-default" type="submit">
      </span>Update</button>
      </span>
      </div>
    </div>
    </div>

  </div>
</div>
</form>
<form class="template-form" method="post">
<input type="hidden" name="valuepagination" class="valuepagination">
<table id="example" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th class="panel-heading">#</th>
                <th class="panel-heading">Template Name</th>
                <th class="panel-heading">Action</th>
            </tr>
        </thead>
        <tbody>
          <?php
           $tempalte_id = $this->session->userdata('template');
           $keysession = $this->session->userdata('key');
           if(isset($tempalte_id) && isset($keysession)){
              $disable = "";
           }else{
              $disable = "disbaled='disabled'";
           }
          $count_zero = 0;
          $row = $this->Modules->rowData('template_db');
          $data = $row->result();
          foreach ($data as $key) {
          $count_zero++;
          ?>
            <tr>
                <td><?php echo $count_zero; ?></td>
                <td class="<?php echo $key->ID; ?>"><?php echo $key->template_name; ?></td>
                <td>
                <input type="hidden" name="IDT" value="<?php echo $key->ID ?>" >
                <button type="button" name="edit-value" <?php echo $disable; ?> class="btn btn-sm btn-success edit-value" id-edit="<?php echo $key->ID ?>" data-name="<?php echo $key->template_name ?>" ><i class="fa fa-pencil"></i></button>&nbsp;
                <button type="button" class="btn btn-sm btn-danger deletetxtfield"  name="deletetxtfield" id-edit="<?php echo $key->ID ?>" ><i class="fa fa-trash"></i></button>
                <button type="button" class="btn btn-sm btn-info load"  name="load" id-edit="<?php echo $key->ID ?>" ><i class="fa fa-tasks"></i></button>
                </td>
            </tr>
            <?php
          }
            ?>
        </tbody>
    </table>
  </form>
  </div>

  </div>

      </div>

    </div>

  </div>
          </div>
        </div>
      </div>
      <div class="widget-footer">
        &nbsp;
      </div>
    </div>
  </div>
</div>
