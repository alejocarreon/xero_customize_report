<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Assets extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $seconds_to_cache = 7200;
        $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . " GMT";
        header("Expires: $ts");
        header("Pragma: cache");
        header("Cache-Control: max-age=$seconds_to_cache");
        $this->load->model('Models');
    }

    function style() {
        header("Content-type: text/css; charset: UTF-8");
        $code = array(
            'https://snatchbot.me/sdk/webchat.css',
            site_url('jquery-ui/jquery-ui.min.css'),
            site_url('jquery-ui/jquery-ui.structure.min.css'),
            site_url('jquery-ui/jquery-ui.theme.min.css'),
            site_url('assets/css/bootstrap.css'),
            site_url('css/bootstrap-datetimepicker.css'),
            site_url('assets/css/jquery.timepicker.min.css'),
            site_url('css/font-awesome.min.css'),
            site_url('css/pnotify.custom.min.css'),
            site_url('css/pignose.calendar.min.css'),
            site_url('css/swipebox.min.css'),
            site_url('assets/css/select2.min.css'),
            site_url('css/animate.min.css'),
            site_url('css/owl.carousel.min.css'),
            site_url('css/owl.theme.default.min.css'),
            site_url('assets/css/stylesheet.css'),
            site_url('assets/css/style.css'),
        );
        $this->Models->scripts($code);
    }

    function script() {
        header('Content-type: text/javascript');
        $code = array(
            site_url('js/jquery-2.1.3.min.js'),
            site_url('js/jquery.dotdotdot.js'),
            site_url('js/jquery.form.min.js'),
            site_url('js/popper.min.js'),
            site_url('js/fontawesome-all.min.js'),
            site_url('js/bootstrap.min.js'),
            site_url('jquery-ui/jquery-ui.min.js'),
            site_url('assets/js/confirm.js'),
            site_url('js/moment.min.js'),
            site_url('js/bootstrap-datetimepicker.min.js'),
            site_url('assets/js/jquery.timepicker.min.js'),
            'https://snatchbot.me/sdk/webchat.min.js',
            site_url('js/pignose.calendar.full.min.js'),
            site_url('js/jquery.swipebox.min.js'),
            site_url('js/pnotify.custom.min.js'),
            site_url('assets/js/select2.full.min.js'),
            site_url('assets/js/jquery.validate.min.js'),
            site_url('assets/js/pubnub.4.19.0.min.js'),
            site_url('js/owl.carousel.min.js'),
            site_url('js/jquery.cropit.js'),
            site_url('assets/js/javascript.js'),
            site_url('assets/js/script.js'),
            site_url('js/snaptime.js'),
        );
        $this->Models->scripts($code);
    }

    function js($e) {
        if (file_exists('js/' . $this->uri->segment(3))) {
            header('Content-type: text/javascript');

            function sanitize_output($buffer) {
                $replace = array(
                    '#\'([^\n\']*?)/\*([^\n\']*)\'#' => "'\1/'+\'\'+'*\2'", // remove comments from ' strings
                    '#\"([^\n\"]*?)/\*([^\n\"]*)\"#' => '"\1/"+\'\'+"*\2"', // remove comments from " strings
                    '#/\*.*?\*/#s' => "", // strip C style comments
                    '#[\r\n]+#' => "\n", // remove blank lines and \r's
                    '#\n([ \t]*//.*?\n)*#s' => "\n", // strip line comments (whole line only)
                    '#([^\\])//([^\'"\n]*)\n#s' => "\\1\n",
                    // strip line comments
                    // (that aren't possibly in strings or regex's)
                    '#\n\s+#' => "\n", // strip excess whitespace
                    '#\s+\n#' => "\n", // strip excess whitespace
                    '#(//[^\n]*\n)#s' => "\\1\n", // extra line feed after any comments left
                    // (important given later replacements)
                    '#/([\'"])\+\'\'\+([\'"])\*#' => "/*" // restore comments in strings
                );
                $search = array_keys($replace);
                $script = preg_replace($search, $replace, $buffer);
                $replace = array(
                    "&&\n" => "&&",
                    "||\n" => "||",
                    "(\n" => "(",
                    ")\n" => ")",
                    "[\n" => "[",
                    "]\n" => "]",
                    "+\n" => "+",
                    ",\n" => ",",
                    "?\n" => "?",
                    ":\n" => ":",
                    ";\n" => ";",
                    "{\n" => "{",
                    "}\n"  => "}",
                    "\n]" => "]",
                    "\n)" => ")",
                    "\n}" => "}",
                    "\n\n" => "\n"
                );
                $search = array_keys($replace);
                $script = str_replace($search, $replace, $script);
                return trim($script);
            }

            ob_start("sanitize_output");
            include_once 'js/' . $this->uri->segment(3);
        } else {
            redirect(site_url());
        }
    }

    function css() {
        if (file_exists('css/' . $this->uri->segment(3))) {
            header("Content-type: text/css; charset: UTF-8");

            function sanitize_css($input) {
                return preg_replace(
                        array(
                    // Remove comment(s)
                    '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')|\/\*(?!\!)(?>.*?\*\/)|^\s*|\s*$#s',
                    // Remove unused white-space(s)
                    '#("(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\'|\/\*(?>.*?\*\/))|\s*+;\s*+(})\s*+|\s*+([*$~^|]?+=|[{};,>~+]|\s*+-(?![0-9\.])|!important\b)\s*+|([[(:])\s++|\s++([])])|\s++(:)\s*+(?!(?>[^{}"\']++|"(?:[^"\\\]++|\\\.)*+"|\'(?:[^\'\\\\]++|\\\.)*+\')*+{)|^\s++|\s++\z|(\s)\s+#si',
                    // Replace `0(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)` with `0`
                    '#(?<=[\s:])(0)(cm|em|ex|in|mm|pc|pt|px|vh|vw|%)#si',
                    // Replace `:0 0 0 0` with `:0`
                    '#:(0\s+0|0\s+0\s+0\s+0)(?=[;\}]|\!important)#i',
                    // Replace `background-position:0` with `background-position:0 0`
                    '#(background-position):0(?=[;\}])#si',
                    // Replace `0.6` with `.6`, but only when preceded by `:`, `,`, `-` or a white-space
                    '#(?<=[\s:,\-])0+\.(\d+)#s',
                    // Minify string value
                    '#(\/\*(?>.*?\*\/))|(?<!content\:)([\'"])([a-z_][a-z0-9\-_]*?)\2(?=[\s\{\}\];,])#si',
                    '#(\/\*(?>.*?\*\/))|(\burl\()([\'"])([^\s]+?)\3(\))#si',
                    // Minify HEX color code
                    '#(?<=[\s:,\-]\#)([a-f0-6]+)\1([a-f0-6]+)\2([a-f0-6]+)\3#i',
                    // Replace `(border|outline):none` with `(border|outline):0`
                    '#(?<=[\{;])(border|outline):none(?=[;\}\!])#',
                    // Remove empty selector(s)
                    '#(\/\*(?>.*?\*\/))|(^|[\{\}])(?:[^\s\{\}]+)\{\}#s'
                        ), array(
                    '$1',
                    '$1$2$3$4$5$6$7',
                    '$1',
                    ':0',
                    '$1:0 0',
                    '.$1',
                    '$1$3',
                    '$1$2$4$5',
                    '$1$2$3',
                    '$1:0',
                    '$1$2'
                        ), $input);
            }

            ob_start("sanitize_css");
            include_once 'css/' . $this->uri->segment(3);
        } else {
            redirect(site_url());
        }
    }

    function index() {
        redirect(site_url());
    }

}
