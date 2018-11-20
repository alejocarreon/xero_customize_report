var EM = EM || {};
EM.script = (function (j) {
  var _url = j('[name="site"]').attr('content');
    var init = function () {
        togglemenu();
    
        page_progress();
        default_datepicker();
        folder();
        rename_folder();
        drop_upload();
        deleting_file();
        download_file();
        zip_file();
        check_all();
        selected_file_delete();
        delete_folder();
        pop_link();
        xero_connect();
        disconnect_xero();

    };
    var disconnect_xero = function(){
        j(".disconnect-xero").click(function(){
          console.log("disconnect button has been clicked");
          var _this = j(this);
          j.ajax({
              url: _url + 'inquiry/logout',
              dataType: 'json',
              method: 'post',
              data: _this.serialize(),
              success: function (e) {
                if (e.message === 'success') {
                      j.notify(e);
                    setTimeout(function () {
                        window.location.reload();
                    }, 3000);
                }
              }
          });
          return false;
        });
    };
    var xero_connect = function () {
        j('.xero-connect-form').validate({
            rules: {
                "Clientname": {required: true},
                "APIKey"  : {required: true},
                "APISecret"  : {required: true}
            }, showErrors: function (errorMap, errorList) {
                            j.each(this.errorList, function (index, value) {
                                var _elm = j(value.element);
                                _elm.parent().addClass('has-error');
                                _elm.parent().popover({content: value.message, trigger: 'hover', placement: 'top'});
                            });
                            j.each(this.successList, function (index, value) {
                                var _elm = j(value);
                                _elm.parent().removeClass('has-error');
                                _elm.parent().popover('destroy');
                            });
                        }, submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'CXero/connect',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {

                   var myJSON = e.text.Status;
                   j(".validationdefault").addClass('hide');


                   if(myJSON === 'OK'){

                    var jsonData = JSON.stringify(e.text);
                    //console.log(jsonData);


                    var APIKEY = j('.APISecret').val();
                    var APISECRET = j('.APISecret').val();
                    var IMG = j('#image_upload_preview').attr('src');

                    var JSONADDVALUE = j('.jsonvalue').val(jsonData);

                     var imgval = j('#image_upload_preview').attr('src');
                      //  console.log(imgval + '-value');
                        j('.srchvalue').val(imgval);



                     j(".validationdefault").removeClass('hide');
                     //console.log(myJSON);
                     j(".reportframe").attr('src', 'PDFPage/?key='+APIKEY+'&secret='+ APISECRET+'&img=');
                   }else{
                      j(".validationdefault").addClass('hide');
                       //console.log(myJSON);
                   }

                   setTimeout(function () {
                       window.location.reload();
                   }, 2000);





                    }
                });
                return false;

            }
        });
    };

    var pop_link = function(){

         j('#copy-target').select();
          j('.pop-link').popover();
    };

    var selected_file_delete = function(){
        var _selected = j('.delete-selected-file');
         var _select = j('.select-delete');
        _selected.unbind().bind('click',function(e){
            _select.each(function(){
               var _this = j(this);
                if (_this.is(':checked')) {
                    j.ajax({
                        url: _url + 'request/delete_file',
                        dataType: 'json',
                        data: {
                            data_id: _this.attr('data-id'),
                            data_file: _this.attr('data-file'),
                            data_folder: _this.attr('data-folder')
                        },
                        method: 'post',
                        success: function (e) {
                            if (e.message === 'success') {
                                _this.parent().parent().remove();
                            }
                        }
                    });
                }
            });
            return false;
        });
    };
    var check_all = function(){
        var _check = j('.check-all');
        var _select = j('.select-delete');
        _check.unbind().bind('change',function(){
            var _this = j(this);
            if(_this.is(':checked')){
                _select.prop('checked',true);
            }else{
                _select.prop('checked',false);
            }
        });
    };
    var zip_file = function(){
        var _file = j('.zip-file-download');
        _file.unbind().bind('click', function () {
            var _this = j(this);
            window.open(_url+'request/zip/'+_this.attr('data-folder'), '_blank');
        });
    };
    var download_file = function(){
        var _file = j('.btn-download-file');
        _file.unbind().bind('click', function () {
            var _this = j(this);
            window.open(_url+'request/download/'+_this.attr('data-folder')+'/'+_this.attr('data-file'), '_blank');
        });
    };
    var deleting_file = function () {
        var _file = j('.delete-file');
        _file.unbind().bind('click', function () {
            var _this = j(this);
            if (confirm('Are you sure you want to delete this file '+_this.attr('data-file'))) {
                _this.attr('disabled', 'disabled');
                _this.find('.fa').addClass('fa-spinner fa-spin').removeClass('fa-trash');
                j.ajax({
                    url: _url + 'request/delete_file',
                    dataType: 'json',
                    data: {
                        data_id: _this.attr('data-id'),
                        data_file: _this.attr('data-file'),
                        data_folder: _this.attr('data-folder')
                    },
                    method: 'post',
                    success: function (e) {
                        if (e.message === 'success') {
                            _this.parent().parent().remove();
                            j.notify(e);
                        }else{
                            get_file_after_upload(_this.attr('data-folder'));
                        }
                    }
                });
            }
        });
    };

    var get_file_after_upload = function(folder){
        var _table_files = j('.table-files');
        j.ajax({
            url: _url + 'request/get_per_folder',
            dataType: 'json',
            data:{folder_category:folder},
            method: 'post',
            success: function (e) {
                var _html = '';
                _html += '<thead>';
                _html += '<tr>';
                _html += ' <th class="text-center">';
                _html += '<input type="checkbox" class="check-all" value="1" >';
                _html += '</th>';
                _html += '<th class="text-center">File Name</th>';
                _html += '<th class="text-center">Action</th>';
                _html += '</tr>';
                _html += '</thead>';
                for (var i = 0; i < e.length; i++) {
                    _html += '<tr>';
                    _html += '<td class="text-center"><input type="checkbox" class="select-delete" name="delete" data-id="' + e[i].ID + '" data-file="' + e[i].file_name + '" data-folder="'+folder+'" ></td>';
                    _html += '<td>' + e[i].file_name + '</td>';
                    _html += '<td class="text-center"><button class="btn btn-danger btn-xs delete-file" data-id="' + e[i].ID + '" data-file="' + e[i].file_name + '" data-folder="'+folder+'"><i class="fa fa-trash"></i> Delete</button> <button class="btn btn-info btn-xs btn-download-file" data-folder="'+folder+'" data-file="' + e[i].file_name + '"><i class="fa fa-download" aria-hidden="true"></i> Download</button></td>';
                    _html += '</tr>';
                }
                _table_files.html(_html);
                selected_file_delete();
                deleting_file();
                download_file();
                check_all();
            }
        });
    };
    var drop_upload = function () {
        Dropzone.options.dropzoneid = {
            init: function () {
                this.on("success", function (file, responseText) {
                    if (typeof responseText.folder !== 'undefined') {
                        if (responseText.message === 'success') {
                            get_file_after_upload(responseText.folder);
                        }
                    } else {
                        j.notify(responseText);
                    }
                });
                this.on("complete", function (file) {
                    if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {

                    }
                });
            }
        };
    };
    var dateFromString = function (FromString) {
        var now = new Date(FromString * 1000);
        var dd = now.getDate();
        var mm = now.getMonth() + 1;
        var yyyy = now.getFullYear();
        var hh = now.getHours();
        var ii = now.getMinutes();
        var ss = now.getSeconds();
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (mm < 10) {
            mm = '0' + mm;
        }
        if (hh < 10) {
            dd = '0' + dd;
        }
        if (ii < 10) {
            ii = '0' + ii;
        }
        if (ss < 10) {
            ss = '0' + ss;
        }
        return  mm + '/' + dd + '/' + yyyy + ' ' + hh + ':' + ii + ':' + ss;
    };
    var delete_folder = function(){
        var _delete_folder = j('.delete-folder');
        _delete_folder.unbind().bind('click', function () {
            if (confirm("Are you sure you want to delete this folder?")) {
                var _this = j(this);
                j.ajax({
                    url: _url + 'request/delete_folder',
                    dataType: 'json',
                    method: 'post',
                    data: {folder_category: _this.attr('data-folder')},
                    success: function (e) {
                        if (e.message === 'success') {
                            _this.parent().parent().remove();
                        }
                    }
                });
            }
        });
    };
    var update_folders = function () {
        var _folder = j('.folders');
        var _html = '';
        j.ajax({
            url: _url + 'request/get_folders',
            dataType: 'json',
            method: 'post',
            success: function (e) {
                _html += '<tr>';
                _html += '<td><a href="'+_url+'home/folder/'+e[0].ID+'/'+e[0].folder_real+'" class="btn btn-default btn-xs folder-file"><i class="fa fa-folder-open" aria-hidden="true"></i></a>  <input type="text" readonly="readonly" class="rename-folder" data-bind="' + e[0].ID + '" value="' + e[0].folder_name + '">';
                _html += '<td id="id_'+e[0].folder_real+'">';
                _html += '</td>';
                _html += '<td>' + dateFromString(e[0].folder_created) + '</td>';
                _html += '<td>' + dateFromString(e[0].folder_update) + '</td>';
                _html += '<td class="text-center"><button class="btn btn-xs btn-danger delete-folder"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button> <button class="btn btn-xs btn-blue zip-file-download" data-folder="'+e[0].folder_real+'"><i class="fa fa-download" aria-hidden="true"></i> Download</button></td>';
                _html += '</tr>';
                _folder.find('tbody').prepend(_html);
                j.ajax({
                    url: _url + 'request/get_num_items',
                    dataType: 'json',
                    method: 'post',
                    data: {get_num_items: e[0].folder_real},
                    success: function (_e) {
                        j('#id_'+e[0].folder_real).html(_e.n_rows);
                    }
                });
                delete_folder();
                rename_folder();
                zip_file();
            }
        });
    };
    var rename_folder = function () {
        j(".rename-folder").unbind().bind('dblclick', function () {
            var _this = j(this);
            _this.removeAttr('readonly').focus();
            _this.unbind().bind('keydown', function (e) {
                var code = e.keyCode || e.which;
                if (code === 13) {
                    var _this = j(this);
                    j.ajax({
                        url: _url + 'request/update_folder_name',
                        dataType: 'json',
                        method: 'post',
                        data: {fid: _this.attr('data-bind'), fname: _this.val()},
                        success: function (e) {
                            if (e.message === 'error') {
                                _this.val(_this.attr('data-value')).blur();
                            }
                            j.notify(e);
                        }
                    });
                }
            });
        });
    };
    var folder = function () {
        j.validator.addMethod("clean_name", function (value, element) {
            return this.optional(element) || /^[a-z0-9\-\s]+$/i.test(value);
        }, "Folder name must contain only letters, numbers, or dashes.");
        j('.form-create-folder').validate({
            rules: {
                create_folder: {
                    required: true,
                    clean_name: true
                }
            }, showErrors: function (errorMap, errorList) {
                j.each(this.errorList, function (index, value) {
                    var _elm = j(value.element);
                    _elm.parent().addClass('has-error');
                    _elm.parent().popover({content: value.message, trigger: 'hover', placement: 'top'});
                });
                j.each(this.successList, function (index, value) {
                    var _elm = j(value);
                    _elm.parent().removeClass('has-error');
                    _elm.parent().popover('destroy');
                });
            }, submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'request/create_new',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.message === 'success') {
                            update_folders();
                            _this[0].reset();
                        }
                        j.notify(e);
                    }
                });
                return false;
            }
        });
    };
    var page_progress = function () {
        var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname;
    };
    var default_datepicker = function () {
        j('.default-datepicker').datepicker();
    };
    var login = function () {
        j('.login').validate({
            rules: {
                email_address: {
                    required: true,
                    email: true
                },
                user_password: 'required'
            }, showErrors: function (errorMap, errorList) {
                j.each(this.errorList, function (index, value) {
                    var _elm = j(value.element);
                    _elm.parent().addClass('error-input');
                    _elm.parent().popover({content: value.message, trigger: 'hover', placement: 'top'});
                    var len = _elm.parent().find('.form-control-feedback').length;
                    if (len === 0) {
                        _elm.parent().append('<span class="glyphicon glyphicon-remove form-control-feedback" aria-hidden="true"></span>');
                    }
                });
                j.each(this.successList, function (index, value) {
                    var _elm = j(value);
                    _elm.parent().removeClass('error-input');
                    _elm.parent().popover('destroy');
                    var len = _elm.parent().find('.form-control-feedback').length;
                    if (len > 0) {
                        _elm.parent().find('.form-control-feedback').remove();
                    }
                });
            }, submitHandler: function (form) {
                var _this = j(form);
                console.log('IN');
                j.ajax({
                    url: _url + 'response/login',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (option) {
                         console.log(option.text);
                        if (option.message === 'success') {
                            _this.find('.output').html('<div class="alert alert-success text-center">' + 'Success' + '</div>');
                           window.location.reload();
                        } else if (option.message === 'error') {
                            _this.find('.output').html('<div class="alert alert-warning text-center">' + 'Invalid email or password' + '</div>');
                        }
                    }
                });
                return false;
            }
        });
    };
    var togglemenu = function () {
        var _main = j('.main');
        _main.find('.side-panel-button').click(function () {
            if (_main.hasClass('close-sidemenu') === false) {
                _main.addClass('hide-span');
                _main.find('.content').animate({'margin-left': '60px'}, 200, function () {
                    _main.find('.content').removeAttr('style');
                });
                _main.find('.side-menu').animate({width: '60px'}, 200, function () {
                    _main.addClass('close-sidemenu');
                    j.cookie("sidemenu", 'sidemenu');
                    _main.find('.side-menu').removeAttr('style');
                    _main.find('.side-menu').find('span').each(function () {
                        var _this = j(this);
                        var _badge = _this.parent().find('.badge');
                        var _name = _this.html();
                        if (_badge.length > 0) {
                            _name += (" <i class='badge'>" + _badge.html() + "</i>");
                        }
                        _this.parent().popover({content: _name, container: 'body', placement: 'right', trigger: 'hover', html: true});
                    });
                });
            } else {
                _main.find('.content').animate({'margin-left': '300px'}, 200, function () {
                    _main.find('.content').removeAttr('style');
                });
                _main.find('.side-menu').animate({width: '300px'}, 200, function () {
                    _main.removeClass('close-sidemenu');
                    _main.find('.side-menu').removeAttr('style');
                    _main.removeClass('hide-span');
                    _main.find('.side-menu').find('span').each(function () {
                        var _this = j(this);
                        _this.parent().remove('data-content').popover('destroy');
                    });
                    j.removeCookie("sidemenu");
                    j.cookie("sidemenu", '', {expires: -1, path: '/'});
                });
            }
        });
        j(window).on('resize load', function () {
            var _this = j(this);
            if (_this.width() < 768) {
                _main.addClass('close-sidemenu');
                _main.find('.side-menu').find('span').each(function () {
                    var _this = j(this);
                    var _badge = _this.parent().find('.badge');
                    var _name = _this.html();
                    if (_badge.length > 0) {
                        _name += (" <i class='badge'>" + _badge.html() + "</i>");
                    }
                    _this.parent().popover({content: _name, container: 'body', placement: 'right', trigger: 'hover', html: true});
                });
            }
        });
    };
    return{
        init: init
    };
})(jQuery);
