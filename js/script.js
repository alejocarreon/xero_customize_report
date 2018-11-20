var EM = EM || {};
EM.script = (function (j) {
    var _url = j('[name="site"]').attr('content');
    var init = function () {
        upload_profile_photo();
        start_page_load();
        top_notification();
        post_edit();
        add_video();
        delete_video();
        nav_menu();
        eventCalendar();
        attach_image();
        fileattached();
        postAnnouncement();
        getLocation();
        open_radio();
        open_bot();
        updateAnnouncement();
        updateAnnoModal();
        Init('?botID=12275&appID=0pcI24OkF08oa3OrodxS', 600, 600, 'https://dvgpba5hywmpo.cloudfront.net/media/image/1517531341Ig8lcdGXvn', 'bubble', '#00AFF0', 90, 90, 62.99999999999999, '', '0');
        delete_photo();
        modaltaging();
        modals();
        read_more();
        birthday();
        intra_search();
        team_group_list();
        tltip();
        forgot_login();
        like_dislike();
        realtime();
        tooltip_like();
    };
    var pubnub = new PubNub({publishKey: 'pub-c-08929c95-b4a5-402f-a0e9-de019f0cf077', subscribeKey: 'sub-c-d21546ca-1c1f-11e8-bb29-5a43d096f02f'});
    function realtime() {
        pubnub.addListener({
            message: function (obj) {
                if (obj.message.text === 'announcement') {
                    if (!j(".post-" + obj.message.key).length) {
                        render_to_post(obj.message.key);
                        j('.swipebox').swipebox();
                    }
                } else if (obj.message.text === 'post_delete') {
                    post_delete(obj.message.key);
                } else if (obj.message.text === 'post_like') {
                    var _main = j('.post-main-container .panel');
                    _main.find('a[href="' + obj.message.link + '"] .dislike').html(obj.message.dislike);
                    _main.find('a[href="' + obj.message.link + '"] .like').html(obj.message.like);
                    _main.find('a[href="' + obj.message.link + '"] .dislike').parent().attr('title',obj.message.dislikename);
                    _main.find('a[href="' + obj.message.link + '"] .like').parent().attr('title',obj.message.likename);
                    tooltip_like();
                }
            }
        });
        pubnub.subscribe({channels: ['052719862281018']});
    }
    function forgot_login(){
        var _forgot = j('.forget-pass');
        var _login = j('.login');
        _login.find('.login-link').click(function (e) {
            e.preventDefault();
            _forgot.removeClass('hide');
            _login.addClass('hide');
            _login.find('*').removeClass('error-input');
            _login.find('*').popover('dispose');
        });
        _forgot.find('.login-back').click(function (e) {
            e.preventDefault();
            _forgot.addClass('hide');
            _login.removeClass('hide');
            _forgot.find('*').removeClass('error-input');
            _forgot.find('*').popover('dispose');
        });
        _forgot.validate({
            rules: {
                email_address: {
                    required: true,
                    email: true
                }
            }
            , showErrors: function (errorMap, errorList) {
                j.each(this.errorList, function (index, value) {
                    var _elm = j(value.element);
                    _elm.parent().addClass('error-input');
                    _elm.parent().popover({content: value.message, trigger: 'hover', placement: 'top'});
                });
                j.each(this.successList, function (index, value) {
                    var _elm = j(value);
                    _elm.parent().removeClass('error-input');
                    _elm.parent().popover('dispose');
                });
            }
            , submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'request/forgot',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        _this.find('.login-btn').addClass('btn-loading');
                        if (e.message === 'success') {

                        } else if (e.message === 'error') {

                        }
                    }
                });
                return false;
            }
        });
    }
    function tooltip_like(){
          var botframe = j('.lwc-chat-button').hide();
        j('.tooltip-like').tooltip('dispose').tooltip({
            html: true,
            template: '<div class="tooltip bs-tooltip-top" role="tooltip"><div class="arrow"></div><div class="tooltip-inner text-left"></div></div>'
        });
    }
    function like_dislike(){
        j('.like-section a').unbind().bind('click',function(){
            var _this = j(this);
            var _reset = _this.parent();

            var _link = '';
            if (_this.hasClass('like-icon')) {
                if (!_this.hasClass('icon-active')) {
                    _link = {type: _this.attr('href'), 'status': 'like_post'};
                    _reset.find('a').removeClass('icon-active');
                    _this.addClass('icon-active');
                } else {
                    _link = {type: _this.attr('href'), 'status': 'delete'};
                    _reset.find('a').removeClass('icon-active');
                }
            } else if (_this.hasClass('dislike-icon')) {
                if (!_this.hasClass('icon-active')) {
                    _link = {type: _this.attr('href'), 'status': 'dislike'};
                    _reset.find('a').removeClass('icon-active');
                    _this.addClass('icon-active');
                } else {
                    _link = {type: _this.attr('href'), 'status': 'delete'};
                    _reset.find('a').removeClass('icon-active');
                }
            }
            j.ajax({
                url: _url + 'request/like',
                dataType: 'json',
                method: 'post',
                data: _link,
                success: function (e) {
                    _reset.find('a[href="' + _this.attr('href') + '"] .dislike').html(e.dislike);
                    _reset.find('a[href="' + _this.attr('href') + '"] .like').html(e.like);
                    _reset.find('a[href="' + _this.attr('href') + '"] .dislike').parent().attr('title', e.dislikename);
                    _reset.find('a[href="' + _this.attr('href') + '"] .like').parent().attr('title', e.likename);
                    pubnub.publish({channel: '052719862281018', message: {
                            "text": 'post_like',
                            "link": _this.attr('href'),
                            "dislike": e.dislike,
                            "like": e.like,
                            "dislikename": e.dislikename,
                            "likename": e.likename
                        }
                    });
                    tooltip_like();
                }
            });
            return false;
        });
    }
    function team_group_list(){
        var team_list = j('.team-group-list');

        var show_new_group = function(){
            j.ajax({
                url: _url + 'request/tag_group_list_ajax',
                method: 'post',
                dataType: 'json',
                success: function (data) {
                    var _html ='';
                    _html += '<form class="divTableRow table-group-list table-group-new">';
                    _html += '<input type="hidden" class="hide" name="GID" value="' + data[0].GID + '">';
                    _html += '<div class="divTableCell"><input type="text" class="form-control form-control-sm" name="group_name" value="' + data[0].group_name + '"></div>';
                    _html += '<div class="divTableCell text-center"><button type="submit" class="btn btn-success btn-sm submit-button"><i class="fas fa-pencil-alt"></i> Update</button> <button type="button" class="btn btn-danger btn-sm delete-team-group"  data-value="' + data[0].GID + '"><i class="fa fa-times"></i> Delete</button></div>';
                    _html += '</form>';
                    team_list.find('.form-group-list').prepend(_html);
                    team_list.find('.table-group-new').animate({"backgroundColor":"#ffeb00"},1000,function(){
                        j(this).animate({"backgroundColor":"#ffffff"},1000,function(){
                            var _this = j(this);
                            _this.removeClass('table-group-new');
                            _this.removeAttr('style');
                        });
                    });
                    team_group_list();
                }
            });
        };

        team_list.find('.delete-team-group').unbind().bind('click',function (e) {
            var _this = j(this);
            e.preventDefault();
            j.cnfrm({
                title: "Confirm",
                text: "Are you sure you want to delete this group?"
            }, function () {
                j.ajax({
                    url: _url + 'request/delete_group_list',
                    method: 'post',
                    dataType: 'json',
                    data: {delete_tag: _this.attr('data-value')},
                    success: function (data) {
                        _this.parent().parent().animate({"backgroundColor": "#ffeb00"}, 500, function () {
                            j(this).animate({"opacity": "0"}, 1000, function () {
                                _this.parent().parent().remove();
                            });
                        });
                    }
                });
            });

        });
        team_list.find('.table-group-list').each(function(){
            var _this = j(this);
            _this.unbind().bind('submit',function(){
                var _form = j(this);
                _form.find('.submit-button').attr('disabled','disabled');
                j.ajax({
                    url: _url + 'request/update_group_list',
                    method: 'post',
                    dataType: 'json',
                    data: _form.serialize(),
                    success: function (data) {
                       if(data.message === 'success'){
                           if(data.type === 'add'){
                                new PNotify({
                                    title: 'Notification!',
                                    text: 'Team group name has been added',
                                    type: 'info'
                                });
                                show_new_group();
                                team_list.find('.add-team-group').val('');
                           }else{

                                new PNotify({
                                    title: 'Notification!',
                                    text: 'Team group name has been updated',
                                    type: 'success'
                                });
                           }
                       }else if(data.message === 'error'){
                            new PNotify({
                                title: 'Notification!',
                                text: 'Team group name is required',
                                type: 'warning'
                            });
                       }
                       _form.find('.submit-button').removeAttr('disabled');
                    }
                });
                return false;
            });
        });
    }
    function intra_search(){
        var search = j('.intra-search-bar');
        search.keydown(function(e){
            var _keydown = (e.keydown || e.which);
            if(_keydown === 13){
                window.location = _url+'search/announcement/'+search.val();
            }
        });
    }
    function upload_profile_photo(){
        var upload = j('.upload-profile-photo');
        var _modal = j('.modal-profile-upload');
        var _img = j('.image-editor');
        upload.click(function(e){
            e.preventDefault();
            _modal.modal();
        });
         _modal.find('.close').click(function(e){
             e.preventDefault();
             _modal.modal('hide');
             _img.find('.upload-controls').addClass('hide');
         });
        _img.cropit({
            smallImage:'allow',
            onImageLoading: function () {
                console.log('loading');
            },
            onImageLoaded: function () {
                _img.find('.upload-controls').removeClass('hide');
                _img.find('.cropit-preview').css('background-image', 'none');
            },
            onImageError: function () {
                new PNotify({
                    title: 'Notification!',
                    text: 'There is a Problem Uploading Your Image please check image your image at least  300x300 pixel and maximum of 5mb',
                    type: 'warning'
                });
            }
        });
        _img.find('.rotate-left').click(function (e) {
            e.preventDefault();
            _img.cropit('rotateCCW');
        });
        _img.find('.rotate-right').click(function (e) {
            e.preventDefault();
            _img.cropit('rotateCW');
        });
        _img.find('.export').click(function () {
            var _this = j(this);
            _this.attr('disabled','disabled');
            var imageData = _img.cropit('export');
            j.ajax({
                dataType: 'json',
                url: _url+'request/profile_picture',
                data: {'base64': imageData},
                method: 'post',
                success: function (e) {
                    j('[data-bind="image-'+e.uid+'"]').attr('src',_url+'uploads/'+e.image);
                    new PNotify({
                        title: 'Notification!',
                        text: 'Your profile photo has been updated',
                        type: 'success'
                    });
                    _img.find('.upload-controls').addClass('hide');
                    _modal.modal('hide');
                    _this.removeAttr('disabled');
                }
            });
        });

        j('.select-image-btn').click(function () {
            j('.cropit-image-input').click();
        });

    }

    function birthday() {
        j('.birthday-carousel').owlCarousel({
            items: 1,
            lazyLoad: true,
            loop: true,
            margin: 10,
            autoplay: true,
            autoplayTimeout: 2000,
            autoplayHoverPause: true
        });
    }
    function top_notification() {
        var top = j('.top-notification');
        var _num = 0;
        top.find('.notification-message .show-more-button').unbind().bind('click', function () {
            _num = (_num + 5);
            j.ajax({
                url: _url + 'feed/render_notification',
                method: 'post',
                dataType: 'html',
                data: {"notification": _num},
                success: function (data) {
                    if (data.length > 0) {
                        top.find('.show-more-notification').append(data);
                        var _scroll = top.find('.show-more-notification');
                        _scroll.animate({scrollTop:_scroll.prop("scrollHeight")},1000);
                    }else{

                    }
                }
            });
            return false;
        });
    }


    var modals = function () {
        j('.modal').on('shown.bs.modal', function () {
            var _this = j(this);
            _this.find('.modal-dialog').addClass('animated zoomInDown');
        });
        j('.modal').on('hide.bs.modal', function () {
            var _this = j(this);
        });
    };

    var read_more = function () {
        j('.inner-content').each(function () {
            var _this = j(this);
            if (_this.find('.inner-post').height() > _this.height()) {
                var u = _this.dotdotdot({
                    watch: "window"
                }).data("dotdotdot");
                if (_this.parent().find('.see-more-text').length === 0) {
                    _this.parent().append('<div class="text-right"><span class="see-more-text">See More...</span></div>');
                }
                _this.parent().find('.see-more-text').unbind().bind('click', function () {
                    var _text = j(this);
                    u.destroy();
                    _this.removeClass('limit-text');
                    _text.parent().remove();
                });
            }
        });
    };

    var start_page_load = function () {
        var _loaded = 0;
        var _page = 0;
        j(window).scroll(function () {
            if (j(window).scrollTop() + j(window).height() > j(document).height() - 200) {
                if (_loaded === 0) {
                    var _body = j('body');
                    var _paginate = '';
                    if(_body.find('.post-main-container').attr('data-bind') === 'main-page'){
                        _paginate = _url + 'feed/render_posted_pagination';
                    }else if(_body.find('.post-main-container').attr('data-bind') === 'search-page'){
                        _paginate = _url + 'feed/render_search_pagination';
                    }else if(_body.find('.post-main-container').attr('data-bind') === 'user-page'){
                        _paginate = _url + 'feed/render_user_page';
                    }else{
                        _paginate = _url + 'feed/render_posted_pagination';
                    }
                    _page = (_page + 5);
                    j.ajax({
                        url: _paginate,
                        method: 'post',
                        dataType: 'html',
                        data: {
                            "page": _page,
                            "keyword":(_body.find('.intra-search-bar').val()?_body.find('.intra-search-bar').val():_body.find('.intra-search-bar').attr('data-bind'))
                        },
                        success: function (data) {
                            if (data.length > 0) {
                                _body.removeClass('loading-post');
                                _loaded = 0;
                                _body.find('.post-main-container').append(data);
                                updateAnnoModal();
                                fileattached();
                                attach_image();
                                post_edit();
                                modaltaging();
                                delete_photo();
                                tltip();
                                read_more();
                                like_dislike();
                                tooltip_like()
                            } else {
                                _body.removeClass('loading-post');
                                _loaded = 1;
                            }
                        }
                    });
                    j('body').addClass('loading-post');
                    _loaded = 1;

                }
            }
        });
    };
    var submit_tags = function ($id, $data) {
        j.ajax({
            url: _url + 'request/tagging',
            method: 'post',
            dataType: 'json',
            data: {"get_id": $id, "group_id": $data.item_id, "type": $data.type},
            success: function (data) {
                var _tags = '';
                j.ajax({
                    url: _url + 'request/out_tagged_group',
                    method: 'post',
                    dataType: 'json',
                    data: {"postid": $id},
                    success: function (data) {
                        for (var i = 0; i < data.length; i++) {
                            _tags += ('<span class="badge badge-info">' + data[i].group_name + '</span> ');
                        }
                        j('.post-tag-groups[data-tag="' + $id + '"]').html(_tags);
                    }
                });
            }
        });
    };
    var modaltaging = function () {
        var _mod = j('.tag-group');
        var _modal = j('.modal-tag');
        _mod.unbind().bind('click', function () {
            var _this = j(this);
            var _html = '';
            var _tags = '';
            _modal.modal({backdrop: 'static', keyboard: false});
            _modal.find('.id-tag-group').val(_this.attr('href'));
            j.ajax({
                url: _url + 'request/out_tagged_group',
                method: 'post',
                dataType: 'json',
                data: {"postid": _this.attr('href')},
                success: function (data) {
                    for (var i = 0; i < data.length; i++) {
                        _html += ('<div class="tag-selector" data-bind="' + data[i].GID + '"><div class="tag-group">' + data[i].group_name + '</div></div>');
                        _tags += ('<span class="badge badge-info">' + data[i].group_name + '</span> ');
                    }
                    _modal.find('.span-tag').html(_html);
                    j('.post-tag-groups[data-tag="'+_this.attr('href')+'"]').html(_tags);
                    j('.tag-options').autoTag({
                        url: _url + 'request/tag_group_option',
                        callback: function (data) {
                            submit_tags(_this.attr('href'),data);
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
    var findFirstImageInBody = function ($body) {
        var result;
        var $images = $body.find("img[src]");
        var $img;
        $images.each(function () {
            $img = $(this);
            if ($img.attr("height") && $img.attr("height") > 40 &&
                    $img.attr("width") && $img.attr("width") > 40) {
                result = this.src;
                return false;
            }
        });
        return result;
    };
    var preview_link = function (link) {
        var linkprev = j('.link-preview-cont');
        linkprev.html('');
        j.ajax({
            url: _url+'feed/link_preview',
            method: 'post',
            dataType: 'html',
            data: {"get_link": link},
            success: function (data) {
                if (data.length > 0) {
                    data = data.replace(/<\/?[A-Z]+[\w\W]*?>/g, function (m) {
                        return m.toLowerCase();
                    });
                    var dom = document.implementation.createHTMLDocument('');
                    dom.body.innerHTML = data;
                    var $dom = j(dom);
                    var imageSrc = $dom.find("meta[itemprop=image]").attr("content") ||
                            $dom.find("link[rel=image_src]").attr("content") ||
                            $dom.find("meta[itemprop=image]").attr("content") ||
                            findFirstImageInBody($dom.find("body"));
                    var _html = '';
                    if (imageSrc && $dom.find('title').text()) {
                        _html += '<div class="link-preview">';
                        _html += '<div class="col-view image-cell"><a href="' + link + '" class="image" target="_blank"><img src="' + (imageSrc) + '"/></a></div>';
                        _html += '<div class="col-view desc-cell"><p><a href="' + link + '" class="title" target="_blank">' + ($dom.find('title').text()) + '</a></p>';
                        if (typeof ($dom.find("meta[name=description]").attr("content")) !== 'undefined') {
                            _html += '<a href="' + link + '" class="description" target="_blank">' + ($dom.find("meta[name=description]").attr("content")) + '</a></div>';
                        }
                        _html + '</div>';
                    } else {
                        _html += '<div class="link-preview-desciption">';
                        _html += '<div class="col-view"><p><a href="' + link + '" class="title" target="_blank">' + ($dom.find('title').text()) + '</a></p>';
                        if (typeof ($dom.find("meta[name=description]").attr("content")) !== 'undefined') {
                            _html += '<a href="' + link + '" class="description" target="_blank">' + ($dom.find("meta[name=description]").attr("content")) + '</a>';
                        }
                        _html + '</div>';
                    }
                   /* linkprev.append(_html);*/
                }
            }
        });
    };
    var tltip = function(){
        j('.radio-opener').tooltip('dispose').tooltip();
        j('.tooltip-title').each(function () {
            var _this = j(this);
            _this.tooltip('dispose').tooltip({
                container: _this.parent().parent().parent(),
                placement: 'top',

            });
        });
    };
    var nav_menu = function () {
        var _menu = j('.main-nav');
        _menu.find('[href="#"]').click(function () {
            return false;
        });
    };
    var post_delete = function (id) {
        j('#post-' + id).animate({'opacity': 0}, 1000, function () {
            var _this = j(this);
            _this.remove();
        });
    };
    var post_edit = function () {
        j('.delete-anno').unbind().bind('click', function (e) {
            e.preventDefault();
            var _this = j(this);
            j.cnfrm({
                title: "Confirm",
                text: "Are you sure you want to delete this post?"
            }, function () {
                j.ajax({
                    url: _url + 'request/delete_announcement',
                    dataType: 'json',
                    method: 'post',
                    data: {"get_id": _this.attr('href')},
                    success: function (e) {
                        if (e.message === 'success') {
                            pubnub.publish({channel: '052719862281018', message: {
                                    text: 'post_delete',
                                    key: _this.attr('href')
                                }
                            });
                            j('#post-' + _this.attr('href')).animate({'opacity': 0}, 1000, function () {
                                var _this = j(this);
                                _this.remove();
                                new PNotify({
                                    title: 'Notification!',
                                    text: 'Announcement has been successfully deleted.',
                                    type: 'success'
                                });
                            });
                        }
                    }
                });
            });
            return false;
        });
    };
    var eventCalendar = function () {
        j( '.swipebox' ).swipebox();
    };
    var render_to_post = function ($post_id) {
        var _post_main = j('.post-main-container');
        j.ajax({
            url: _url + 'feed/render_posted_messege',
            method: 'post',
            data: {"get_id": $post_id},
            success: function (e) {
                _post_main.prepend(e);
                updateAnnoModal();
                fileattached();
                attach_image();
                post_edit();
                modaltaging();
                _post_main.find('.opacity-clear').animate({'opacity': 1}, 1000, function () {
                    j(this).removeClass('.opacity-clear');
                });
                delete_photo();
                tltip();
                _post_main.find('.panel-post:last-child').remove();
                read_more();
                like_dislike();
                tooltip_like()
            }
        });
    };

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    };
    var updateAnnoModal = function () {
        var _update = j('.modal-update-post');
        j('.edit-anno').unbind().bind('click', function (e) {
            e.preventDefault();
            var _this = j(this);
            _update.find('.id-announcement').val(_this.attr('href'));
            _update.modal({backdrop: 'static', keyboard: false});
            j.ajax({
                url: _url + 'request/json_posted_messege',
                dataType: 'json',
                method: 'post',
                data: {get_id: _this.attr('href')},
                success: function (e) {
                    if (e.message === 'success') {
                        CKEDITOR.instances['update-announcement'].setData(e.text);
                    }
                }
            });
        });
        _update.find('.close').unbind().bind('click', function () {
            _update.modal('hide');
            _update.find('.id-announcement').val('');
            CKEDITOR.instances['update-announcement'].setData('');
        });
    };
    var updateAnnouncement = function () {
        var _update = j('.update-announcement-form');
        var _modal = j('.modal-update-post');

        if (j('#update-announcement').length) {
            var editor = CKEDITOR.inline('update-announcement', {
                extraPlugins: 'sourcedialog,autolink,confighelper,uploadimage',
                filebrowserUploadUrl: _url + "request/attached?type=image"
            });
            _update.submit(function (e) {
                e.preventDefault();
                var _this = j(this);
                j('.update-announcement-textarea').val(editor.getData());
                j.ajax({
                    url: _url + 'request/update_anno',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        if (e.message === 'success') {
                            j('#announcement' + _update.find('.id-announcement').val()).html(editor.getData());
                            editor.setData('');
                            _update.find('.id-announcement').val('');
                            _modal.modal('hide');
                        } else if (e.message === 'error') {

                        }
                    }
                });
                return false;
            });
        }
    };
    var postAnnouncement = function () {
        if (j('#post-announcement').length) {
            CKEDITOR.disableAutoInline = true;
            var editor = CKEDITOR.inline('post-announcement', {
                extraPlugins: 'sourcedialog,autolink,confighelper,uploadimage,videoembed',
                filebrowserUploadUrl: _url + "request/attached?type=image",
            });
            j('.cke_textarea_inline').on('keyup keypress', function () {
                var _this = j(this);
                clearTimeout(window.recheck);
                window.recheck = setTimeout(function () {
                    var linkprev = j('.link-preview-cont');
                    linkprev.html('');
                    _this.find("a[href]").each(function (num) {
                        var _this = j(this);
                        preview_link(_this.attr('href'));
                    });
                }, 2000);
            });
            var _post_announcement = j('.btn-post-announcement');
            _post_announcement.click(function () {
                var _this = j(this);
                _this.attr('disabled','disabled');
                var _reset = j('.panel-main-post');
                j('.post-announcement').val(editor.getData());
                j.ajax({
                    url: _url + 'request/announcement',
                    dataType: 'json',
                    method: 'post',
                    data: j('.post-announcement-form').serialize(),
                    success: function (e) {
                        if (e.message === 'success') {
                            var _number = parseInt(getRandomInt(111111111111111, 99999999999999));
                            j('.get_upload_id').val(_number);
                            editor.setData('');
                            _reset.find('.post_id').val(_number);
                            _reset.find('.post-tag-groups').attr('data-tag', _number);
                            _reset.find('.attached-image').attr('href', _number);
                            _reset.find('.attached-video').attr('href', _number);
                            _reset.find('.post-images').attr('data-bind', _number);
                            _reset.find('.post-videos').attr('data-bind', _number);
                            _reset.find('.post-images .row').html('');
                            _reset.find('.post-videos .row').html('');
                            pubnub.publish({channel: '052719862281018', message: {
                                    text: 'announcement',
                                    key: e.post_id
                                }
                            });
                            new PNotify({
                                title: 'Success!',
                                text: 'Announcement has been posted.',
                                type: 'success'
                            });
                        } else if (e.message === 'error') {
                            new PNotify({
                                title: 'Notification',
                                text: 'Announcement required',
                                type: 'warning'
                            });
                        }
                        _this.removeAttr('disabled');
                    }
                });
            });
        }
    };

    var delete_photo = function (){
        var _photos = j('.posted-images');
         _photos.find('.close').unbind().bind('click',function(e){
             e.preventDefault();
             var _this = j(this);
             var _ltn = _this.parent().parent();
            j.ajax({
                url: _url + 'request/remove_photo',
                dataType: 'json',
                method: 'post',
                data: {
                    'get_upload_id': _this.attr('href'),
                    'upload_name': _this.parent().find('.swipebox').attr('href'),
                    'upload_thumb': _this.parent().find('.img-thumbnail').attr('src')
                },
                success: function (e) {
                    if (e.message === 'success') {
                        var $col = 'col-3';
                        _this.parent().remove();
                        _ltn.find('.cols').each(function () {
                            var _this = j(this);
                            if (_ltn.find('.cols').length === 1) {
                                _this.find('img').attr('src', _this.find('img').attr('data-fullsize'));
                            } else {
                                _this.find('img').attr('src', _this.find('img').attr('data-thumbnail'));
                            }
                        });
                        if (_ltn.find('.cols').length === 1) {
                            $col = 'col-12';
                        } else if (_ltn.find('.cols').length === 2) {
                            $col = 'col-6';
                        } else if (_ltn.find('.cols').length === 3) {
                            $col = 'col-4';
                        } else {
                            $col = 'col-3';
                        }
                        _ltn.find('.cols').removeClass('col-12 col-6 col-4 col-3');
                        _ltn.find('.cols').addClass($col);
                    }
                }
            });
         });
    };

    var fileattached = function () {
        j('.input-drop-images').unbind().bind('change',function () {
            var _progress = j('.progress-upload');
            var _modl_attach = j('.modal-upload-images');
            var _val = '';
            var _this = j(this);
            var files = _this.prop("files");
            for (var i = 0; i < files.length; i++) {
                _val += (files[i].name) + ',';
            }
            _val = _val.slice(0, -1);
            j('.drop-images').ajaxSubmit({
                url: _url + 'request/multiple',
                beforeSend: function () {
                    j(window).unbind().bind('beforeunload', function () {
                        return 'Changes you made may not be saved.';
                    });
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    _progress.removeClass('hide');
                    _progress.find('.progress-bar').css({width: percentComplete + '%'}).html(percentComplete + '%');
                },
                complete: function (e) {
                    var _e = (j.parseJSON(e.responseText));
                    var $col = 'col-3';
                    if (_e.message === 'success') {
                        _this.val('');
                        _modl_attach.modal('hide');
                        _progress.addClass('hide');
                        _progress.find('.progress-bar').css({width: '0%'});
                        var _len = _e[0].length;
                        for (var i = 0; i < _len; i++) {
                            var _elm = j('.post-images[data-bind="'+_e.document+'"] .row');
                            _elm.append('<div class="col-3 cols"><a href="'+_e[1][i]+'" class="swipebox" target="_blank"><img  class="img-thumbnail" src="' + _e[0][i] + '" data-fullsize="'+_e[1][i]+'" data-thumbnail="' + _e[0][i] + '"></a></div>');
                            var _ltn =  _elm.find('.cols').length;
                            _elm.find('.cols').each(function(){
                                var _this = j(this);
                                if (_ltn === 1) {
                                    _this.find('img').attr('src',_this.find('img').attr('data-fullsize'));
                                }else{
                                    _this.find('img').attr('src',_this.find('img').attr('data-thumbnail'));
                                }
                            });
                            if (_ltn === 1) {
                                $col = 'col-12';
                            } else if (_ltn === 2) {
                                $col = 'col-6';
                            } else if (_ltn === 3) {
                                $col = 'col-4';
                            } else {
                                $col = 'col-3';
                            }
                            _elm.find('.cols').removeClass('col-12 col-6 col-4 col-3');
                            _elm.find('.cols').addClass($col);
                        }
                        j( '.swipebox' ).swipebox();
                        delete_photo();
                        j(window).unbind('beforeunload');
                    } else {

                    }
                }
            });
        });
    };

    function getLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition,function(error){
                j.ajax({
                    url: _url + 'request/weather',
                    dataType: 'json',
                    method: 'post',
                    success: function (e) {
                        var _json = ('{"coords":{"latitude":"' + e.latitude + '","longitude":"' + e.longitude + '"}}');
                        var obj = j.parseJSON(_json);
                        showPosition(obj);
                    }
                });
            });
        } else {
            console.log("Geolocation is not supported by this browser.");
            j.ajax({
                url: _url + 'request/weather',
                dataType: 'json',
                method: 'post',
                success: function (e) {
                    var _json = ('{"coords":{"latitude":"' + e.latitude + '","longitude":"' + e.longitude + '"}}');
                    var obj = j.parseJSON(_json);
                    showPosition(obj);
                }
            });
        }
    }
    function weather_icon(icon, deflt) {
        console.log(icon+'-');
        var _icon = '';
        if (icon == 'partlycloudy') {
            _icon = _url + 'images/animated/cloudy-day-1.svg';
        } else if (icon == 'mostlycloudy') {
            _icon = _url + 'images/animated/cloudy-day-2.svg';
        } else if (icon == 'chancerain') {
            _icon = _url + 'images/animated/rainy-4.svg';
        } else if (icon == 'chancesleet') {
            _icon = _url + 'images/animated/rainy-7.svg';
        } else if (icon == 'chancetstorms') {
            _icon = _url + 'images/animated/thunder.svg';
        } else if (icon == 'tstorms') {
            _icon = _url + 'images/animated/thunder.svg';
        } else if (icon == 'fog') {
            _icon = _url + 'images/animated/cloudy.svg';
        } else if (icon == 'cloudy' || icon == 'hazy') {
            _icon = _url + 'images/animated/cloudy.svg';
        } else if (icon == 'snow') {
            _icon = _url + 'images/animated/snowy-6.svg';
        } else if (icon == 'clear') {
            _icon = _url + 'images/animated/day.svg';
        } else {
            _icon = deflt;
        }
        return _icon;
    }
    function showPosition(position) {
        /*console.log("Latitude: " + position.coords.latitude + "Longitude: " + position.coords.longitude);*/
        var _pos = position.coords.latitude + ',' + position.coords.longitude + '.json';
        var _weather = j('.panel-weather');
        j.ajax({
            url: 'https://api.wunderground.com/api/4d6eb96f1aa092b2/forecast/geolookup/conditions/q/' + _pos,
            dataType: 'json',
            method: 'post',
            success: function (e) {
                _weather.removeClass('hide');
                _weather.find('.icon_url0').html('<img class="forcast" title="'+e.current_observation.weather+'" src="' + weather_icon(e.current_observation.icon,e.current_observation.icon_url) + '"/>');
                /*console.log(e.current_observation.weather);*/
                _weather.find('.title0').html(e.forecast.txt_forecast.forecastday[0].title);
                _weather.find('.fcttext0').html(e.forecast.txt_forecast.forecastday[0].fcttext);
                /*console.log(e.forecast.simpleforecast.forecastday);*/
                _weather.find('.location').html(e.current_observation.display_location.state_name);
                _weather.find('.temperature_string').html(e.current_observation.temperature_string);
                var _len = e.forecast.simpleforecast.forecastday.length;
                var _html = '';
                for (var i = 1; i < _len; i++) {
                  /* console.log(e.forecast.simpleforecast.forecastday[i]);*/
                    _html += '<div class="forcast" title="'+e.forecast.simpleforecast.forecastday[i].conditions+'"><img src="' + weather_icon(e.forecast.simpleforecast.forecastday[i].icon,e.forecast.simpleforecast.forecastday[i].icon_url) + '"/>' + e.forecast.simpleforecast.forecastday[i].date.weekday_short + '</div>';
                }
                _weather.find('.next-weather').html('<div class="display-next">' + _html + '</div>');
                j('.forcast').tooltip();
            }
        });

    }
    var add_video = function () {
        var _vid = j('#add-new-video');
        _vid.submit(function (e) {
            e.preventDefault();
            var _this = j(this);
            j.ajax({
                url: _url + 'request/add_new_video',
                method: 'post',
                data: _this.serialize(),
                success: function (e) {
                    if (e.message === 'success') {
                        show_video(_this.find('.get_upload_id').val());
                        _this.find('.video-url').val('');
                    }
                }
            });
        });
    };
    var delete_video = function () {
        j('.close-link').unbind().bind('click',function (e) {
            e.preventDefault();
            var _this = j(this);
            j.ajax({
                url: _url + 'request/remove_video',
                dataType: 'json',
                method: 'post',
                data: {'get_upload_id': _this.attr('href')},
                success: function (e) {
                    if (e.message === 'success') {
                        _this.parent().remove();
                    }
                }
            });
            return false;
        });
    };
    var show_video_page = function ($num) {
        j.ajax({
            url: _url + 'feed/render_video_page',
            method: 'post',
            data: {'posted_videos_id': $num},
            success: function (e) {
                j('.post-videos[data-bind="' + $num + '"] .row').html(e);
            }
        });
    };
    var show_video = function ($num) {
        var _modl_attach_video = j('.modal-upload-video');
        var _html = '';
        j.ajax({
            url: _url + 'request/render_video',
            dataType: 'json',
            method: 'post',
            data: {'posted_videos_id': $num},
            success: function (e) {
                var _len = e.length;
                for (var i = 0; i < _len; i++) {
                    _html += '<li class="list-group-item"><div class="link-ellipsis">' + e[i].video_url + '</div><a href="' + e[i].VID + '" class="close-link pull-right"><i class="fa fa-times"></i></a></li>';
                }
                _modl_attach_video.find('#'+$num).html(_html);
                delete_video();
            }
        });
    };
    var attach_image = function () {
        var _attach = j('.attached-image');
        var _modl_attach = j('.modal-upload-images');
        var _attach_video = j('.attached-video');
        var _modl_attach_video = j('.modal-upload-video');
        _attach.unbind().bind('click',function (e) {
            e.preventDefault();
            var _this = j(this);
            _modl_attach.modal({backdrop: 'static', keyboard: false});
            _modl_attach.find('.get_upload_id').val(_this.attr('href'));
        });
        _modl_attach.find('.close').click(function(e){
            e.preventDefault();
            _modl_attach.modal('hide');
        });
        _attach_video.unbind().bind('click', function (e) {
            e.preventDefault();
            var _this = j(this);
            _modl_attach_video.modal({backdrop: 'static', keyboard: false});
            _modl_attach_video.find('.get_upload_id').val(_this.attr('href'));
            _modl_attach_video.find('.close').attr('href', _this.attr('href'));
            _modl_attach_video.find('.list-group').attr('id', _this.attr('href'));
            show_video(_this.attr('href'));
        });
        _modl_attach_video.find('.close').click(function(e){
            e.preventDefault();
            var _this = j(this);
            show_video_page(_this.attr('href'));
            _modl_attach_video.modal('hide');
        });
    };
    var open_radio = function () {
        var radio = j('.radio-opener');
        radio.click(function () {
            var _this = j(this);
            if (!_this.parent().hasClass('opened')) {
                _this.parent().animate({'right': '0'}, 400,function(){
                    _this.parent().addClass('opened');
                });
                if (!_this.parent().hasClass('no-refresh')) {
                    var _bind = _this.parent().find('iframe').attr('data-bind');
                    _this.parent().find('iframe').attr('src', _bind);
                    _this.parent().addClass('no-refresh');
                }
            }else{
                _this.parent().animate({'right': '-400'}, 400,function(){
                    _this.parent().removeClass('opened');
                });
            }
        });
    };
    var open_bot = function () {
        var radio = j('.bot-opener');
        radio.click(function () {
            var _this = j(this);
            if (!_this.parent().hasClass('opened')) {
                _this.parent().animate({'right': '0'}, 400,function(){
                    _this.parent().addClass('opened');
                });
                if (!_this.parent().hasClass('no-refresh')) {
                    var _bind = _this.parent().find('iframe').attr('data-bind');
                    _this.parent().find('iframe').attr('src', _bind);
                    _this.parent().addClass('no-refresh');
                }
            }else{
                _this.parent().animate({'right': '-400'}, 400,function(){
                    _this.parent().removeClass('opened');
                });
            }
        });
    };
    return {
        init: init
    };
})(jQuery);
