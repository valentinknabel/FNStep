<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 01.05.13
 * Time: 23:57
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;


class FNPattern extends FNObject {
    private $pattern;

    protected function __construct(FNString $pattern) {
        $this->pattern = $pattern;
    }

    public static function init() {
        return static::initWithString(s());
    }

    public static function initWith($pattern) {
        return static::initWithString(s($pattern));
    }

    public static function initWithId(FNIdentifiable $pattern) {
        return static::initWithString(s($pattern));
    }

    public static function initWithString(FNString $pattern) {
        $cpattern = $pattern->value();
        FNTodo("validate the pattern");

        /** @var $cpattern string */
        /** @noinspection PhpParamsInspection */
        return new static(FNString::initWith($cpattern, $pattern->encoding()));
    }

}