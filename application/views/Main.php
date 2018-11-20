
<div class="content">
    <div class="container-fluid">
        <div class="widget grid6">
            <div class="widget-header">
                <div class="widget-title">
                    <strong><i class="fa fa-folder-open-o" aria-hidden="true"></i>Folders / Create Folder  </strong>
                </div>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <div class="row">
                    <div class="col-lg-6"></div>
                    <div class="col-lg-6">
                        <form class="input-group form-create-folder">
                            <input type="text" class="form-control" name="create_folder" value="" placeholder="Folder Name">
                            <span class="input-group-btn">
                                <button class="btn btn-yellow">
                                    <i class="fa fa-folder-open-o" aria-hidden="true"></i> Create Folder
                                </button>
                            </span>
                        </form>
                    </div>
                </div>
                <div class="folders">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th> Folder name </th>
                                <th> Files </th>
                                <th> Create Date </th>
                                <th> Last Update </th>
                                <th> Owner </th>
                                <th> Action </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = $this->Module->session_username($this->session->userdata('user_session'));
                              foreach ($query->result() as $row) { $position = $row->position; }
                              if($position == 0){
                                   $query = $this->Models->folders_not_admin($this->session->userdata('user_session'));
                              }elseif($position == 1){
                                  $query = $this->Models->folders();
                              }
                            foreach ($query->result() as $row) {
                                ?>
                                <tr>
                                    <td>
                                        <a href="<?php echo site_url(); ?>home/folder/<?php echo $row->ID; ?>/<?php echo $row->folder_real; ?>" class="btn btn-default btn-xs folder-file"><i class="fa fa-folder-open" aria-hidden="true"></i></a>  <input type="text" readonly="readonly" class="rename-folder" data-value="<?php echo $row->folder_name; ?>" data-bind="<?php echo $row->ID; ?>" value="<?php echo $row->folder_name; ?>">
                                    </td>
                                    <td><?php echo $this->Models->per_folder($row->folder_real)->num_rows(); ?></td>
                                    <td><?php echo date('m/d/Y h:i:s', $row->folder_created); ?></td>
                                    <td><?php echo date('m/d/Y h:i:s', $row->folder_update); ?> </td>
                                    <td><?php echo $row->fname." ".$row->lastname; ?> </td>
                                    <td class="text-center"><button class="btn btn-xs btn-danger delete-folder" data-folder="<?php echo $row->folder_real; ?>"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button> <button class="btn btn-xs btn-blue zip-file-download" data-folder="<?php echo $row->folder_real; ?>"><i class="fa fa-download" aria-hidden="true"></i> Download
                                    </button>

                                   <a  data-toggle="popover" title="Copy to Link" data-html="true" data-content="<input onclick='this.select()' class='copy-target' id='copy-target' type='text' value='<?php echo site_url('request/zip/').$row->folder_real ?>'>" class="btn btn-xs btn-default pop-link "  data-placement="left">Copy Link</a>
                                  </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="widget-footer">
                &nbsp;
            </div>
        </div>
    </div>
</div>
