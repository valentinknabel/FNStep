<?PHP
//
//!FNStep
//!FNBoolean.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

class FNBoolean extends FNContainer {
    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
        return FNBoolean:: initWith($this->value());
    }

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    public function immutableCopy() {
        return FNMutableBoolean:: initWith($this->value());
    }

    /**
     * Returns an FNBoolean containg TRUE
     * @return FNBoolean
     */
    public static function yes() {
        return static:: initWith(TRUE);
    }

    /**
     * Returns an FNBoolean containg FALSE
     * @return FNBoolean
     */
    public static function no() {
        return static:: initWith(FALSE);
    }


    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value) {
        return TRUE;
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value) {
        return $value ? TRUE : FALSE;
    }

    //!FNCountable
    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size() {
        return n(1);
    }

}

class FNMutableBoolean extends FNBoolean implements FNMutableContainer {
    use FNDefaultMutableContainer;
}


						