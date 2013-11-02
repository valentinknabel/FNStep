<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 04.05.13
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;


class FNDictionary extends FNContainer implements FNArrayAccess, \Iterator {
    use FNContainerArrayAccess;

    private $tempKeys;
    private $position;

    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
        return FNMutableDictionary::initWith($this->value());
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
        return n(count($this->value()));
    }

    public static function isValidValue($value) {
        return is_array($value) || is_null($value);
    }

    static function convertValue($value) {
        if (is_array($value)) {
            $helpArr = array();
            foreach ($value as $key => $val) {
                if ($val instanceof object) {
                    $helpArr[$key] = $val;
                }
            }
            return $helpArr;
        } elseif (is_null($value))
            return array(); else return array();
    }

    function offsetExists($offset) {
        if (!($offset instanceof FNNumber))
            $offset = FNNumber::initWith($offset);
        if ($offset instanceof FNNumber)
            return isset($this->value()[$offset->value()]); else return false;
    }

    function offsetGet($offset) {
        return $this->value()[cint($offset)];
    }

    function offsetSet($offset, $value) {
        if (!($offset instanceof FNNumber))
            $offset = FNNumber::initWith($offset);
        if ($offset instanceof FNNumber && $value instanceof object) {
            $temp = $this->value()[$offset->value()];
            $temp[$offset->value()] = $value;
            return $this->returnObjectWith($temp);
        } else return false;
    }

    function offsetUnset($offset) {
        if (!($offset instanceof FNNumber))
            $offset = FNNumber::initWith($offset);
        if ($offset instanceof FNContainer) {
            $temp = $this->value()[$offset->value()];
            unset($temp[$offset->value()]);
            return $this->returnObjectWith($temp);
        } else return false;
    }


    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     */
    public function current() {
        return $this->value()[$this->tempKeys[$this->position]];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     */
    public function next() {
        ++$this->position;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     */
    public function key() {
        return $this->tempKeys[$this->position];
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid() {
        return isset($this->tempKeys[$this->position]) && isset($this->value()[$this->tempKeys[$this->position]]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     */
    public function rewind() {
        $this->position = 0;
        $this->tempKeys = array_keys($this->value());
    }

    function idExists(FNIdentifiable $id) {
        return isset($this->value()[$id->genericIdentifier()->id()->value()]);
    }

    function unsetId(FNIdentifiable $id) {
        unset($this->value()[$id->genericIdentifier()->id()->value()]);
    }

    function setValueForId(FNIdentifiable $id, Object $value) {
        $this->value()[$id->genericIdentifier()->id()->value()] = $value;
    }

    function valueForId(FNIdentifiable $id) {
        return $this->value()[$id->genericIdentifier()->id()->value()];
    }
}

class FNMutableDictionary extends FNDictionary {
    use FNDefaultMutableContainer;
}