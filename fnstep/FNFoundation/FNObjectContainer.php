<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 01.05.13
 * Time: 21:44
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;


/**
 * This class is only for containing objects, not for using them. Use FNProxy in order to call contained methods.
 * @package FNFoundation
 */
/**
 * Class FNObjectContainer
 * @package FNFoundation
 */
class FNObjectContainer extends FNContainer {

    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
        return FNMutableObjectContainer::initWith($this->value());
    }

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    public function immutableCopy() {
        return self::initWith($this->value());
    }

    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size() {
        return n(cint($this->value()));
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isValidValue($value) {
        return is_object($value);
    }


}

/**
 * Class FNMutableObjectContainer
 * @package FNFoundation
 */
class FNMutableObjectContainer extends FNObjectContainer {
    use FNDefaultMutableContainer;
}