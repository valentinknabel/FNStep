<?php
/**
 * Created by JetBrains PhpStorm.
 * User: valentinknabel
 * Date: 04.05.13
 * Time: 14:44
 * To change this template use File | Settings | File Templates.
 */

namespace FNFoundation;

/**
 * Class FNDictionary
 * @package FNFoundation
 */
class FNDictionary extends FNContainer implements FNArrayAccess, \Iterator {
    use FNContainerArrayAccess;

    /**
     * @var array
     */
    private $tempKeys;
    /**
     * @var int
     */
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

    /**
     * @param $value
     * @return bool
     */
    public static function isValidValue($value) {
        return is_array($value) || is_null($value);
    }

    /**
     * @param $value
     * @return array
     */
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

    /**
     * @param mixed $offset
     * @return bool
     */
    function offsetExists($offset) {
        if (!($offset instanceof FNNumber))
            $offset = FNNumber::initWith($offset);
        if ($offset instanceof FNNumber)
            return isset($this->value()[$offset->value()]); else return false;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    function offsetGet($offset) {
        return $this->value()[cint($offset)];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return bool|FNContainer
     */
    function offsetSet($offset, $value) {
        if (!($offset instanceof FNString))
            $offset = FNString::initWith($offset);
        if ($offset instanceof FNString && $value instanceof object) {
            $temp = $this->value();
            $temp[$offset->value()] = $value;
            return $this->returnObjectWith($temp);
        } else return false;
    }

    /**
     * @param mixed $offset
     * @return bool|FNContainer
     */
    function offsetUnset($offset) {
        if (!($offset instanceof FNString))
            $offset = FNString::initWith($offset);
        if ($offset instanceof FNContainer) {
            $temp = $this->value();
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

    /**
     * @param FNIdentifiable $id
     * @return bool
     */
    function idExists(FNIdentifiable $id) {
        return isset($this->value()[$id->genericIdentifier()->id()->value()]);
    }

    /**
     * @param FNIdentifiable $id
     */
    function unsetId(FNIdentifiable $id) {
        unset($this->value()[$id->genericIdentifier()->id()->value()]);
    }

    /**
     * @param FNIdentifiable $id
     * @param \FNFoundation\Object $value
     */
    function setValueForId(FNIdentifiable $id, Object $value) {
        $this->value()[$id->genericIdentifier()->id()->value()] = $value;
    }

    /**
     * @param FNIdentifiable $id
     * @return mixed
     */
    function valueForId(FNIdentifiable $id) {
        return $this->value()[$id->genericIdentifier()->id()->value()];
    }

    /**
     * @param FNDictionary $dictionary
     */
    function addDictionary(FNDictionary $dictionary) {

    }

    /**
     * @param FNArray $values
     * @param FNArray $keys
     */
    function addValuesWithKeys(FNArray $values, FNArray $keys) {

    }
}

/**
 * Class FNMutableDictionary
 * @package FNFoundation
 */
class FNMutableDictionary extends FNDictionary implements FNMutableContainer {
    use FNDefaultMutableContainer;
}