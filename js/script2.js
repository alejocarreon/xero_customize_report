var EM = EM || {};
EM.code = (function (j) {
    var _url = j('.page-url').attr('content');
    var init = function () {
        add_users();
        update_users();
        reset_password();
        resetpassword();
        delete_user();
        logout();
    };

    var notify = function (option) {
        var _body = j('body');
        _body.append('<div class="notification">' + option.text + '</div>');
        if (typeof option.type !== 'undefined') {
            _body.find('.notification').addClass('notify-error');
        }

        var _not = _body.find('.notification').width();
        var _wid = j(window).width();
        _wid = (_wid / 2);
        console.log(_not)

        _body.find('.notification').css({'top': '1px', 'opacity': '0', 'left': (_wid - _not) + 'px'}).animate({'top': '50%', 'opacity': '1'}, 800).delay(15000).animate({'top': '100%', 'opacity': '0'}, 800, function () {
            var _this = j(this);
            _this.remove();
        });
    };
    var update_users = function () {

        var _form = j('.form-info');

        _form.each(function () {

            var _this = j(this)


            _this.validate({
                rules: {
                },
                showErrors: function (errorMap, errorList) {
                    j.each(this.errorList, function (index, value) {
                        var _elm = j(value.element);
                        _elm.parent().addClass('has-error');
                        _elm.popover({content: value.message, trigger: 'focus', placement: 'top'});
                    });
                    j.each(this.successList, function (index, value) {
                        var _elm = j(value);
                        _elm.parent().removeClass('has-error');
                        _elm.popover('destroy');
                    });
                },
                submitHandler: function (form) {
                    var _form = j(form);

                    j.ajax({
                        url: _url + 'Response/update_user',
                        dataType: 'json',
                        method: 'post',
                        data: _form.serialize(),
                        success: function (output) {

                            if (output.message === 'success') {
                                j.notify(output);
                                console.log('aal');
                                setTimeout(function () {

                                }, 4000);
                            }
                            console.log(output);
                            // _form.find('.output').html(output.text);
                        }
                    });
                    return false;
                }
            });
        });
    };
    var logout = function () {
        var _logout = j('.logout-btn');
        _logout.click(function () {
            console.log('click');
            j.ajax({
                url: _url + 'Response/logout_session',
                dataType: 'json',
                method: 'post',
                data: {logout: true},
                success: function (option) {
                    if (option.message === 'logout') {
                      window.location.replace(_url);
                    }
                     console.log(option.message);
                }
            });
            return false;
        });
    };
    var delete_user = function () {
        var _mod = j('.delete_user_div');
        j('.btn-delete').each(function () {
            var _this = j(this);
            _this.click(function () {
                var _this = j(this);
                _mod.modal();
                _mod.find('.delete-id').val(_this.attr('data-reset'));
                console.log(_this.attr('data-reset'));
            });
        });
        j('.delete-password-form').validate({
            showErrors: function (errorMap, errorList) {
                j.each(this.errorList, function (index, value) {
                    var _elm = j(value.element);
                    _elm.parent().addClass('has-error');
                    _elm.popover({content: value.message, trigger: 'hover', placement: 'top'});
                });
                j.each(this.successList, function (index, value) {
                    var _elm = j(value);
                    _elm.parent().removeClass('has-error');
                    _elm.popover('destroy');
                });
            }, submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'Response/delete_user_r',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (output) {
                        if (output.message === 'success') {
                            j.notify(output);
                            _this[0].reset();
                            _mod.modal('hide');
                            location.reload();
                        }

                    }

                });
                return false;
            }
        });

    };
    var reset_password = function () {
        var _mod = j('.reset-password');
        j('.btn-password').each(function () {
            var _this = j(this);
            _this.click(function () {
                var _this = j(this);
                _mod.modal();
                _mod.find('.password-id').val(_this.attr('data-reset'));
                console.log(_this.attr('data-reset'));
            });
        });
        j('.reset-password-form').validate({
            rules: {
                password: 'required',
                repassword: {
                    required: true,
                    equalTo: "#pass"
                }
            },
            showErrors: function (errorMap, errorList) {
                j.each(this.errorList, function (index, value) {
                    var _elm = j(value.element);
                    _elm.parent().addClass('has-error');
                    _elm.popover({content: value.message, trigger: 'hover', placement: 'top'});
                });
                j.each(this.successList, function (index, value) {
                    var _elm = j(value);
                    _elm.parent().removeClass('has-error');
                    _elm.popover('destroy');
                });
            }, submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'Response/reset_password',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (output) {
                        if (output.message === 'success') {
                            j.notify(output);
                            _this[0].reset();
                            _mod.modal('hide');
                        }
                    }

                });
                return false;
            }
        });

    };
    var resetpassword = function () {
        j('.reset-password').validate({
            rules: {
                setting_password: {
                    'required': true
                },
                setting_repassword: {
                    'equalTo': '#setpassword'
                }
            },
            showErrors: function (errorMap, errorList) {
                j.each(this.errorList, function (index, value) {
                    var _elm = j(value.element);
                    _elm.addClass('error');
                    _elm.popover({content: value.message, trigger: 'hover', placement: 'top'});
                });
                j.each(this.successList, function (index, value) {
                    var _elm = j(value);
                    _elm.removeClass('error');
                    _elm.popover('destroy');
                });
            },
            submitHandler: function (form) {
                var _this = j(form);
                j.ajax({
                    url: _url + 'Response/reset_password',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (output) {

                        if (output.message === 'success') {
                            j.notify(output);
                            console.log('aal');
                            setTimeout(function () {
                                location.reload();
                            }, 4000);
                        }
                        console.log(output);
                        // _form.find('.output').html(output.text);
                    }
                });
                return false;
            }
        });
    };
    var loginw = function () {
        j('.userlogin').validate({
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
                j.ajax({
                    url: _url + 'request/login',
                    dataType: 'json',
                    method: 'post',
                    data: _this.serialize(),
                    success: function (e) {
                        console.log(e.message);
                        if (e.message === 'success') {
                            _this.find('.output').html('<div class="alert alert-success text-center">' + e.text + '</div>');
                            console.log('IN');
                            // window.location.reload();
                        } else if (e.message === 'error') {
                            _this.find('.output').html('<div class="alert alert-warning text-center">' + e.text + '</div>');
                            console.log('OUT');
                        }
                    }
                });
                return false;
            }
        });
    };
    var add_users = function () {
        var _form = j('.formaddusers');
        //alert(_form.html());

        _form.validate({
            rules: {
                firstname: 'required',
                middlename: 'required',
                lastname: 'required',
                uasr_type: 'required',
                email: {
                    required: true,
                    email: true
                },
                password: 'required'

            },
            showErrors: function (errorMap, errorList) {
                j.each(this.errorList, function (index, value) {
                    var _elm = j(value.element);
                    _elm.parent().addClass('has-error');
                    _elm.popover({content: value.message, trigger: 'focus', placement: 'top'});
                });
                j.each(this.successList, function (index, value) {
                    var _elm = j(value);
                    _elm.parent().removeClass('has-error');
                    _elm.popover('destroy');
                });
            },
            submitHandler: function (form) {
                var _form = j(form);

                j.ajax({
                    url: _url + 'Response/add_users',
                    dataType: 'json',
                    method: 'post',
                    data: _form.serialize(),
                    success: function (output) {

                        if (output.message === 'success') {
                            j.notify(output);
                            console.log('aal');
                            setTimeout(function () {
                                location.reload();
                            }, 4000);
                        }
                        console.log(output);
                        _form.find('.output').html(output.text);
                    }
                })
                return false;
            }
        });
    };


    return{
        init: init
    };
})(jQuery);
