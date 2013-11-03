<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 02.11.13
 * Time: 15:51
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;

use Closure;

class FNPattern extends FNObject {
    ## Regex Options
    const OPTION_AMBIGUITY_MATCH_ON = 'i';
    const OPTION_ENABLE_EXTENDED_FORM = 'x';
    const OPTION_MATCHES_NEWLINE = 'm';
    const OPTION_ESCAPED = 's';
    const OPTION_MATCHES_NEWLINE_AND_ESCAPE = 'p';
    const OPTION_LONGEST_MATCH = 'l';
    const OPTION_IGNORES_EMPTY_MATCHES = 'n';

    ## Syntax Modes
    const MODE_JAVA = 'j';
    const MODE_GNU_REGEX = 'u';
    const MODE_GREP = 'g';
    const MODE_EMACS = 'c';
    const MODE_RUBY = 'r';
    const MODE_PERL = 'z';
    const MODE_POSIX_BASIC = 'b';
    const MODE_POSIX_EXTENDED = 'd';

    private $_string;
    private $_options;
    private $_encoding;

    protected function __construct($string, $options = NULL) {
        parent::__construct();

        $this->_string = cstring($string);
        $this->_options = $options;
        $this->_encoding = mb_detect_encoding($this->_string);

        if (self::$options === NULL) {
            self::$options = mb_regex_set_options();
        }
    }

    static function initWith($string, $options = NULL) {
        return new static($string, $options);
    }

    static function initWithString(FNString $string, $options = NULL) {
        return new static($string, $options);
    }

    function stringMatches(FNString $string, FNArray &$matches = NULL) {
        mb_regex_encoding($this->_encoding);

        $temp = [];
        $matched = mb_ereg_match($this->_string, cstring($string), $temp);
        $matches = FNArray::initWith($temp);
        return $matched;
    }

    function stringReplace(FNString $string, FNString $replacement) {
        mb_regex_encoding($this->_encoding);

        return s(mb_ereg_replace($this->_string, cstring($string), cstring($replacement)));
    }

    function stringReplaceWithCallback(FNString $string, Closure $callback) {

    }

    function setEncoding($encoding) {
        $this->_encoding = $encoding;
    }

    function encoding() {
        return $this->_encoding;
    }

    function patternString() {
        return s($this->_string);
    }
}

