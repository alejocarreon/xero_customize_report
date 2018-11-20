<div class="content">
    <div class="container-fluid">

        <div class="widget grid6">
            <div class="widget-header">
                <div class="widget-title">
                    <i class="fa fa-th"></i> Grid 6
                </div>
                <div class="widget-controls">
                    <div class="widget-config"><a clsss="dropdown-toggle" data-toggle="dropdown" href="#" onclick="return false;"><i class="fa fa-gear"></i></a>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="#"><i class="fa fa-pencil"></i> Edit</a></li>
                            <li><a href="#"><i class="fa fa-trash-o"></i> Delete</a></li>
                            <li><a href="#"><i class="fa fa-ban"></i> Ban</a></li>
                        </ul>
                    </div>
                </div>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <div class="btns sd-btns">	
                    <button class="btn btn-green">Green</button>
                    <button class="btn btn-turquoise">Turquoise</button>
                    <button class="btn btn-aqua">Aqua</button>
                    <button class="btn btn-blue">Blue</button>
                    <button class="btn btn-lavender">Lavender</button>
                    <button class="btn btn-red">Red</button>
                    <button class="btn btn-orange">Orange</button>
                    <button class="btn btn-yellow">Yellow</button>
                    <button class="btn btn-grey">Grey</button>
                    <button class="btn btn-black">Black</button>
                    <button class="btn btn-dark-grey">Dark Grey</button>
                    <button class="btn btn-light-grey">Light Grey</button>
                    <button class="btn btn-white">White</button>
                    <button class="btn btn-primary">Primary</button>
                </div>
                <br>
                <div class="input-group">
                    <input type="text" class="form-control" name="search" value="" placeholder="Search for...">
                    <span class="input-group-btn">
                        <button class="btn btn-lavender" type="submit">Go!</button>
                    </span>
                </div>
                <hr>

                <div class="progressbar green" value="65">
                    <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: 45%;"> </div>

                </div>
                <div class="progressbar grey" value="13">
                    <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: 45%;"> </div>
                </div>

                <div class="progressbar blue" value="13">
                    <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: 45%;"> </div>
                </div>

                <hr>
                <div class="custom-input">
                    <input type="checkbox" id="chkbx-1"><label for="chkbx-1">Checkbox</label>
                    <input type="radio" id="radio-1" name="radio-btn"><label for="radio-1">Option 1</label>
                    <input type="radio" id="radio-2" name="radio-btn"><label for="radio-2">Option 2</label>
                </div>
                <hr>
                <div class="btns sd-btns">	
                    <button class="btn btn-green" data-toggle="modal" data-target="#myModal">Show Modal</button>
                </div>


                <hr>
                <div class="row">
                    <div class="col-sm-4">
                        <div class="form-group">	
                            <input type="text" class="default-datepicker form-control"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">	
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">	
                            <input type="text" class="form-control"/>
                        </div>
                    </div>
                </div>

            </div>
            <div class="widget-footer">
                <nav>
                    <ul class="pagination">
                        <li class="disabled">
                            <a href="#" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <li><a href="#">1</a></li>
                        <li><a href="#">2</a></li>
                        <li><a href="#">3</a></li>
                        <li><a href="#">4</a></li>
                        <li><a href="#">5</a></li>
                        <li>
                            <a href="#" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div> <!-- /widget -->
    </div>

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>