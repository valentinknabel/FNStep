<?PHP
//
//!FNStep
//!FNArrayAccess.php
//
//!Created by Valentin Knabel on 27.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;
use \ArrayAccess;

interface FNArrayAccess extends ArrayAccess
{
    function idExists(FNIdentifiable $id);

    function unsetId(FNIdentifiable $id);

    function setValueForId(FNIdentifiable $id, object $value);

    function valueForId(FNIdentifiable $id);
}

trait FNContainerArrayAccess
{
    abstract function offsetExists($offset);

    abstract function offsetUnset($offset);

    abstract function offsetSet($offset, $value);

    abstract function offsetGet($offset);

    /**
     *
     * Enter description here ...
     * @param \FNFoundation\FNIdentifiable|\FNFoundation\FNNumber $index
     * @return boolean
     */
    function idExists(FNIdentifiable $index)
    {
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
    function setValueForId(FNIdentifiable $index, object $value)
    {
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
    function valueForId(FNIdentifiable $index)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->value()[$index->numericIdentifier()];
    }

    /**
     *
     * Enter description here ...
     * @param \FNFoundation\FNIdentifiable|\FNFoundation\FNNumber $index
     * @return FNArray
     */
    function unsetId(FNIdentifiable $index)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $array = $this->value();
        unset($array[$index->numericIdentifier()]);
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->returnObjectWith($array);
    }

}


