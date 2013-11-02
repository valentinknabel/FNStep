<?PHP
//
//!FNStep
//!FNArray.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

use Iterator;

/**
 * Class FNArray
 * @package FNFoundation
 */
class FNArray extends FNContainer implements FNArrayAccess, Iterator {
    use FNContainerArrayAccess;

    /**
     * @var int
     */
    private $position = 0;

    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value) {
        return is_array($value);
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value) {
        return carraya($value);
    }

    //!FNCountable
    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size() {
        return n(count($this->value()));
    }

    //!FNContainer
    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
        return FNMutableArray:: initWith($this->value());
    }

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    public function immutableCopy() {
        return FNArray:: initWith($this->value());
    }

    //!Allocators
    /**
     *
     * @param \FNFoundation\object|object $object1
     * @return FNArray
     */
    static function initWithList(/** @noinspection PhpUnusedParameterInspection */
        Object $object1 = NULL) {
        return static::initWith(func_get_args());
    }

    //!Iterator
    /**
     *(non-PHPdoc)
     * @see Iterator::current()
     */
    public function current() {
        return $this->value()[$this->position];
    }

    /**
     *(non-PHPdoc)
     * @see Iterator::key()
     */
    public function key() {
        return $this->position;
    }

    /**
     *(non-PHPdoc)
     * @see Iterator::next()
     */
    public function next() {
        ++$this->position;
    }

    /**
     *(non-PHPdoc)
     * @see Iterator::rewind()
     */
    public function rewind() {
        $this->position = 0;
    }

    /**
     *(non-PHPdoc)
     * @see Iterator::valid()
     */
    public function valid() {
        return isset($this->value()[$this->position]);
    }

    //!ArrayAccess
    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetExists()
     */
    function offsetExists($offset) {
        if (!($offset instanceof FNNumber))
            $offset = FNNumber::initWith($offset);
        if ($offset instanceof FNNumber)
            return isset($this->value()[$offset->value()]); else return false;
    }

    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetGet()
     */
    function offsetGet($offset) {
        return $this->value()[cint($offset)];
    }

    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetSet()
     */
    function offsetSet($offset, $value) {
        if (!($offset instanceof FNNumber))
            $offset = FNNumber::initWith($offset);
        if ($offset instanceof FNNumber && $value instanceof object) {
            $temp = $this->value()[$offset->value()];
            $temp[$offset->value()] = $value;
            return $this->returnObjectWith($temp);
        } else return false;
    }

    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetUnset()
     */
    function offsetUnset($offset) {
        if (!($offset instanceof FNNumber))
            $offset = FNNumber::initWith($offset);
        if ($offset instanceof FNContainer) {
            $temp = $this->value()[$offset->value()];
            unset($temp[$offset->value()]);
            return $this->returnObjectWith($temp);
        } else return false;
    }

    //!Implementation
    /**
     * adds objects to the end of the array
     * infinite arguments
     * @param \FNFoundation\Object|Object $object
     * @return FNArray
     */
    function add(/** @noinspection PhpUnusedParameterInspection */
        Object $object = NULL) {
        $value = $this->value();
        foreach (func_get_args() as $arg) {
            if ($arg instanceof object)
                $value[] = $arg;
        }
        return $this->returnObjectWith($value);
    }

    /**
     * @method chunk
     * @param FNNumber $size
     * @return FNArray
     */
    function chunk(FNNumber $size) {
        return $this->returnObjectWith(array_chunk($this->value(), $size->value()));
    }

    /**
     * @method combine
     * @param FNArray $values
     * @return FNDictionary
     */
    function combine(FNArray $values) {
        return FNDictionary::initWith(array_combine($this->value(), $values->value()));
    }

    /**
     * @method containsObject
     * @param \FNFoundation\object|object $object $object
     * @return bool
     */
    function containsObject(object $object) {
        return in_array($object, $this->value());
    }

    /**
     * @method difference
     * @param FNArray $array, infinite
     * @param FNArray $array1
     * @return FNSet
     */
    function difference(/** @noinspection PhpUnusedParameterInspection */
        FNArray $array, FNArray $array1 = NULL /* FNArray infinite*/) {
        $param_array = array();
        foreach (func_get_args() as $value) {
            if ($value instanceof FNArray) {
                $param_array[] = $value->value();
            }
        }
        return FNSet::initWith(call_user_func_array('array_diff', $param_array));
    }

    /**
     * @method differenceAssociation
     * @param FNArray $array, infinite
     * @param FNArray $array1
     * @return FNSet
     */
    function differenceAssociation(/** @noinspection PhpUnusedParameterInspection */
        FNArray $array, FNArray $array1 = NULL /* FNArray infinite*/) {
        $param_array = array();
        foreach (func_get_args() as $value) {
            if ($value instanceof FNArray) {
                $param_array[] = $value->value();
            }
        }
        return FNSet::initWith(call_user_func_array('array_diff_assoc', $param_array));
    }

    /**
     * @method differenceAssociation
     * @param FNArray $array, infinite..... FNString $callback
     * @param FNArray $array1
     * @return FNSet
     */
    function differenceIndexAssociation(/** @noinspection PhpUnusedParameterInspection */
        FNArray $array, FNArray $array1 = NULL /* FNArray infinite*/) {
        $param_array = array();
        foreach (func_get_args() as $value) {
            if ($value instanceof FNArray) {
                $param_array[] = $value->value();
            }
        }
        $func = func_get_arg(func_num_args() - 1);
        if ($func instanceof FNString)
            $func = $func->value();
        $param_array[] = $func;
        return FNSet::initWith(call_user_func_array('array_diff_uassoc', $param_array));
    }

    /**
     * @method filter
     * @param FNString $function
     * @return FNArray
     */
    function filter(FNString $function) {
        if ($function)
            $function = $function->value();
        /** @var $function string */
        return $this->returnObjectWith(array_filter($this->value(), $function));
    }

    /**
     *
     * @param FNArray $array
     * @param FNArray $array2
     * @return FNArray
     */
    function mergeRecursive(/** @noinspection PhpUnusedParameterInspection */
        FNArray $array, FNArray $array2 = NULL /*infinite arguments*/) {
        $args = array($this->value());
        foreach (func_get_args() as $arg) {
            if ($arg instanceof FNArray)
                $args[] = $arg;
        }
        return $this->returnObjectWith(call_user_func_array('array_merge_recursive', $args));
    }

    /**
     *
     * @param FNArray $array
     * @param FNArray $array2
     * @return FNArray
     */
    function merge(/** @noinspection PhpUnusedParameterInspection */
        FNArray $array, FNArray $array2 = NULL /*infinite arguments*/) {
        $args = array($this->value());
        foreach (func_get_args() as $arg) {
            if ($arg instanceof FNArray)
                $args[] = $arg;
        }
        return $this->returnObjectWith(call_user_func_array('array_merge', $args));
    }

}

/**
 * Class FNMutableArray
 * @package FNFoundation
 */
class FNMutableArray extends FNArray implements FNMutableContainer {
    use FNDefaultMutableContainer;
}



						