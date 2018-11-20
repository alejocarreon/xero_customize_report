<div class="content">
    <div class="container-fluid">
        <div class="widget">
            <div class="widget-header">
                <div class="widget-title">
                    <strong><i class="fa fa-folder-open-o" aria-hidden="true"></i> Add Files </strong>
                </div>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <form action="<?php echo site_url('request/file_upload'); ?>" class="dropzone" id="dropzoneid">
                    <input type="hidden" value="<?php echo $this->uri->segment(3); ?>" name="id_category" />
                    <input type="hidden" value="<?php echo $this->uri->segment(4); ?>" name="category" />
                </form> 
            </div>
            <div class="widget-footer">&nbsp;</div>
        </div> 
        <div class="widget">
            <div class="widget-header">
                <div class="widget-title">
                    <strong><i class="fa fa-folder-open-o" aria-hidden="true"></i> Files</strong>
                </div>
                <div class="widget-controls">
                    <button class="widget-config delete-selected-file"><i class="fa fa-trash"></i></button>
                </div>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <div>
                    <table class="table table-bordered table-files">
                        <thead>
                            <tr>
                                <th class="text-center">
                                    <input type="checkbox" value="1" class="check-all">
                                </th>
                                <th class="text-center">File Name</th>
                                <th class="text-center">Action</th>
                            </tr>
                        </thead>
                        <?php
                        $query = $this->Models->per_folder($this->uri->segment(4));
                        foreach ($query->result() as $row) {
                            ?>        
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" class="select-delete" name="delete" data-id="<?php echo $row->ID; ?>" data-file="<?php echo $row->file_name; ?>" data-folder="<?php echo $this->uri->segment(4); ?>" >
                                </td>
                                <td><?php echo $row->file_name; ?></td>
                                <td class="text-center"><button class="btn btn-danger btn-xs delete-file" data-id="<?php echo $row->ID; ?>" data-file="<?php echo $row->file_name; ?>" data-folder="<?php echo $this->uri->segment(4); ?>"><i class="fa fa-trash"></i> Delete</button> <button class="btn btn-info btn-xs btn-download-file" data-file="<?php echo $row->file_name; ?>" data-folder="<?php echo $this->uri->segment(4); ?>"><i class="fa fa-download" aria-hidden="true"></i> Download</button></td>
                            </tr>
                            <?php
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="widget-footer">&nbsp;</div>
        </div> 
    </div>
</div>