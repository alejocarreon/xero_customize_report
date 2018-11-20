(function (j) {
    j.notify = function (options) {
        var _body = j('body');
        var settings = j.extend({
            type: "info",
            speed: "200",
            delay: "3000",
            text: "Add some text"
        }, options);
        var _html = j('<div>');
        _html.html('<span>' + settings.text + '</span>');
        _html.addClass('notification alert alert-' + settings.type);
        _html.css({right: '-50%'});
        if (settings.type === 'warning') {
            _html.addClass('fa fa-exclamation-triangle');
        } else if (settings.type === 'success') {
            _html.addClass('fa fa-thumbs-o-up');
        } else if (settings.type === 'danger') {
            _html.addClass('fa fa-exclamation-circle');
        } else {
            _html.addClass('fa fa-info-circle');
        }
        _html.animate({right: '15px', opacity: '.7'}, settings.speed, function () {
            var _html = j(this);
            _html.delay(settings.delay).animate({bottom: '50%', opacity: '0'}, settings.speed, function () {
                var _this = j(this);
                _this.remove();
            });
        });
        _body.append(_html);
    };
})(jQuery);
/*
 * 
        $value = array(
            "message"=>"success", //error
            "text"=>"Message Output", //Message
            "type" =>"info" //danger,success,warning
        );
        print json_encode($value);
 *
 */