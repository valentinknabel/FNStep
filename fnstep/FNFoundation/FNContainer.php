<?PHP
//
//!FNStep
//!FNContainer.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

interface FNMutableContainer extends FNMutable
{
    /**
     * Sets the value of the container.
     * @arg mixed $value
     * @param $value
     * @return void
     */
    public function setValue($value);
}

trait FNDefaultMutableContainer
{
    /**
     * Sets the value of the container.
     * @arg mixed $value
     * @param $value
     * @return void
     */
    public function setValue($value)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $this->returnObjectWith($value);
    }
}

abstract class FNContainer extends FNObject implements FNComparable, FNCountable, FNValidatable
{
    use FNDefaultCountable;

    /**
     * The contained value
     * @type mixed
     */
    private $_value;

    protected function __construct($value)
    {
        $this->_value = static::convertValue($value);
    }

    /**
     * Returns the description of the current object.
     * @return FNString
     */
    public function __toString()
    {
        return cstring($this->_value);
    }

    //!Implementation
    /**
     * Changes the own value if mutable, else returns a new object.
     * @arg mixed $value
     * @param $value
     * @return FNContainer
     */
    protected function returnObjectWith($value)
    {
        if ($this->isMutable()) {
            $this->_value = static:: convertValue($value);
            return $this;
        } else return static:: initWith($value);
    }

    /**
     * Returns the represented value
     * @return mixed
     */
    public function value()
    {
        return $this->_value;
    }

    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    abstract public function mutableCopy();

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    abstract public function immutableCopy();

    //!FNComparable
    /**
     * Returns if both objects/values are equal
     * @arg mixed $value
     * @param $value
     * @return boolean
     */
    public function isEqualTo($value)
    {
        if (static::isValidValue($value)) {
            $value = static::convertValue($value);
            if ($this->_value instanceof FNComparable) {
                return $this->_value->isEqualTo($value);
            } else return $this->_value == $value;
        } else return FALSE;
    }

    //!FNValidatable
    /**
     * Returns an instance.
     * @param $value
     * @throws FNVersionException
     * @return FNValidatable|NULL
     */
    public static function initWith($value)
    {
        if (static::cls() != FNContainer::cls()) {
            if (static::isValidValue($value))
                return new static($value);
            else return NULL;
        } else {
            switch (gettype($value)) {
                case NULL_TYPE:
                    return FNNil::init();
                case BOOLEAN_TYPE:
                    return FNBoolean::initWith($value);
                case INTEGER_TYPE:
                    return FNNumber::initWith($value);
                case FLOAT_TYPE:
                    return FNNumber::initWith($value);
                case STRING_TYPE:
                    return FNString::initWith($value);
                case ARRAY_TYPE:
                    $keyed = TRUE;
                    $indexed = TRUE;
                    foreach (array_keys($value) as $id) {
                        if ($keyed) {
                            $keyed = is_string($id);
                        }
                        if ($indexed) {
                            $indexed = is_int($id);
                        } else break;
                    }
                    if ($indexed) {
                        return FNArray::initWith($value);
                    } else if ($keyed) {
                        return FNDictionary::initWith($value);
                    } else return FNSet::initWith(array_values($value));
                case RESOURCE_TYPE:
                    return FNResource::initWith($value);
                case OBJECT_TYPE:
                    if ($value instanceof FNContainer)
                        return $value;
                    if ($value instanceof FNIdentifiable)
                        return FNContainer::initWith($value);
                    if ($value instanceof FNObject)
                        return FNString::initWith($value);
                    if (method_exists($value, '__toString'))
                        /** @noinspection PhpUndefinedMethodInspection */
                        return FNString::initWith($value->__toString());
                    return FNObjectContainer::initWith($value);
                default:
                    throw new FNVersionException('Update FNFoundation: a new PHP-type has been added');
            }
        }
    }

    /**
     * Returns if the value is valid.
     * @param $value
     * @throws FNUnimplementedMethod
     * @return boolean
     */
    public static function isValidValue($value)
    {
        throw new FNUnimplementedMethod(__METHOD__);
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @throws FNUnimplementedMethod
     * @return mixed
     */
    public static function convertValue($value)
    {
        throw new FNUnimplementedMethod(__METHOD__);
    }

}


						