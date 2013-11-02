<?PHP
//
//!FNStep
//!FNArrayAccess.php
//
//!Created by Valentin Knabel on 27.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

use ArrayAccess;

/**
 * Class FNArrayAccess
 * @package FNFoundation
 */
interface FNArrayAccess extends ArrayAccess {
    /**
     * @param FNIdentifiable $id
     * @return mixed
     */
    function idExists(FNIdentifiable $id);

    /**
     * @param FNIdentifiable $id
     * @return mixed
     */
    function unsetId(FNIdentifiable $id);

    /**
     * @param FNIdentifiable $id
     * @param object $value
     * @return mixed
     */
    function setValueForId(FNIdentifiable $id, object $value);

    /**
     * @param FNIdentifiable $id
     * @return mixed
     */
    function valueForId(FNIdentifiable $id);
}

/**
 * Class FNContainerArrayAccess
 * @package FNFoundation
 */
trait FNContainerArrayAccess {
    /**
     * @param $offset
     * @return mixed
     */
    abstract function offsetExists($offset);

    /**
     * @param $offset
     * @return mixed
     */
    abstract function offsetUnset($offset);

    /**
     * @param $offset
     * @param $value
     * @return mixed
     */
    abstract function offsetSet($offset, $value);

    /**
     * @param $offset
     * @return mixed
     */
    abstract function offsetGet($offset);

    /**
     *
     * Enter description here ...
     * @param \FNFoundation\FNIdentifiable|\FNFoundation\FNNumber $index
     * @return boolean
     */
    function idExists(FNIdentifiable $index) {
        /** @noinspection PhpUndefinedMethodInspection */
        return isset($this->value()[$index->numericIdentifier()]);
    }

    /**
     *
     * Enter description here ...
     * @param \FNFoundation\FNIdentifiable|\FNFoundation\FNNumber $index
     * @param \FNFoundation\object|object $value
     * @return $this
     */
    function setValueForId(FNIdentifiable $index, object $value) {
        /** @noinspection PhpUndefinedMethodInspection */
        $array = $this->value();
        $array[$index->numericIdentifier()] = $value;
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->returnObjectWith($array);
    }

    /**
     *
     * Enter description here ...
     * @param \FNFoundation\FNIdentifiable|\FNFoundation\FNNumber $index
     * @return FNArray
     */
    function valueForId(FNIdentifiable $index) {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->value()[$index->numericIdentifier()];
    }

    /**
     *
     * Enter description here ...
     * @param \FNFoundation\FNIdentifiable|\FNFoundation\FNNumber $index
     * @return FNArray
     */
    function unsetId(FNIdentifiable $index) {
        /** @noinspection PhpUndefinedMethodInspection */
        $array = $this->value();
        unset($array[$index->numericIdentifier()]);
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->returnObjectWith($array);
    }

}

/**
 * Class FNDefaultTraversable
 * @package FNFoundation
 */
trait FNDefaultTraversable {

}


