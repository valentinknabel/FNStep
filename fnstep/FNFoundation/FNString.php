<?PHP
//
//!FNStep
//!FNString.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;
use FNFoundation\FNNumber;

/**
 * Class FNString
 * @package FNFoundation
 */
class FNString extends FNContainer {
    const CASE_LOWER = MB_CASE_LOWER;
    const CASE_UPPER = MB_CASE_UPPER;
    const CASE_TITLE = MB_CASE_TITLE;

    const UCS_4 = 'UCS-4';
    const UCS_4BE = 'UCS-4BE';
    const UCS_4LE = 'UCS-4LE';
    const UCS_2 = 'UCS-2';
    const UCS_2BE = 'UCS-2BE';
    const UCS_2LE = 'UCS-2LE';
    const UTF_32 = 'UTF-32';
    const UTF_32BE = 'UTF-32BE';
    const UTF_32LE = 'UTF-32LE';
    const UTF_16 = 'UTF-16';
    const UTF_16BE = 'UTF-16BE';
    const UTF_16LE = 'UTF-16LE';
    const UTF_7 = 'UTF-7';
    const UTF7_IMAP = 'UTF7-IMAP';
    const UTF_8 = 'UTF-8';
    const ASCII = 'ASCII';
    const EUC_JP = 'EUC-JP';
    const SJIS = 'SJIS';
    const eucJP_win = 'eucJP-win';
    const SJIS_win = 'SJIS-win';
    const ISO_2022_JP = 'ISO-2022-JP';
    const ISO_2022_JP_MS = 'ISO-2022-JP-MS';
    const CP932 = 'CP932';
    const CP51932 = 'CP51932';

    const MacJapanese = 'MacJapanese';
    const SJIS_DOCOMO = 'SJIS-DOCOMO';
    const SJIS_KDDI = 'SJIS-KDDI';
    const SJIS_SOFTBANK = 'SJIS-SOFTBANK';
    const UTF_8_DOCOMO = 'UTF-8-DOCOMO';
    const UTF_8_Mobile_KDDI_A = 'UTF-8-Mobile#KDDI-A';
    const UTF_8_KDDI = 'UTF-8-KDDI';
    const UTF_8_SOFTBANK = 'UTF-8-SOFTBANK';
    const ISO_2022_JP_KDDI = 'ISO-2022-JP-KDDI';

    const JIS = 'JIS';
    const JIS_ms = 'JIS-ms';
    const CP50220 = 'CP50220';
    const CP50220raw = 'CP50220raw';
    const CP50221 = 'CP50221';
    const CP50222 = 'CP50222';
    const ISO_8859_1 = 'ISO-8859-1';
    const ISO_8859_2 = 'ISO-8859-2';
    const ISO_8859_3 = 'ISO-8859-3';
    const ISO_8859_4 = 'ISO-8859-4';
    const ISO_8859_5 = 'ISO-8859-5';
    const ISO_8859_6 = 'ISO-8859-6';
    const ISO_8859_7 = 'ISO-8859-7';
    const ISO_8859_8 = 'ISO-8859-8';
    const ISO_8859_9 = 'ISO-8859-9';
    const ISO_8859_10 = 'ISO-8859-10';
    const ISO_8859_13 = 'ISO-8859-13';
    const ISO_8859_14 = 'ISO-8859-14';
    const ISO_8859_15 = 'ISO-8859-15';
    const byte2be = 'byte2be';
    const byte2le = 'byte2le';
    const byte4be = 'byte4be';
    const byte4le = 'byte4le';
    const BASE64 = 'BASE64';
    const HTML_ENTITIES = 'HTML-ENTITIES';
    const _7bit = '7bit';
    const _8bit = '8bit';
    const EUC_CN = 'EUC-CN';
    const CP936 = 'CP936';
    /*const GB18030 = ''; PHP5.4*/
    const HZ = 'HZ';
    const EUC_TW = 'EUC-TW';
    const CP950 = 'CP950';
    const BIG_5 = 'BIG-5';
    const EUC_KR = 'EUC-KR';
    const UHC = 'UHC';
    const ISO_2022_KR = 'ISO-2022-KR';
    const Windows_1251 = 'Windows-1251';
    const Windows_1252 = 'Windows-1252';
    const CP866 = 'CP866';
    const KOI8_R = 'KOI8-R';

    const STANDARD_ENCODING = FNString::UTF_8;

    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value) {
        if (is_string($value) || is_numeric($value) || $value == NULL || $value instanceof FNContainer || is_array($value))
            return true;
        return false;
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value) {
        return cstring($value);
    }

    //!FNCountable
    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size() {
        return mb_strlen($this->value(), FNString:: STANDARD_ENCODING);
    }

    //!FNContainer
    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
        return FNMutableString:: initWith($this->value());
    }

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    public function immutableCopy() {
        return FNString:: initWith($this->value());
    }

    //!Allocators
    /**
     * @static initWithRandom
     * @param FNNumber $length = 6
     * @param bool|\FNFoundation\FNString $characters = FALSE
     * @return FNString
     */
    static function initWithRandomString(FNNumber $length = NULL, FNString $characters = NULL) {
        if ($length != NULL)
            $length = $length->value(); else $length = 6;
        if ($characters == NULL)
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; else $characters = $characters->value();
        $string = '';
        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }
        return static::initWith($string);
    }

    /**
     * @param FNArray $array
     * @return FNValidatable|NULL
     */
    static function initWithArray(FNArray $array) {
        $value = '';
        foreach ($array as $string) {
            $value .= static::convertValue($string);
        }
        return static::initWith($value);
    }

    /**
     * @param $value
     * @param string $encoding
     * @return FNValidatable|NULL
     */
    public static function initWith($value, $encoding = FNString::STANDARD_ENCODING) {
        return parent::initWith(mb_convert_encoding(cstring($value), $encoding));
    }


    /**
     * @param string $arg
     * @return FNValidatable|NULL
     */
    static function initWithList(/** @noinspection PhpUnusedParameterInspection */
        $arg = '') {
        $value = '';
        foreach (func_get_args() as $string) {
            $value .= static::convertValue($string);
        }
        return static::initWith($value);
    }

    //!Implementation
    /**
     * @method valueWithEncoding
     * @param int|string $encoding
     * @return string
     */
    function valueWithEncoding($encoding = FNString::UTF_8) {
        return mb_convert_encoding($this->value(), $encoding);
    }

    /**
     * @return string
     */
    function encoding() {
        return mb_detect_encoding($this->value());
    }

    ##Substrings
    /**
     * @method substring
     * @param FNNumber $start
     * @param FNNumber $length
     * @return FNString
     */
    public function substring(FNNumber $start, FNNumber $length = NULL) {
        if ($length !== NULL)
            $length = $length->value();
        return $this->returnObjectWith(mb_substr($this->value(), $start->value(), $length->value(), FNString::STANDARD_ENCODING));
    }

    /**
     * @method trimWidth
     * @param FNNumber $start
     * @param FNNumber $width
     * @param FNString $trimMarker
     * @internal param \FNFoundation\FNString $trimMarker
     * @return FNString - else false
     * @link http://de2.php.net/manual/en/function.mb_strimwdith.php
     */
    public function trimWidth(FNNumber $start, FNNumber $width, FNString $trimMarker = NULL) {
        return $this->returnObjectWith(mb_strimwidth($this->value(), $start->value(), $width->value(), $trimMarker->value(), FNString::STANDARD_ENCODING));
    }

    /**
     * @method substringToInsensitve
     * @param FNString $needle
     * @param mixed $first
     * @return FNString
     * @link http://de2.php.net/manual/en/function.mb_stristr.php
     * @link http://de2.php.net/manual/en/function.stristr.php
     */
    function substringToInsensitive(FNString $needle, $first = TRUE) {
        return $this->returnObjectWith(mb_stristr($this->value(), $needle->value(), $first, FNString::STANDARD_ENCODING));
    }

    /**
     * @method substringTo
     * @param FNString $needle
     * @param bool $first
     * @return FNString
     * @link http://de2.php.net/manual/en/function.mb_strstr.php
     * @link http://de2.php.net/manual/en/function.strstr.php
     */
    function substringTo(FNString $needle, $first = TRUE) {
        return $this->returnObjectWith(mb_strstr($this->value(), $needle->value(), $first, FNString::STANDARD_ENCODING));
    }

    /**
     * @method charWithIndex
     * @param FNNumber $num
     * @return FNString
     * @link http://de2.php.net/manual/en/function.chr.php
     */
    function charWithIndex(FNNumber $num) {
        return $this->returnObjectWith(chr($this->value(), $num->value()));
    }

    /**
     * @method trimLeft
     * @param FNString $charList
     * @return FNString
     */
    function trimLeft(FNString $charList = NULL) {
        if ($charList)
            $charList = $charList->value();
        return $this->returnObjectWith(ltrim($this->value(), $charList));
    }

    /**
     * @method trimRight
     * @param FNString $charList
     * @return FNString
     */
    function trimRight(FNString $charList) {
        if ($charList)
            $charList = $charList->value();
        return $this->returnObjectWith(rtrim($this->value(), $charList));
    }

    /**
     * @method substringSinceOccurrence
     * @param FNString $needle
     * @param boolean $before
     * @return FNString
     */
    function substringSinceOccurrence(FNString $needle, $before = FALSE) {
        return $this->returnObjectWith(mb_stristr($this->value(), $needle->value(), $before, FNString::STANDARD_ENCODING));
    }

    /**
     * @method substringSinceChars
     * @param FNString $charList
     * @return FNString
     */
    function substringSinceChars(FNString $charList) {
        return $this->returnObjectWith(strpbrk($this->value(), $charList->value()));
    }

    /**
     * @method substringSinceLastChar
     * @param FNString $char
     * @return FNString
     */
    function substringSinceLastChar(FNString $char) {
        return $this->returnObjectWith(strrchr($this->value(), $char->value()));
    }

    /**
     * @method appendString
     * @param FNString $string
     * @return FNString
     */
    function appendString(FNString $string) {
        return $this->returnObjectWith($this->value() . $string->value());
    }

    /**
     * @method containsSubstring
     * @param FNString $substring
     * @return boolean
     */
    function containsSubstring(FNString $substring) {
        return strpos($this->value(), $substring->value()) === FALSE;
    }

    ##Type-Conversions
    /**
     * @method bin2hex
     * @return FNString
     */
    function bin2hex() {
        return $this->returnObjectWith(bin2hex($this->value()));
    }

    /**
     * @method splitRegular
     * @param FNString $pattern
     * @param FNNumber $limit
     * @return FNString
     */
    public function splitRegular(FNString $pattern, FNNumber $limit = NULL) {
        if ($limit === NULL)
            $limit = FNNumber::initWith(-1);
        return FNArray::initWith(mb_split($pattern->value(), $this->value(), $limit->value()));
    }

    /**
     * @method explode
     * @param FNString $separator
     * @param FNNumber $limit
     * @return FNArray
     */
    function explode(FNString $separator, FNNumber $limit = null) {
        $array = null;
        if ($limit === NULL)
            $array = explode($separator->value(), $this->value()); else $array = explode($separator->value(), $this->value(), $limit->value());
        foreach ($array as $key => $value) {
            $array[$key] = FNString::initWith($value);
        }
        return FNArray::initWith($array);
    }

    /**
     * @method parse
     * @param FNArray $data
     * @return void
     */
    function parse(FNArray &$data) {
        $arr = NULL;
        parse_str($this->value(), $arr);
        $data = FNArray::initWith($arr);
    } //@MODIFIED - $arr instead of &$arr(Deprecated)
    /**
     * @method csvArray
     * @param FNString $separator
     * @param FNString $enclosure
     * @param FNString $escape
     * @return FNArray
     */
    function csvArray(FNString $separator = NULL, FNString $enclosure = NULL, FNString $escape = NULL) {
        if ($separator === NULL)
            $separator = FNString::initWith(',');
        if ($enclosure === NULL)
            $enclosure = FNString::initWith('"');
        if ($escape === NULL)
            $escape = FNString::initWith('\\');
        return FNArray::initWith(str_getcsv($this->value(), $separator->value(), $enclosure->value(), $escape->value()));
    }

    /**
     * @method split
     * @return FNArray
     */
    function split() {
        return FNArray::initWith(str_split($this->value()));
    }

    ##Encoding-Conversions

    /**
     * urlEncode
     * @author Valentin Knabel
     * @since 27.05.12
     * @revision 4518745504
     */
    function urlEncode() {
        return $this->returnObjectWith(urlencode($this->value()));
    }

    /**
     * urlDecode
     * @author Valentin Knabel
     * @since 27.05.12
     * @revision 4525668800
     */
    function urlDecode() {
        return $this->returnObjectWith(urldecode($this->value()));
    }

    /**
     * @method convertKana
     * @param FNString $option
     * @return FNString - else false
     * @link http://cn.php.net/manual/en/function.mb-convert-kana.php
     */
    public function convertKana(FNString $option = NULL) {
        if ($option)
            $option = $option->value();
        return $this->returnObjectWith(mb_convert_kana($this->value(), $option->value(), FNString::STANDARD_ENCODING));
    }

    /**
     * @method convertCyrillic
     * @deprecated
     * @param FNString $to
     * @return FNString
     */
    function convertCyrillic(FNString $to) {
        return $this->returnObjectWith(convert_cyr_string($this->value(), $this->encoding(), $to->value()));
    }

    /**
     * @method convertUudecode
     * @deprecated unsafe
     * @return FNString
     */
    function convertUudecode() {
        return $this->returnObjectWith(convert_uudecode($this->value()));
    }

    /**
     * @method convertUuencode
     * @deprecated unsafe
     * @return FNString
     */
    function convertUuencode() {
        return $this->returnObjectWith(convert_uuencode($this->value()));
    }

    ##Case-Conversions
    /**
     * @method convertCase
     * @param int $mode
     * @return FNString
     * @link http://cn.php.net/manual/en/function.mb-convert-case.php
     * @link http://cn.php.net/manual/en/function.strtoupper.php
     * @link http://cn.php.net/manual/en/function.strtolower.php
     * @link http://cn.php.net/manual/en/function.ucwords.php
     */
    public function convertCase($mode) {
        return $this->returnObjectWith(mb_convert_case($this->value(), cint($mode), FNString::STANDARD_ENCODING));
    }

    /**
     * @method lowerCase
     * @return FNString
     */
    function lowerCase() {
        if (function_exists('mb_strtolower'))
            return $this->returnObjectWith(mb_strtolower($this->value(), FNString::STANDARD_ENCODING)); else return $this->returnObjectWith(strtolower($this->value()));
    }

    /**
     * @method upperCase
     * @return FNString
     */
    function upperCase() {
        if (function_exists('mb_strtoupper'))
            return $this->returnObjectWith(mb_strtoupper($this->value(), FNString::STANDARD_ENCODING)); else return $this->returnObjectWith(strtoupper($this->value()));
    }

    /**
     * @method firstCharacterToLowerCase
     * @return FNString
     */
    function firstCharacterToLowerCase() {
        return $this->returnObjectWith(lcfirst($this->value()));
    }

    /**
     * @method firstCharacterToUpperCase
     * @return FNString
     */
    function firstCharacterToUpperCase() {
        return $this->returnObjectWith(ucfirst($this->value()));
    }

    ##RegExp

    function pattern() {
        return FNPattern::initWithString($this);
    }

    ##Security

    function sha256() {
        return $this->returnObjectWith(hash('sha256', $this->value()));
    }

    function sha384() {
        return $this->returnObjectWith(hash('sha384', $this->value()));
    }

    function sha512() {
        return $this->returnObjectWith(hash('sha512', $this->value()));
    }

    //TODO add AES-128, AES-192, AES-256,

    ##manipulation
    /**
     * @method addSlashes
     * @param FNString $charList
     * @return FNString
     */
    function addSlashes(FNString $charList) {
        return $this->returnObjectWith(addSlashes($this->value(), $charList->value()));
    }

    /**
     * @method addCSlashes
     * @param FNString $charList
     * @return FNString
     */
    function addCSlashes(FNString $charList) {
        return $this->returnObjectWith(addCSlashes($this->value(), $charList->value()));
    }

    /**
     * @method decodeHTMLEntities
     * @param FNNumber $flags
     * @return FNString
     */
    function decodeHTMLEntities(FNNumber $flags = NULL) {
        if (!$flags)
            $flags = n(0);
        return $this->returnObjectWith(html_entity_decode($this->value(), $flags->value(), FNString::STANDARD_ENCODING));
    }

    /**
     * @method encodeHTMLEntities
     * @param FNString $data
     * @param boolean $doubleEncode
     * @return FNString
     */
    function encodeHTMLEntities(FNString $data = NULL, $doubleEncode = TRUE) {
        if ($data === NULL)
            $data = FNString::initWith(ENT_COMPAT | ENT_HTML401);
        return $this->returnObjectWith(htmlentities($this->value(), $data->value(), FNString::STANDARD_ENCODING, $doubleEncode));
    }

    /**
     * @method decodeSpecialHTMLChars
     * @param FNNumber $flags
     * @return FNString
     */
    function decodeSpecialHTMLChars(FNNumber $flags = NULL) {
        if ($flags === NULL)
            $flags = FNNumber::initWith(ENT_COMPAT);
        return $this->returnObjectWith(htmlspecialchars_decode($this->value(), $flags->value()));
    }

    /**
     * @method encodeSpecialHTMLChars
     * @param FNNumber $flags
     * @param boolean $doubleEncode
     * @return FNString
     */
    function encodeSpecialHTMLChars(FNNumber $flags = NULL, $doubleEncode = true) {
        if ($flags === NULL)
            $flags = FNNumber::initWith(ENT_COMPAT | ENT_HTML401);
        return $this->returnObjectWith(convert_uudecode($this->value(), $flags->value(), FNString::STANDARD_ENCODING, $doubleEncode));
    }

    /**
     * @method newLine2Br
     * @param bool $xhtml
     * @internal param bool $data
     * @return FNString
     */
    function newLine2Br($xhtml = TRUE) {
        return $this->returnObjectWith(nl2br($this->value(), $xhtml));
    }

    /**
     * @method quoteMetaChars
     * @return FNString
     */
    function quoteMetaChars() {
        return $this->returnObjectWith(quotemeta($this->value()));
    }

    /**
     * @method shuffle
     * @return FNString
     */
    function shuffle() {
        return $this->returnObjectWith(str_shuffle($this->value()));
    }

    /**
     * @method stripTags
     * @param FNString $allowedTags
     * @return FNString
     */
    function stripTags(FNString $allowedTags = NULL) {
        if ($allowedTags)
            $allowedTags = $allowedTags->value();
        return $this->returnObjectWith(strip_tags($this->value(), $allowedTags));
    }

    /**
     * @method stripCSlashes
     * @return FNString
     */
    function stripCSlashes() {
        return $this->returnObjectWith(stripcslashes($this->value()));
    }

    /**
     * @method stripSlashes
     * @return FNString
     */
    function stripSlashes() {
        return $this->returnObjectWith(stripslashes($this->value()));
    }

    /**
     * @method reverse
     * @return FNString
     */
    function reverse() {
        return $this->returnObjectWith(strrev($this->value()));
    }

    /**
     * @method replaceStringBefore
     * @param FNString $search
     * @param FNString $to
     * @return FNString
     */
    function replaceStringBefore(FNString $search, FNString $to) {
        return $this->returnObjectWith(strtr($this->value(), $search->value(), $to->value()));
    }

    /**
     * @method trim
     * @param FNString $charList
     * @return FNString
     */
    function trim(FNString $charList = null) {
        if ($charList)
            $charList = $charList->value();
        return $this->returnObjectWith(trim($this->value(), $charList));
    }

    /**
     * @method wrapWords
     * @param FNNumber $data
     * @param FNNumber $width
     * @param FNString $break
     * @param boolean $cut
     * @return FNString
     */
    function wrapWords(FNNumber $data, FNNumber $width = NULL, FNString $break = NULL, $cut = false) {
        if ($width === NULL)
            $width = FNNumber::initWith(75);
        if ($break === NULL)
            $break = FNString::initWith('\n');
        return $this->returnObjectWith(wordwrap($this->value(), $data->value(), $width->value(), $break->value(), $cut));
    }

    /**
     * @method replaceSubstring
     * @param FNString $replace
     * @param FNNumber $start
     * @param FNNumber $length
     * @return FNString
     */
    function replaceSubstring(FNString $replace, FNNumber $start, FNNumber $length = null) {
        if ($length)
            $length = $length->value();
        return $this->returnObjectWith(substr_replace($this->value(), $replace->value(), $start->value(), $length->value()));
    }

    /**
     * @method insensitiveReplace
     * @param FNString $data
     * @param FNString $replace
     * @param FNNumber $count
     * @return FNString
     */
    function insensitiveReplace(FNString $data, FNString $replace, &$count = null) {
        $temp = NULL;
        $return = $this->returnObjectWith(str_ireplace($data->value(), $replace->value(), $this->value(), $temp));
        $count = FNNumber::initWith($temp);
        return $return;
    }

    /**
     * @method pad
     * @param FNNumber $data
     * @param FNString $pad
     * @param FNNumber $padType
     * @return \FNFoundation\FNContainer
     */
    function pad(FNNumber $data, FNString $pad = NULL, FNNumber $padType = NULL) {
        if ($pad === NULL)
            $pad = FNString::initWith(' ');
        if ($padType === NULL)
            $padType = FNNumber::initWith(STR_PAD_RIGHT);
        return $this->returnObjectWith(str_pad($this->value(), $data->value(), $pad->value(), $padType->value()));
    }

    /**
     * @method repeat
     * @param FNNumber $times
     * @return FNString
     */
    function repeat(FNNumber $times) {
        return $this->returnObjectWith(str_repeat($this->value(), $times->value()));
    }

    /**
     * @method replaceString
     * @param FNString $search
     * @param FNString $replace
     * @param FNNumber &$count
     * @return FNString
     */
    function replaceString(FNString $search, FNString $replace, &$count = null) {
        $temp = NULL;
        $return = $this->returnObjectWith(str_replace($search->value(), $replace->value(), $this->value(), $temp)); //@MODIFIED $count instead of &$count(Deprecated)
        $count = FNNumber::initWith($temp);
        return $return;
    }

    ##count/position
    /**
     * @method countWords
     * @param FNNumber $option
     * @param FNString $charList
     * @internal param \FNFoundation\FNNumber $data
     * @internal param \FNFoundation\FNString $charList
     * @return FNString
     */
    function countWords(FNNumber $option = NULL, FNString $charList = NULL) {
        if (!$option)
            $option = FNNumber::zero();
        if ($charList === NULL)
            $charList = FNString::initWith('');
        return $this->returnObjectWith(str_word_count($this->value(), $option->value(), $charList->value()));
    }

    /**
     * @method positionOfMissingChar
     * @param FNString $char
     * @param FNNumber $start
     * @param FNNumber $length
     * @return FNNumber
     */
    function positionOfMissingChar(FNString $char, FNNumber $start = NULL, FNNumber $length = null) {
        if ($start === NULL)
            $start = FNNumber::initWith(0);
        return $this->returnObjectWith(strcspn($this->value(), $char->value(), $start->value(), $length->value()));
    }

    /**
     * @method positionOf
     * @param FNString $data
     * @return FNNumber
     */
    function positionOf(FNString $data) {
        return FNNumber::initWith(strpos($this->value(), $data->value()));
    }

    /**
     * @method insensitivePositionOf
     * @param FNString $data
     * @param FNNumber $offset
     * @return FNNumber
     */
    function insensitivePositionOf(FNString $data, FNNumber $offset = NULL) {
        if ($offset === NULL)
            $offset = FNNumber::initWith(0);
        return FNNumber::initWith(stripos($this->value(), $data->value(), $offset->value()));
    }

    /**
     * @method positionOfLastInsensitiveOccurrence
     * @param FNString $data
     * @param FNNumber $offset
     * @return FNNumber
     */
    function positionOfLastInsensitiveOccurrence(FNString $data, FNNumber $offset = NULL) {
        if ($offset === NULL)
            $offset = FNNumber::initWith(0);
        return $this->returnObjectWith(strripos($this->value(), $data->value(), $offset->value()));
    }

    /**
     * @method positionOfLastOccurrence
     * @param FNString $data
     * @param FNNumber $offset
     * @return FNNumber
     */
    function positionOfLastOccurrence(FNString $data, FNNumber $offset = NULL) {
        if ($offset === NULL)
            $offset = FNNumber::initWith(0);
        return $this->returnObjectWith(strrpos($this->value(), $data->value(), $offset->value()));
    }

    /**
     * @method lengthOfChars
     * @param FNString $data
     * @param FNNumber $start
     * @param FNNumber $length
     * @return FNNumber
     */
    function lengthOfSubstringOfChars(FNString $data, FNNumber $start = NULL, FNNumber $length = NULL) {
        if ($start === NULL)
            $start = FNNumber::initWith(0);
        return $this->returnObjectWith(strspn($this->value(), $data->value(), $start->value(), $length->value()));
    }

    /**
     * @method countSubstring
     * @param FNString $needle
     * @return FNNumber
     */
    function countSubstring(FNString $needle) {
        return FNNumber::initWith(mb_substr_count($this->value(), $needle->value()));
    }

    /**
     * @method positionOfLastInsensitive
     * @param FNString $data
     * @param FNNumber $offset
     * @return FNNumber
     */
    function positionOfLastInsensitive(FNString $data, FNNumber $offset = NULL) {
        if ($offset === NULL)
            $offset = FNNumber::initWith(0);
        return $this->returnObjectWith(mb_stripos($this->value(), $data->value(), $offset->value(), FNString::STANDARD_ENCODING));
    }

    ##Others
    /**
     * @method stringWidth
     * @return FNNumber
     */
    function stringWidth() {
        return FNNumber::initWith(mb_strwidth($this->value(), FNString::STANDARD_ENCODING));
    }

    /**
     * @param FNContainer $container
     * @return FNContainer
     */
    function format(/** @noinspection PhpUnusedParameterInspection */
        FNContainer $container = NULL /*infinite arguments*/) {
        $array = array($this->value());

        foreach (func_get_args() as $arg) {
            if (function_exists(array($arg, 'value')))
                /** @noinspection PhpUndefinedMethodInspection */
                $array[] = $arg->value(); else $array[] = FNString::initWith('');
        }

        return $this->returnObjectWith(call_user_func_array('sprintf', func_get_args()));
    }

    /**
     * @param FNArray $containers
     * @return FNContainer
     */
    function formatArray(FNArray $containers) {
        $array = array($this->value());

        foreach ($containers as $arg) {
            if (function_exists(array($arg, 'value')))
                /** @noinspection PhpUndefinedMethodInspection */
                $array[] = $arg->value(); else $array[] = FNString::initWith('');
        }

        return $this->returnObjectWith(call_user_func_array('sprintf', func_get_args()));
    }

}

/**
 * Class FNMutableString
 * @package FNFoundation
 */
class FNMutableString extends FNString implements FNMutableContainer {
    use FNDefaultMutableContainer;
}

