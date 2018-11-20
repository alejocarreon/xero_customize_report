var AM = AM || {};
AM.jsscript = (function (j) {
    var _url = j('[name="site"]').attr('content');

    var init = function () {
        session_get();
        pdfSRC();
        create_template();
        generate_pagination();
        template_update();
        template_update_page();
        datatables();
        parse_value_template();
        delete_template();
        create_pages();
        onchangetemplate();
        dragable();
        droppable_disable();
        droppable_active();
        update_pages_layout();
        onchanagesingleselect();
        htmlEditortinymce();
        update_contents();
        onchangedatefield();
        load_template();
        sessionmodal();
        sidebar_profile();
        logout();
        login();
        sessionmodal();
        date_default_report_generate();
        generate_report();
        filter_li();
        pdf_final();
        pdf_delete();
        create_new_page();

    };

    var create_new_page = function () {
        j('.newpages').validate({
            rules: {
                "content": {required: true}
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
                //console.log("Success now");
              
                j.ajax({
                    url: _url+'Inquiry/new_summary_page',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        console.log(e);
                         
                        if (e.message === 'success') {
                           
                         j(".notification").html("<div class='alert success'><input type='checkbox' id='alert2'/><label class='close' title='close' for='alert2'><i class='icon-remove'></i></label><p class='inner'>Succefully Updated!</p></div>");
                        }
                          
                    }
                });
                return false;
                


            }
        });
    };
    var create_summary_page = function () {
        j('.newpage').validate({
            rules: {
                "pagetitle": {required: true},
                "tempalte_option": {required: true}
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
                    url: _url + 'Inquiry/addlayout',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        console.log("new page");
                    }
                });
                return false;
            }
        });
    };
    var pdf_delete = function () {
        var _val = j('.delete-report');
        _val.unbind().bind('click', function (e) {
            _val.each(function () {
                var _this = j(this);
                var id = _this.attr('data-id-delete');
                _this.confirm({
                    title: 'Confirmation',
                    content: 'Are you sure to delete this report?',
                    buttons: {
                        confirm: function () {
                            j.ajax({
                                url: _url + 'inquiry/delete_pdf',
                                dataType: 'json',
                                method: 'post',
                                data: {"get_id": id},
                                success: function (e) {
                                    console.log(e);

                                    if (e.message === 'success') {
                                        j.notify(e);
                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);


                                    }

                                }
                            });
                            return false;
                        },
                        cancel: function () {

                        }
                    }
                });




            });
        });
    };
    var pdf_final = function () {
        var _val = j('.finalize-report');
        _val.unbind().bind('click', function (e) {
            _val.each(function () {
                var _this = j(this);
                var id = _this.attr('data-id');


                _this.confirm({
                    title: 'Confirmation',
                    content: 'Are you sure to save this as final?',
                    buttons: {
                        confirm: function () {
                            j.ajax({
                                url: _url + 'inquiry/update_pdf_status',
                                dataType: 'json',
                                method: 'post',
                                data: {"get_id": id},
                                success: function (e) {
                                    console.log(e);

                                    if (e.message === 'success') {
                                        j.notify(e);

                                        setTimeout(function () {
                                            location.reload();
                                        }, 2000);


                                    }

                                }
                            });
                            return false;
                        },
                        cancel: function () {

                        }
                    }
                });




            });
        });
    };
    var filter_li = function () {
        j("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            j("#myTable tr").filter(function () {
                j(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    };
    var generate_report = function () {
        j('.generate-report-form').validate({
            rules: {

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
                console.log("generate button was clicked!");

                var key_txtfield = j(".key_txtfield").val();
                var secret_txtfield = j(".secret_txtfield").val();
                var client_id = j(".client_id").val();
                var template_id = j(".template_id").val();
                var reportdate = j("#reportdate").val();

                j.ajax({
                    url: _url + 'APIReport?key=' + key_txtfield + '&secret=' + secret_txtfield + '&client_id=' + client_id + '&template_id=' + template_id + '&date=' + reportdate + '',
                    method: 'get',
                    data: _this.serialize(),
                    success: function (e) {
                        console.log('Report has been generated');
                        window.location.reload();
                    }
                });
                return false;


            }
        });
    };
    var date_default_report_generate = function () {
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();

        if (dd < 10) {
            dd = '0' + dd
        }

        if (mm < 10) {
            mm = '0' + mm
        }

        today = mm + '/' + dd + '/' + yyyy;
        document.getElementById("reportdate").defaultValue = today;
    }
    var sidebar_profile = function () {
        j(".side-panel-button").click(function (e) {
            var _this = j(this);
            j(".profile-picture").toggle();
            j(".ticketing-username").toggle();
            e.preventDefault;
        });
    }
    var sessionmodal = function () {
        var _this = j(this);
        j.ajax({
            url: _url + 'inquiry/getsession',
            dataType: 'json',
            method: 'post',
            data: _this.serialize(),
            success: function (e) {
                if (e.email == undefined) {
                    console.log('no user');
                    /*j('#sessionmodal').modal('show');*/
                    j('#sessionmodal').modal({backdrop: 'static', keyboard: false});
                } else {

                    console.log('with user' + e.user);
                }

            }
        });
        return false;



    };

    var disconnect_xero = function () {
        j(".disconnect-xero").click(function () {
            console.log("disconnect button has been clicked");

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
    var droppable_active = function () {
        j("#a").droppable({
            drop: function (event, ui) {
                dragValue = ui.draggable.attr("data-drag-value");
                j.ajax({
                    url: _url + 'inquiry/updatepagestatusactive',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_id": dragValue},
                    success: function (e) {
                        if (e.message === 'success') {
                            var template_value = j(".templatefield").val();
                            j.notify(e);

                        }
                    }
                });
                return false;

            }
        });
    };
    var htmlEditortinymce = function () {
        tinymce.init({
            selector: ".htmltxtarea, .newpage",
            relative_urls : false,
            remove_script_host : false,
            convert_urls : true,
            plugins: [
                "advlist autolink autosave link image lists charmap print preview hr anchor pagebreak spellchecker",
                "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                "table contextmenu directionality emoticons template textcolor paste fullpage textcolor colorpicker textpattern"
            ],

            toolbar1: "newdocument fullpage | bold italic underline strikethrough | alignleft aligncenter alignright alignjustify | styleselect formatselect fontselect fontsizeselect",
            toolbar2: "cut copy paste | searchreplace | bullist numlist | outdent indent blockquote | undo redo | link unlink anchor image media code | insertdatetime preview | forecolor backcolor",
            toolbar3: "table | hr removeformat | subscript superscript | charmap emoticons | print fullscreen | ltr rtl | spellchecker | visualchars visualblocks nonbreaking template pagebreak restoredraft",

            menubar: false,
            toolbar_items_size: 'small',

            style_formats: [{
                    title: 'Bold text',
                    inline: 'b'
                }, {
                    title: 'Red text',
                    inline: 'span',
                    styles: {
                        color: '#ff0000'
                    }
                }, {
                    title: 'Red header',
                    block: 'h1',
                    styles: {
                        color: '#ff0000'
                    }
                }, {
                    title: 'Example 1',
                    inline: 'span',
                    classes: 'example1'
                }, {
                    title: 'Example 2',
                    inline: 'span',
                    classes: 'example2'
                }, {
                    title: 'Table styles'
                }, {
                    title: 'Table row 1',
                    selector: 'tr',
                    classes: 'tablerow1'
                }],

            templates: [{
                    title: 'Test template 1',
                    content: 'Test 1'
                }, {
                    title: 'Test template 2',
                    content: 'Test 2'
                }]
        });
        create_new_page();
    };
    var droppable_disable = function () {
        j("#b").droppable({
            drop: function (event, ui) {
                dragValue = ui.draggable.attr("data-drag-value");
                j.ajax({
                    url: _url + 'inquiry/updatepagestatusdisable',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_id": dragValue},
                    success: function (e) {
                        if (e.message === 'success') {
                            var template_value = j(".templatefield").val();
                            j.notify(e);

                        }
                    }
                });
                return false;
            }
        });
    };

    var dragable = function () {
        j("#a, #b, #c").sortable({
            connectWith: ".connectedSortable",
            start: function (e, ui) {
                // creates a temporary attribute on the element with the old index
                j(this).attr('data-previndex', ui.item.index());
            },
            update: function (e, ui) {
                // gets the new and old index then removes the temporary attribute
                var newIndex = ui.item.index();
                var oldIndex = $(this).attr('data-previndex');
                var element_id = ui.item.attr('data-drag-value');
                console.log('id of Item moved = ' + element_id + ' old position = ' + oldIndex + ' new position = ' + newIndex);
                j(this).removeAttr('data-previndex');

                j.ajax({
                    url: _url + 'inquiry/sortpage',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_id": element_id, "get_value": newIndex},
                    success: function (e) {
                        console.log('Sorted');
                    }
                });
                /* return false; */


            }
        });

//$( "#a" ).draggable();
        j("#c").droppable({
            accept: ".acceptable",
            drop: function (e, ui) {
                var dropped = ui.draggable;
                var droppedOn = $(this);
                j(this).append(dropped.clone().removeAttr('style').removeClass("item").addClass("item-container"));
                dropped.remove();
            }
        });
    };
    var onchangedatefield = function () {
        j('.xeroreport').unbind().bind('change', function () {
            var value = j(this).val();

            if (value === 'TrialBalance') {
                _html = "<input type='date' name='getdate' class='getdate form-control'>";

            } else if (value === 'BalanceSheet') {
                _html = "<input type='date' name='getdate' class='getdate form-control'>";
            } else if (value === 'BudgetSummary') {
                _html = "<input type='date' name='getdate' class='getdate form-control'>";
            } else if (value === 'ProfitAndLost') {
                _html = "<label><strong>From</strong></label><input type='date' name='fromDate' class='getdate form-control' placeholder='From'><label><strong>To</strong></label><input type='date' name='toDate' placeholder='To' class='getdate form-control'>";
            } else {
                _html = "";
            }
            j('.date-field').html(_html);
        });
    };
    var onchanagesingleselect = function () {
        j('.selectvalue').unbind().bind('change', function () {
            var value = j(this).val();
            console.log(value);
            if (value === 'xeroreports') {
                var contents = "<select name='xeroreport' class='xeroreport form-control'><option value=''>Select</option><option value='TrialBalance'>Trial Balance</option><option value='BalanceSheet'>Balance Sheet</option><option value='BudgetSummary'>Budget Summary</option><option  value='ProfitAndLost'>Profit and Lost</option></select>";
                htmlEditortinymce();
            } else if (value === 'htmleditor') {
                var contents = "<textarea width='100%' height='800' name='htmltxtarea' class='htmltxtarea'></textarea>";
                htmlEditortinymce();
            }
            j('.bind-content').html(contents);
            update_contents();
            htmlEditortinymce();
            onchangedatefield();
        });
    };
    var onchangetemplate = function () {
        j('.select_template_view').unbind().bind('change', function () {
            var _this = j(this);
            var value = _this.val();

            if (value == 'none') {
                j("#a").html("");
                j("#b").html("");
                j('.labeldragabble').addClass("hide");
            } else {
                j('.labeldragabble').removeClass("hide");
                j.ajax({
                    url: _url + 'Inquiry/layout_list',
                    method: 'post',
                    data: {"get_id": value},
                    success: function (e) {
                        var _len = e.length;
                        count = 0;
                        _html = '';
                        _html_disable = '';
                        for (var i = 0; i < _len; i++) {
                            count++;
                            if (e[i].status === 'Active') {
                                _html += ("<li class='acceptable' data-drag-value ='" + e[i].ID + "' ><span>" + e[i].page_title + "</span><span> <button data-toggle='modal' data-target='#editpage' type='button' data-backdrop='static' data-keyboard='false' class='btn btn-default btn-xs update-page' edit-template='" + e[i].template_id + "' edit-id='" + e[i].ID + "' backdrop='static'>Edit</button></span></li>");

                            } else {
                                _html_disable += ("<li class='acceptable' data-drag-value ='" + e[i].ID + "' ><span>" + e[i].page_title + "</span><span> <button data-toggle='modal' data-target='#editpage' type='button' data-backdrop='static' data-keyboard='false' class='btn btn-default btn-xs update-page' edit-template='" + e[i].template_id + "' edit-id='" + e[i].ID + "' backdrop='static'>Edit</button></span></li>");
                            }

                            j("#a").html(_html);
                            j("#b").html("<li class='acceptable'>Default Page</li>" + _html_disable);
                            update_pages_layout();
                            htmlEditortinymce();
                        }

                    }
                });
                return false;
            }

        });
    };

    var update_pages_layout = function () {
        j('.update-page').click(function (e) {
            e.preventDefault();
            //  console.log('edit button was click'+ jQuery(this).attr('edit-id'));
            var value = j(this).attr('edit-id');
            var valuetemplate = j(this).attr('edit-template');
            var giveValue = j(".pagegivenvalue").val(value);
            j.ajax({
                url: _url + 'inquiry/getinformationpage',
                dataType: 'json',
                method: 'post',
                data: {"get_id": value},
                success: function (data) {
                    console.log(data);

                    var _len = data.length;
                    //for (var i = 0; i < _len; i++) {
                    console.log(data.html);
                    var title = data.page_title + "/" + data.template_name;
                    var html = data.html;
                    j('.page-title-modal').html(title);
                    j('.bodypage').html(html);
                    /*
                     var title =  e[i].page_title + "/" + e[i].template_name;
                     var html =  e[i].html;
                     j('.page-title-modal').html(title);
                     j('.bodypage').html(html);
                     */
                    //}
                    j('.hiddenfieldtemplate').val(valuetemplate);
                    j('.hiddenfield').val(value);
                    onchanagesingleselect();
                    htmlEditortinymce();

                }

            });
        });
    };
    /*
     var printpageinfo  =function(){
     var value = j('.pagegivenvalue').val();
     j.ajax({
     url: _url + 'inquiry/getinformationpage',
     dataType: 'json',
     method: 'post',
     data: {"get_id": value},
     success: function (e) {
     
     }
     });
     return false;
     
     };
     */
    var update_contents = function () {
        j('.pageedit').validate({
            rules: {

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
                    url: _url + 'Inquiry/update_content_details',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        console.log(e);
                        if (e.text === 'success') {
                            var template_value = j(".templatefield").val();
                            j.notify(e);
                        } else if (e.text === 'failed') {
                            j.notify(e);
                        }
                    }
                });
                return false;

            }
        });
    };
    var create_pages = function () {
        j('.create_layout').validate({
            rules: {
                "pagetitle": {required: true},
                "tempalte_option": {required: true}
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
                    url: _url + 'Inquiry/addlayout',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.message === 'success') {
                            var template_value = j(".templatefield").val();
                            j.notify(e);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);

                        } else if (e.message === 'notemplate') {
                            j.notify(e);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        } else if (e.message === 'exist') {
                            j.notify(e);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);
                        }
                    }
                });
                return false;
            }
        });
    };
    function  load_template() {
        var _val = j('.load');
        _val.unbind().bind('click', function (e) {
            var _this = j(this);
            var value = _this.attr("id-edit");
            j.ajax({
                url: _url + 'inquiry/load_template',
                dataType: 'json',
                method: 'post',
                data: {"get_id": value},
                success: function (e) {
                    if (e.message === 'success') {
                        j.notify(e);
                        setTimeout(function () {
                            location.reload();
                        }, 2000);

                    }
                }
            });
            return false;
        });
    }
    ;
    function  delete_template() {
        var _val = j('.deletetxtfield');
        _val.unbind().bind('click', function (e) {
            var _this = j(this);
            var value = _this.attr("id-edit");
            var retVal = confirm("Continue or Cancel?");
            if (retVal == true) {
                j.ajax({
                    url: _url + 'inquiry/delete_template',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_id": value},
                    success: function (e) {
                        if (e.message === 'success') {
                            j.notify(e);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);

                        }
                    }
                });
                return false;
            } else {
                j.notify(e);
            }
        });
    }
    ;
    function template_lists() {

        j.ajax({
            url: _url + 'Inquiry/template_list',
            dataType: 'json',
            method: 'post',
            data: {"id": "log"},
            success: function (e) {
                e.preventDefault();
                _html = '';
                var _len = e.length;
                var count = 0;
                _html += ("<thead><tr><th>#</th><th>Template Name</th><th>Action</th></tr></thead><tbody>");
                for (var i = 0; i < _len; i++) {
                    count++;
                    _html += ("<tr><td>" + count + "</td><td class='" + e[i].ID + "'>" + e[i].template_name + "</td></tr>");
                }
                _html += ("</tbody>");
                j("#example").html(_html);
                $("#example").DataTable();

            }
        });
        return false;

    }
    var parse_value_template = function () {
        var trigger = j(".edit-value");
        var modalbox = j(".template-form");
        j("#example").on("click", ".edit-value", function () {
            var _this = j(this);
            var valueid = _this.attr('id-edit');
            var name = _this.attr('data-name');
            j('.editfield').val(name);
            j('.idtemplatehfield').val(valueid);
        });
    };
    var datatables = function () {
        j('#example').dataTable({
            "dom": 'T<"clear">lfrtip',
            "tableTools": {
                "sSwfPath": "http://cdn.datatables.net/tabletools/2.2.2/swf/copy_csv_xls_pdf.swf"
            }
        });
    };
    var generate_pagination = function () {
        var _val = j('.template-page');
        _val.unbind().bind('click', function (e) {
            _val.each(function () {
                var _this = j(this);
                var this_id = _this.attr('data-id');
                var insertvalue = j('.valuepagination').val(this_id);
                _this.click(function () {
                    /*console.log('Pagination was clicked!' + this_id); */
                    j('.template-page').removeClass("pagination-active");
                    _this.addClass("pagination-active");

                    j.ajax({
                        url: _url + 'Inquiry/pagination_data',
                        method: 'post',
                        data: {"insert_value": this_id},
                        success: function (e) {
                            /*  console.log(e); */
                            _html = '';
                            var _len = e.length;
                            for (var i = 0; i < _len; i++) {
                                /*  data-toggle='modal' data-target='#myModal' _html += ("<tr><td>"+e[i].ID+"</td><td> <input type='text' value='"+e[i].template_name+"' class='form-control noborder'></td><td><td title='Edit'><button class='btn btn-sm btn-success' name='edittxtfield' id-edit='"+e[i].template_name+"' ><i class='fas fa-pen-square'></i></button>&nbsp;<button name='deletetxtfield' class='btn btn-sm btn-danger' id-edit='"+e[i].template_name+"' ><i class='fas fa-trash'></i></button></td></td></tr>"); */
                                _html += ("<form class='edit-template-page tr' novalidate='novalidate'><div class='td'>" + e[i].ID + "</div><div class='td'><input type='text' value='" + e[i].template_name + "'  class='form-control noborder textfieldname' name='textfieldname'></div><div class='td'> <input type='hidden' name='IDT' value='" + e[i].ID + "'><button type='submit' name='edittxtfield' class='btn btn-sm btn-success edittemplatedata' id-edit='" + e[i].ID + "' ><i class='fas fa-pen-square'></i></button>&nbsp;<button class='btn btn-sm btn-danger' name='deletetxtfield' id-edit='" + e[i].ID + "' ><i class='fas fa-trash'></i></button></div></form>");
                            }
                            j('.tablelisttemplate').addClass('hide');
                            j('.tablepaginationupdate').removeClass('hide');
                            j('.tablepaginationupdate').html(_html);


                        }
                    });
                    return false;

                });
            });
        });


    };
    var template_update_page = function () {
        var _form = j('.edit-template-page');
        _form.unbind().bind('click', function (e) {
            _form.each(function () {
                var _this = j(this);
                _this.validate({
                    rules: {
                        "textfieldname": {required: true}
                    },
                    showErrors: function (errorMap, errorList) {
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
                    },
                    submitHandler: function (form) {
                        var _form = j(form);

                        j.ajax({
                            url: _url + 'Inquiry/updatelisttemplate',
                            dataType: 'json',
                            method: 'post',
                            data: _form.serialize(),
                            success: function (e) {
                                //console.log(e);
                                if (e.message === 'success') {
                                    j.notify(e);
                                } else if (e.message === 'failed') {
                                    j.notify(e);
                                } else if (e.message === 'exist') {
                                    j.notify(e);
                                }
                            }
                        });
                        return false;
                    }
                });
            });
        });

    };
    var template_update = function () {
        var _form = j('.edit-template');
        _form.unbind().bind('click', function (e) {
            _form.each(function () {
                var _this = j(this);
                _this.validate({
                    rules: {
                        "editfield": {required: true}
                    },
                    showErrors: function (errorMap, errorList) {
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
                    },
                    submitHandler: function (form) {
                        var _form = j(form);

                        j.ajax({
                            url: _url + 'Inquiry/updatelisttemplate',
                            dataType: 'json',
                            method: 'post',
                            data: _form.serialize(),
                            success: function (e) {
                                if (e.message === 'success') {

                                    /*  $('#example').load(document.URL +  ' #example'); */

                                    j.notify(e);
                                    setTimeout(location.reload.bind(location), 1000);
                                } else if (e.message === 'failed') {
                                    j.notify(e);
                                } else if (e.message === 'exist') {
                                    j.notify(e);
                                }
                            }
                        });
                        return false;
                    }
                });
            });
        });

    };

    var create_template = function () {
        j('.createtemplate').validate({
            rules: {
                "template": {required: true}
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
                    url: _url + 'Inquiry/addtemplate',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.text === 'success') {
                            var template_value = j(".templatefield").val();
                            setTimeout(function () {
                                j.notify(e);
                                j(".templatelist").append("<tr><td></td><td>" + template_value + "</td></tr>");
                                location.reload();
                            }, 1000);

                        } else if (e.text === 'exist') {
                            j.notify(e);
                        }
                    }
                });
                return false;
            }
        });
    };
    var pdfSRC = function () {
        function readURL(input) {
            var reader = new FileReader();
            var srcget = reader.readAsDataURL(input.files[0]);
            reader.onload = function (e) {
                var IMG = j('#image_upload_preview').attr('src', e.target.result);
                var HASHimg = e.target.result;

                j.ajax({
                    url: _url + 'inquiry/session_images',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_img": HASHimg},
                    success: function (e) {
                        if (e.message === 'success') {
                            console.log(e.text);
                        }
                    }
                });

            }
        }
        j("#inputFile").change(function () {
            readURL(this);
        });
    };
    var xero_connect = function () {
        j('.xero-connect-form').validate({
            rules: {
                "Clientname": {required: true},
                "APIKey": {required: true},
                "APISecret": {required: true}
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


                        if (myJSON === 'OK') {

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
                            j(".reportframe").attr('src', 'PDFPage/?key=' + APIKEY + '&secret=' + APISECRET + '&img=');
                        } else {
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
    var delete_calendar = function () {
        j('.delete-calendar').unbind().bind('click', function (e) {
            e.preventDefault();
            var _this = j(this);
            j.cnfrm({
                title: "Confirm",
                text: "Are you sure you want to delete this post?"
            }, function () {
                j.ajax({
                    url: _url + 'inquiry/delete_calendar',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_id": _this.attr('data-id')},
                    success: function (e) {
                        if (e.message === 'success') {

                            j.notify(e);
                            j(".e_" + _this.attr('data-id')).addClass("hide");

                        }
                    }
                });
            });
            return false;
        });
    };
    var calendar_modal_now = function () {
        var _adduser = j(".calendar_view");
        var modalbox = j(".modal_calendar");
        _adduser.click(function () {
            modalbox.modal({backdrop: 'static', keyboard: false});
        });
        modalbox.find('.close').click('click', function (e) {
            e.preventDefault();
            modalbox.modal('hide');
        });
    };
    var tip_title = function () {
        j('li').tooltip();
    };


    var session_get = function () {



        j.ajax({
            url: _url + 'inquiry/getsession',
            method: 'post',
            dataType: 'json',
            success: function (e) {
                if ((e.user_position === '1') || (e.user_position === '2')) {
                    j('.eventtoday').addClass("hide");
                    //  console.log("adminvalidation");
                }

            }
        });

    };
    var settingsnav = function () {
        j('.info-tabs a').click(function (e) {
            e.preventDefault();
            j(this).tab('show');
        });
    };
    var viewallcalendar = function () {
        j('.calendar_all_button').click(function (e) {

            j(".calendarviewall").removeClass('hide');
            j(".calendar_all_button").addClass('hide');
            j(".calendar_hide_button").removeClass('hide');

        });
        j('.calendar_hide_button').click(function (e) {
            j(".less").addClass('hide');
            j(".calendar_all_button").removeClass('hide');
            j(".calendar_hide_button").addClass('hide');

        });
    };
    var edit_profile_modal = function () {
        var _update = j('.modal-profile');
        j('.edit-profile').unbind().bind('click', function (e) {
            e.preventDefault();
            var _this = j(this);
            _update.modal({backdrop: 'static', keyboard: false});
        });
        _update.find('.close').unbind().bind('click', function (e) {
            e.preventDefault();
            _update.modal('hide');
        });
    };
    var modal_todays_event = function () {
        var _update = j('.modal_todays_event');
        var _trigger = j('.eventtoday');
        _trigger.unbind().bind('click', function (e) {
            e.preventDefault();
            var _this = j(this);
            var _get_id = _this.attr('data-identifier');
            //    console.log(_get_id + " todays event");
            j.ajax({
                url: _url + 'inquiry/getcalendarinfo',
                dataType: 'json',
                method: 'post',
                data: {'getcalendarid': _get_id},
                success: function (e) {
                    var titlefield = e[0].title;
                    var datevalue = e[0].year + '-' + e[0].month + '-' + e[0].day;
                    var organizerfield = e[0].organizer;
                    var descriptionfield = e[0].description;
                    var start = e[0].start_time;
                    var end = e[0].end_time;
                    var location = e[0].location;
                    var category = e[0].category;
                    var ID = e[0].ID;
                    var year = e[0].year;
                    var month = e[0].month;
                    var day = e[0].day;
                    var concadate = year + '-' + month + '-' + day
                    j('.titleview').val(titlefield);
                    j('.descriptionfield').val(descriptionfield);
                    j('.organizerfield').val(organizerfield);
                    j('.clockpickerstart').val(start);
                    j('.clockpickerend').val(end);
                    j('.locationedit').val(location);
                    j('.categoryedit').val(category);
                    j('.date_value').val(month + "/" + day + "/" + year);
                    j('.dateid').val(ID);
                }
            });


            _update.modal({backdrop: 'static', keyboard: false});
        });
        _update.find('.close').unbind().bind('click', function (e) {
            e.preventDefault();
            _update.modal('hide');
        });
    };
    var updateeventsdata = function () {
        j('.calendar_event_update').validate({
            rules: {
                "titleview": {required: true},
                "organizeredit": {required: true},
                "categoryedit": {required: true},
                "locationedit": {required: true},
                "descriptionfield": {required: true}
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
                    url: _url + 'inquiry/update_event',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.message === 'success') {
                            _html = '';
                            setTimeout(function () {
                                j(".modal_calendar_event").modal('hide');
                                j('.calendar_event_create').trigger("reset");

                                j.notify(e);
                            }, 1000);
                            /* _html += ( '<li class="calendarviewall  '+j('#titleview').val()+'"> <a > <div class="row"> <div class="col-8"> <span class="muted" style="color:#49c4d0;font-weight:bold;"> '+j('.date_value ').val()+'</span> </div><div class="col-4 text-right" > <button class="btn btn-outline-secondary btn-sm eventtoday" data-identifier="'+j('.dateid').val()+'" ><i class="fas fa-pencil-alt"></i></button> </div></div><strong>'+j('.titleview').val()+'</strong> <span style="font-size:8px;"> By '+j('.organizerfield').val()+'</span><br/> <p> '+j('.descriptionfield').val()+' </p><span class="muted" style="color:#49c4d0;">Start at '+j('.clockpickerstart').val()+' end at '+j('.clockpickerend').val()+' </span> </a></li>');*/
                            _html = "<li>sda</li>";
                            j('.mainul').append(_html);

                        }

                    }
                });
                return false;
            }
        });
    };
    var updatepersonalinformation = function () {
        j('.acountsinfoform').validate({
            rules: {
                "fname": {required: true},
                "lname": {required: true},
                "email": {
                    required: true,
                    email: true
                },
                "birthday": {required: true}
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
            }
            , submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'inquiry/accountinfo',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        j.notify(e);
                        window.location();
                    }
                });
                return false;
            }
        });
    };

    var calendarpickerbootstrapbirthday = function () {
        j('.date2').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: "mm/dd/yy",
            yearRange: "-70:-1"
        });
    };

    var passwordchange = function () {
        j('.passwordforminput').validate({
            rules: {
                "cpassword": {required: true},
                "rpassword": {required: true},
                "npassword": {
                    required: true,
                    equalTo: "#npassword"
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
            }

            , submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'inquiry/passwordchange',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {

                        if (e.message === 'currentpassword') {
                            j.notify(e);
                            window.location();
                        } else if (e.message === 'failed') {
                            j.notify(e);
                            window.location();
                        } else {
                            j.notify(e);
                            window.location();
                        }

                    }
                });
                return false;
            }
        });
    };
    var calendarpickerbootstrap = function () {
        j('.date1').datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            dateFormat: "mm/dd/yy"
        });
    };
    var timeat = function () {
        j('.clockpicker').clockpicker({
            donetext: 'Done'
        });
        j('.clockpicker-button').html("select");
    };

    var logout = function () {
        var _logout = j('.logout-btn');
        _logout.click(function (e) {
            e.preventDefault();
            j.ajax({
                url: _url + 'inquiry/logout',
                method: 'post',
                dataType: 'json',
                success: function (e) {
                    if (e.message === 'success') {
                        setTimeout(function () {
                            window.location.reload();
                        }, 3000);
                    }
                }
            });
        });
    };

    var delete_profile = function () {
        j('.delete-profile').unbind().bind('click', function (e) {
            e.preventDefault();
            var _this = j(this);
            j.cnfrm({
                title: "Confirm",
                text: "Are you sure you want to delete this post?"
            }, function () {
                j.ajax({
                    url: _url + 'inquiry/delete_profile',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_id": _this.attr('data-id')},
                    success: function (e) {
                        if (e.message === 'success') {
                            j.notify(e);
                            window.location();

                        }
                    }
                });
            });
            return false;
        });
    };

    var calendar_json = function () {

        j.ajax({
            url: _url + 'inquiry/setEvents',
            method: 'post',
            dataType: 'json',
            success: function (e) {
                calendar_modal(e);
            }
        });


    };

    var calendar_json_demo = function () {

        j.ajax({
            url: _url + 'inquiry/setEvents',
            method: 'post',
            dataType: 'json',
            success: function (e) {
                calendar_modal_demo(e);
            }
        });


    };



    var calendar_modal = function (_e) {
        //  console.log(_e);
        j('.calendar').pignoseCalendar({

            select: function (date, context) {
                //  console.log('events for this date', context.storage.schedules);
            }

            , click: function (event, context) {
                var _this = j(this);
                var date_selected = (j(_this[0]).attr('data-date'));
                //  console.log(date_selected + "selected validation");
                var modalcalendarbox = j(".modal_calendar_event");
                var _html = '';
                var data = date_selected;
                var arr = data.split('-');
                var day = arr[2];
                var month = arr[1];
                var year = arr[0];

                if (month == 01) {
                    var month_caption = 'January';
                } else if (month == 02) {
                    var month_caption = 'February';
                } else if (month == 03) {
                    var month_caption = 'March';
                } else if (month == 04) {
                    var month_caption = 'April';
                } else if (month == 05) {
                    var month_caption = 'May';
                } else if (month == 06) {
                    var month_caption = 'June';
                } else if (month == 07) {
                    var month_caption = 'July';
                } else if (month == 08) {
                    var month_caption = 'August';
                } else if (month == 09) {
                    var month_caption = 'September';
                } else if (month == 10) {
                    var month_caption = 'October';
                } else if (month == 11) {
                    var month_caption = 'November';
                } else if (month == 12) {
                    var month_caption = 'December';
                }
                j(".date_caption").html(data);
                j(".input_date_value").val(month + '/' + day + '/' + year);
                j(".date_retrieve").html(month_caption);
                j(".datevalue").val(date_selected);
                modalcalendarbox.modal({backdrop: 'static', keyboard: false});
                //  console.log("calendar has been clicked");
                modalcalendarbox.modal("show");
                j.ajax({
                    url: _url + 'inquiry/eventbox',
                    method: 'post',
                    data: {"get_id": date_selected},
                    success: function (e) {
                        var _len = e.length;
                        if (_len === 0) {
                            _html += ("<div class='alert alert-warning'><strong>No event</strong> was set on this month!</div>");
                        } else {
                            for (var i = 0; i < _len; i++) {
                                if (e[i].title) {
                                    var desc = e[i].description.substring(0, 25) + "...";
                                    var caption = e[i].title.substring(0, 35);
                                    _html += ('<li class="calendarviewall  ' + show_calendar + '"> <a > <div class="row"> <div class="col-8"> <span class="muted" style="color:#49c4d0;font-weight:bold;"> ' + e[i].month + '/' + e[i].day + '/' + e[i].year + '</span> </div><div class="col-4 text-right" > <button class="buttonnocss eventtoday" data-identifier="' + e[i].ID + '" ><i class="fas fa-pencil-alt"></i></button> <button class="buttonnocss delete-calendar"  data-toggle="tooltip" title="Delete"  data-id="' + e[i].ID + '""  ><i class="far fa-trash-alt"></i></button></div></div><strong>' + e[i].title + '</strong> <span style="font-size:8px;"> By ' + e[i].organizer + '</span><br/> <p> ' + e[i].description + ' </p><span class="muted" style="color:#49c4d0;">Start at ' + e[i].start_time + ' end at ' + e[i].end_time + ' </span> </a></li>');
                                }
                            }
                        }
                        j(".grid-row").html('').append(_html);
                        get_calendar_data();

                    }
                });
                event.preventDefault();
            }, prev: function (info, context) {


                j.ajax({
                    url: _url + 'inquiry/calendar_month',
                    dataType: 'json',
                    method: 'post',
                    data: {'month_now': info.month, 'year_now': info.year},
                    success: function (e) {
                        _html = '';
                        var _len = e.length;
                        for (var i = 0; i < _len; i++) {

                            if (i <= 5) {
                                var show_calendar = "";
                            } else {
                                var show_calendar = "hide less";
                            }


                            title = e[i].title;
                            _html += ('<li class="calendarviewall  ' + show_calendar + ' e_' + e[i].ID + '"> <a > <div class="row"> <div class="col-8"> <span class="muted" style="color:#49c4d0;font-weight:bold;"> ' + e[i].month + '/' + e[i].day + '/' + e[i].year + '</span> </div><div class="col-4 text-right" > <button class="buttonnocss eventtoday" data-identifier="' + e[i].ID + '" ><i class="fas fa-pencil-alt"></i></button> <button class="buttonnocss delete-calendar"  data-toggle="tooltip" title="Delete"  data-id="' + e[i].ID + '""  ><i class="far fa-trash-alt"></i></button></div></div><strong>' + e[i].title + '</strong> <span style="font-size:8px;"> By ' + e[i].organizer + '</span><br/> <p> ' + e[i].description + ' </p><span class="muted" style="color:#49c4d0;">Start at ' + e[i].start_time + ' end at ' + e[i].end_time + ' </span> </a></li>');
                        }
                        j(".eventbox").html("<ul>" + _html + "</ul>");

                        //   console.log(e);
                        modal_todays_event();
                        viewallcalendar();
                        session_get();
                        delete_calendar();
                    }
                });
            }, next: function (info, context) {
                j.ajax({
                    url: _url + 'inquiry/calendar_month',
                    dataType: 'json',
                    method: 'post',
                    data: {'month_now': info.month, 'year_now': info.year},
                    success: function (e) {
                        _html = '';
                        var _len = e.length;
                        for (var i = 0; i < _len; i++) {
                            if (i <= 5) {
                                var show_calendar = "";
                            } else {
                                var show_calendar = "hide less";
                            }


                            title = e[i].title;
                            _html += ('<li class="calendarviewall  ' + show_calendar + ' e_' + e[i].ID + '"> <a > <div class="row"> <div class="col-8"> <span class="muted" style="color:#49c4d0;font-weight:bold;"> ' + e[i].month + '/' + e[i].day + '/' + e[i].year + '</span> </div><div class="col-4 text-right" > <button class="buttonnocss eventtoday" data-identifier="' + e[i].ID + '" ><i class="fas fa-pencil-alt"></i></button> <button class="buttonnocss delete-calendar"  data-toggle="tooltip" title="Delete"  data-id="' + e[i].ID + '""  ><i class="far fa-trash-alt"></i></button></div></div><strong>' + e[i].title + '</strong> <span style="font-size:8px;"> By ' + e[i].organizer + '</span><br/> <p> ' + e[i].description + ' </p><span class="muted" style="color:#49c4d0;">Start at ' + e[i].start_time + ' end at ' + e[i].end_time + ' </span> </a></li>');
                        }
                        j(".eventbox").html("<ul>" + _html + "</ul>");
                        //console.log(e);
                        modal_todays_event();
                        viewallcalendar();
                        session_get();
                        delete_calendar();
                    }
                });
            }, scheduleOptions: {
                colors: {
                    1: '#1abc9c',
                    2: '#3498db',
                    3: '#9b59b6',
                    4: '#5c6270',
                    5: '#e67e22',
                    6: '#E9D460',
                    7: '##c0392b',
                    8: '#5c6270',
                    9: '#d35400',
                    10: '#bdc3c7',
                    11: '#32ff7e',
                    12: '#18dcff'
                }
            },
            schedules: _e,
            select: function (date, context) {
                //console.log('events for this date', context.storage.schedules);
            }

        });

        j(".calendarform").click(function () {
            j(".reset").val();
            j(".addeventsform").removeClass("hide");
            j(".calendarform").addClass("hide");
            j(".calendarformcaption").removeClass("hide");
            j(".calendardetails").addClass("hide");
            j(".editcalendar").addClass("hide");

        });
        j(".calendarformcaption").click(function () {
            j(".addeventsform").addClass("hide");
            j(".calendarform").removeClass("hide");
            j(".calendarformcaption").addClass("hide");
            j(".calendardetails").removeClass("hide");
            j(".editcalendar").addClass("hide");
        });



        //  console.log(_e);


    };
    var calendar_modal_demo = function (_e) {
        //  console.log(_e);
        j('.calendardemo').pignoseCalendar({

            scheduleOptions: {
                colors: {
                    1: '#1abc9c',
                    2: '#3498db',
                    3: '#9b59b6',
                    4: '#5c6270',
                    5: '#e67e22',
                    6: '#E9D460',
                    7: '##c0392b',
                    8: '#5c6270',
                    9: '#d35400',
                    10: '#bdc3c7',
                    11: '#32ff7e',
                    12: '#18dcff'
                }
            },
            schedules: _e, select: function (date, context) {
                //  console.log('events for this date', context.storage.schedules);
            }

        });

        j(".calendarform").click(function () {
            j(".reset").val();
            j(".addeventsform").removeClass("hide");
            j(".calendarform").addClass("hide");
            j(".calendarformcaption").removeClass("hide");
            j(".calendardetails").addClass("hide");
            j(".editcalendar").addClass("hide");

        });
        j(".calendarformcaption").click(function () {
            j(".addeventsform").addClass("hide");
            j(".calendarform").removeClass("hide");
            j(".calendarformcaption").addClass("hide");
            j(".calendardetails").removeClass("hide");
            j(".editcalendar").addClass("hide");
        });
        //  console.log(_e);
    };



    var add_event_modal = function () {
        j(".addcalendar").click(function () {
            var modalcalendarbox = j(".add_event_modal");
            //console.log("add event has been clicked");
            modalcalendarbox.modal("show");

        });
    };

    var execute_delete_record = function () {
        j(".delete-user-record").click(function () {
            var value_id = j(".delete_id_value").val();
            j.ajax({
                url: _url + 'inquiry/delete_employee',
                method: 'post',
                data: {"get_id": value_id},
                success: function (e) {
                    if (e.message === 'success') {
                        //  console.log("Deleted");
                    } else {
                        //console.log("Error");
                    }
                }
            });
        });
    };
    var view_modal = function () {
        var _adduser = j(".add-user");
        var modalbox = j(".modal-view-user");
        _adduser.click(function () {
            modalbox.modal({backdrop: 'static', keyboard: false});
        });
        modalbox.find('.close').click('click', function (e) {
            e.preventDefault();
            modalbox.modal('hide');
        });
    };
    var user_modal_delete = function () {

        j(".delete-user").click(function () {
            var date_selected = j(this).attr('data-id');
            var modaldelete = j(".modal_deletet_confirmation");
            modaldelete.modal("show");
            j(".delete_id_value").val(date_selected);

        });
    };

    var submit_tags = function ($id, $data) {
        j.ajax({
            url: _url + 'inquiry/tagging',
            method: 'post',
            dataType: 'json',
            data: {"get_id": $id, "group_id": $data.item_id, "type": $data.type},
            success: function (data) {

            }
        });
    };


    var modaltagingjs = function () {
        var _mod = j('.tag-group-user');
        var _modal = j('.modal-tag');
        _mod.unbind().bind('click', function () {
            var _this = j(this);
            var _html = '';
            var _tags = '';
            _modal.modal({backdrop: 'static', keyboard: false});
            _modal.find('.id-tag-group').val(_this.attr('href'));
            j.ajax({
                url: _url + 'inquiry/gettag',
                method: 'post',
                dataType: 'json',
                data: {"postid": _this.attr('href')},
                success: function (data) {
                    //  console.log(data);
                    for (var i = 0; i < data.length; i++) {
                        _html += ('<div class="tag-selector" data-bind="' + data[i].GID + '"><div class="tag-group">' + data[i].group_name + '</div></div>');
                        _tags += ('<span class="badge badge-info">' + data[i].group_name + '</span> ');
                    }
                    _modal.find('.span-tag').html(_html);
                    j('.post-tag-groups[data-tag="' + _this.attr('href') + '"]').html(_tags);
                    j('.tag-options').autoTag({
                        url: _url + 'request/tag_group_option',
                        callback: function (data) {
                            //  console.log(data);
                            submit_tags(_this.attr('href'), data);
                        }
                    });
                }
            });
            return false;
        });
        _modal.find('.close').unbind().bind('click', function () {
            _modal.modal('hide');
            return false;
        });
    };
    var getgroup = function (id) {
        var tag_dept = '';
        j.ajax({
            url: _url + 'inquiry/gettag',
            dataType: 'json',
            method: 'post',
            data: {'gettag': id},
            success: function (e) {
                if (e.length) {
                    var _len = e.length;
                    for (var i = 0; i < _len; i++) {
                        tag_dept += e[i].group_name;
                    }
                }
                j(".tagappend").html("<h1>" + tag_dept + "</h1>");
                j('.taggroup').val(tag_dept);
            }
        });
    };
    var dateToString = function (FromString) {
        var now = new Date(FromString * 1000);
        var dd = now.getDate();
        var mm = now.getMonth() + 1;
        var yyyy = now.getFullYear();
        var hh = now.getHours();
        var ii = now.getMinutes();
        var ss = now.getSeconds();
        if (mm < 10) {
            mm = '0' + mm;
        }
        if (dd < 10) {
            dd = '0' + dd;
        }
        if (ii < 10) {
            ii = '0' + ii;
        }
        if (ss < 10) {
            ss = '0' + ss;
        }
        var result = (mm + "/" + dd + "/" + yyyy);
        return result;
    };
    var view_modal_update = function () {
        var trigger = j(".edit-user");
        var modalbox = j(".modal_edit_user");
        trigger.click(function () {
            var _this = j(this);
            modalbox.modal({backdrop: 'static', keyboard: false});
            calendarpickerbootstrap();
            var valueid = _this.attr('data-id');
            j.ajax({
                url: _url + 'inquiry/getusersinfo',
                dataType: 'json',
                method: 'post',
                data: {'getusersinfo': valueid},
                success: function (e) {
                    var emp_no = e[0].employee_id_no;
                    var first_name = e[0].first_name;
                    var middle_name = e[0].middle_name;
                    var last_name = e[0].last_name;
                    var gender = e[0].gender;
                    var civil_status = e[0].civil_status;

                    if (parseInt(e[0].date_of_birth) === 0) {
                        var date_of_birth = '';
                    } else {
                        var date_of_birth = dateToString(e[0].date_of_birth);
                    }
                    var contact = e[0].contact;
                    var permanent_address = e[0].permanent_address;
                    var current_address = e[0].current_address;
                    var email = e[0].email;
                    var department = e[0].department;
                    var client_name = e[0].client_name;
                    var segment = e[0].segment;
                    var department_id = e[0].department_id;
                    var location = e[0].location;
                    var site = e[0].site;
                    var job_code = e[0].job_code;
                    var job_title = e[0].job_title;
                    var job_level_grade = e[0].job_level_grade;
                    var payroll_type = e[0].payroll_type;
                    var employee_type = e[0].employee_type;
                    var employment_status = e[0].employment_status;
                    var hr_status = e[0].hr_status;

                    if (parseInt(e[0].hire_date) === 0) {
                        var hire_date = '';
                    } else {
                        var hire_date = dateToString(e[0].hire_date);
                    }

                    if (parseInt(e[0].regularization_date) === 0) {
                        var regularization_date = '';
                    } else {
                        var regularization_date = dateToString(e[0].regularization_date);
                    }

                    if (parseInt(e[0].separation_date) === 0) {
                        var seperation_date = '';
                    } else {
                        var seperation_date = dateToString(e[0].separation_date);
                    }

                    var general_reason = e[0].general_reason;
                    var specific_reason = e[0].specific_reason;
                    var voluntary_involuntary = e[0].voluntary_involuntary;
                    var biometric_id = e[0].biometric_id;
                    var reports_to_employee_id_no = e[0].reports_to_employee_id_no;
                    var second_level_supervisor = e[0].second_level_supervisor;
                    var bilability = e[0].billability;
                    var employee_remarks = e[0].employee_remarks;
                    var schedule_type = e[0].schedule_type;
                    var payroll_pre_id = e[0].payroll_pie_id;
                    var highest_education_attainment = e[0].highest_education_attainment;
                    var college_degree = e[0].college_degree;
                    var major = e[0].major;
                    var institution = e[0].institution;
                    var prior_work_expirience = e[0].prior_work_experience;
                    var previous_employer = e[0].previous_employer;
                    var type_of_industry = e[0].type_of_industry;
                    var prc_license = e[0].prc_license_no;
                    var sss_no = e[0].sss_no;
                    var tin_no = e[0].tin_no;
                    var philhealth_no = e[0].philhealth_no;
                    var pag_ibig_no = e[0].pag_ibig_no;
                    var passport_no = e[0].passport_no;
                    var tax_status = e[0].tax_status;
                    var local_trunk_line = e[0].local_trunk_line;
                    var local_trunk_line_pin = e[0].local_trunk_line_pin;
                    var skype_id = e[0].skype_id;
                    var emergency_contact_name = e[0].emergency_contact_name;
                    var emergency_contact_no = e[0].emergency_contact_no;
                    var emergency_contact_relationship = e[0].emergency_contact_relationship;
                    var emergency_contact_address = e[0].emergency_contact_address;
                    var bank_name = e[0].bank_name;
                    var bank_account_no = e[0].bank_account_no;
                    var basic_salary = e[0].basic_salary;
                    var deminimis = e[0].deminimis;
                    var transportation_allowance = e[0].transportation_allowance;
                    var travel_allowance = e[0].travel_allowance;
                    var other_allowance = e[0].other_allowance;
                    var user_level = e[0].user_level;
                    var user_status = e[0].user_status;
                    var user_role = e[0].user_role;
                    var mainid = e[0].ID;
                    j('.emp_no').val(emp_no);
                    j('.first_name').val(first_name);
                    j('.middle_name').val(middle_name);
                    j('.last_name').val(last_name);
                    j('.gender').val(gender);
                    j('.civil_status').val(civil_status);
                    j('.date_of_birth').val(date_of_birth);
                    j('.contact').val(contact);
                    j('.permanent_address').val(permanent_address);
                    j('.current_address').val(current_address);
                    j('.email').val(email);
                    j('.department').val(department);
                    j('.client_name').val(client_name);
                    j('.segment').val(segment);
                    j('.department_id').val(department_id);
                    j('.location').val(location);
                    j('.site').val(site);
                    j('.job_code').val(job_code);
                    j('.job_title').val(job_title);
                    j('.job_level_grade').val(job_level_grade);
                    j('.payroll_type').val(payroll_type);
                    j('.employee_remarks ').val(employee_remarks);
                    j('.employee_type ').val(employee_type);
                    j('.employment_status').val(employment_status);
                    j('.hr_status').val(hr_status);
                    j('.schedule_type').val(schedule_type);
                    j('.hire_date').val(hire_date);
                    j('.regularization_date').val(regularization_date);
                    j('.seperation_dates').val(seperation_date);
                    j('.general_reason').val(general_reason);
                    j('.specific_reason').val(specific_reason);
                    j('.voluntary_involuntary').val(voluntary_involuntary);
                    j('.biometric_id').val(biometric_id);
                    j('.reports_to_employee_id_no').val(reports_to_employee_id_no);
                    j('.second_level_supervisor').val(second_level_supervisor);
                    j('.type_of_industry').val(type_of_industry);
                    j('.bilability').val(bilability);
                    j('.payroll_pre_id').val(payroll_pre_id);
                    j('.highest_education_attainment').val(highest_education_attainment);
                    j('.college_degree').val(college_degree);
                    j('.major').val(major);
                    j('.institution').val(institution);
                    j('.prior_work_expirience').val(prior_work_expirience);
                    j('.previous_employer').val(previous_employer);
                    j('.prc_license').val(prc_license);
                    j('.sss_no').val(sss_no);
                    j('.tin_no').val(tin_no);
                    j('.philhealth_no').val(philhealth_no);
                    j('.pag_ibig_no').val(pag_ibig_no);
                    j('.passport_no').val(passport_no);
                    j('.tax_status').val(tax_status);
                    j('.local_trunk_line').val(local_trunk_line);
                    j('.local_trunk_line_pin').val(local_trunk_line_pin);
                    j('.skype_id').val(skype_id);
                    j('.emergency_contact_name').val(emergency_contact_name);
                    j('.emergency_contact_no').val(emergency_contact_no);
                    j('.emergency_contact_relationship').val(emergency_contact_relationship);
                    j('.emergency_contact_address').val(emergency_contact_address);
                    j('.bank_account_no').val(bank_account_no);
                    j('.basic_salary').val(basic_salary);
                    j('.deminimis').val(deminimis);
                    j('.transportation_allowance').val(transportation_allowance);
                    j('.travel_allowance').val(travel_allowance);
                    j('.other_allowance').val(other_allowance);
                    j('.user_level').val(user_level);
                    j('.user_status').val(user_status);
                    j('.user_role').val(user_role);
                    j('.mainid').val(mainid);
                    getgroup(valueid);
                }

            });
        });
        modalbox.find('.close').click('click', function (e) {
            e.preventDefault();
            modalbox.modal('hide');
        });
    };

    var update_registration = function () {
        j('.update-reg-form').validate({
            rules: {
                "employee_id_no": {required: true},
                "first_name": {required: true},
                "last_name": {required: true},
                "civil_status": {required: true},
                "date_of_birth": {required: true},
                "contact": {required: true},
                "permanent_address": {required: true},
                "email": {required: true, email: true},
                "department": {required: true},
                "employment_status": {required: true},
                "hire_date": {required: true},
                "biometric_id": {required: true},
                "reports_to_employee_id_no": {required: true},
                "tin_no": {required: true},
                "user_level": {required: true}
            }
            , showErrors: function (errorMap, errorList) {
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
            }
            , submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'inquiry/register',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.type === 'update') {
                            var value = j(".mainid").val();
                            var first_name = j('.first_name').val();
                            var last_name = j('.last_name').val();
                            var emp_no = j('.emp_no').val();
                            var department = j('.department').val();
                            var email = j('.email').val();
                            var location = j('.location').val();
                            j(".fname_" + value).html(first_name + " " + last_name);
                            j(".employee_no_" + value).html(emp_no);
                            j(".department_" + value).html(department);
                            j(".email" + value).html(email);
                            j(".location" + value).html(location);
                            var modalbox = j(".modal_edit_user");
                            j.notify(e);
                            modalbox.delay(3000).hide(0, function () {
                                modalbox.modal('hide');
                            });

                        } else {
                            notify('You have successfully updated the information');
                        }
                    }
                });
                return false;
            }
        });
    };
    var registration = function () {
        j('.reg-form').validate({
            rules: {
                "employee_id_no": {required: true},
                "first_name": {required: true},
                "last_name": {required: true},
                "civil_status": {required: true},
                "date_of_birth": {required: true},
                "contact": {required: true},
                "permanent_address": {required: true},
                "email": {required: true, email: true},
                "department": {required: true},
                "employment_status": {required: true},
                "hire_date": {required: true},
                "biometric_id": {required: true},
                "reports_to_employee_id_no": {required: true},
                "tin_no": {required: true},
                "user_level": {required: true}
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
            }
            , submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'inquiry/register',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.type === 'register') {
                            window.location = _url + "Users/page/1";
                        } else {
                            notify('You have successfully updated the information');
                        }
                    }
                });
                return false;
            }
        });
    };

    var addevetsdata = function () {
        j('.calendar_event_create').validate({
            rules: {
                "title": {required: true},
                "organizer": {required: true},
                "category": {required: true},
                "location": {required: true},
                "description": {required: true}
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
                    url: _url + 'inquiry/addevent',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.message === 'success') {

                            setTimeout(function () {
                                j(".modal_calendar_event").modal('hide');
                                j('.calendar_event_create').trigger("reset");
                                j.notify(e);
                                location.reload();
                            }, 2000);


                        }

                    }
                });
                return false;
            }
        });
    };
    var last_id = function () {
        j.ajax({
            url: _url + 'inquiry/get_id',
            method: 'post',
            success: function (e) {
                window.location = _url + "update/id/" + e[0]['ID'];
            }
        });
    };
    var login = function () {
        var _this = j(this);
        var button = j('.login-button');
        j('.login').validate({
            rules: {
                email_address: {
                    required: true,
                    email: true
                },
                user_password: 'required'
            }
            , showErrors: function (errorMap, errorList) {
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
            }
            , submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'inquiry/login',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        console.log(e)
                        if (e.message === 'success') {
                            console.log('success');
                            setTimeout(function () {
                                window.location.href = _url;
                            }, 1000);
                        } else if (e.message === 'error') {
                            console.log('failed');
                        }
                    }
                });
                return false;
            }
        });

    };
    var get_calendar_data = function () {
        //  console.log("card has been initialize");
        j(".cardid").unbind().bind('click', function () {
            var get_id = j(this).attr("card-id");
            // j(".addeventsform").addClass("hide");
            j(".addeventsform").removeClass("hide");
            j(".calendardetails").addClass("hide");
            //j(".editcalendar").removeClass("hide");
            j(".editcalendar").addClass("hide");
            j(".calendarform").addClass("hide");
            j(".calendarformcaption").removeClass("hide");
            //  console.log("card has been clicked " + get_id);
            j.ajax({
                url: _url + 'inquiry/getcalendarinfo',
                dataType: 'json',
                method: 'post',
                data: {'getcalendarid': get_id},
                success: function (e) {
                    var titlefield = e[0].title;
                    var datevalue = e[0].year + '-' + e[0].month + '-' + e[0].day;
                    var organizerfield = e[0].organizer;
                    var descriptionfield = e[0].description;
                    var start = e[0].start_time;
                    var end = e[0].end_time;
                    var location = e[0].location;
                    var category = e[0].category;
                    var ID = e[0].ID;
                    var year = e[0].year;
                    var month = e[0].month;
                    var day = e[0].day;
                    var concadate = year + '-' + month + '-' + day
                    j('.title').val(titlefield);
                    j('.description').val(descriptionfield);
                    j('.organizer').val(organizerfield);
                    j('.startat').val(start);
                    j('.endat').val(end);
                    j('.location').val(location);
                    j('.category').val(category);
                    j('.idcalendar').val(ID);
                    j('.description').val(descriptionfield);
                    j('.date_caption').html(concadate);
                    j('.datevalueedit').val(concadate);
                }
            });

        });
        return false;
    };
    return {
        init: init
    };
})(jQuery);
