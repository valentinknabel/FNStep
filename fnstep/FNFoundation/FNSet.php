<?PHP
//
//!FNStep
//!FNSet.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

class FNSet extends FNContainer
{
    //equal for FNContainer means -isEqualTo
    //equal for primitives means ==
    const COMPARE_EQUAL = 1;
    const COMPARE_NOT_EQUAL = 2;
    //same means ===
    const COMPARE_SAME = 3;
    const COMPARE_NOT_SAME = 4;

    const RETURNED_TRUE = 1;
    const RETURNED_FALSE = 0;

    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value)
    {
        if (is_array($value))
            return true;
        else return false;
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value)
    {
        if (is_array($value)) {
            //remove doubled values
            $array = array_unique($value, SORT_REGULAR);
            foreach ($array as $key => $val) {
                if ($val instanceof object) {
                    continue;
                } else unset($array[$key]);
            }
            return array_values($array);
        } else return array();
    }

    //!FNCountable
    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size()
    {
        return n(count($this->value()));
    }

    //!FNContainer
    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy()
    {
        return FNMutableSet::initWith($this->value());
    }

    /**
     * Returns an immutable copy of the current object
     * @return FNContainer
     */
    public function immutableCopy()
    {
        return FNSet::initWith($this->value());
    }

    //!Allocators
    /**
     * @method initWithArray
     * @param FNArray $array
     * @return FNSet
     */
    static function initWithArray(FNArray $array)
    {
        return static::initWith($array->value());
    }

    /**
     * Returns an instance of FNSet
     * @param null $first
     * @return FNSet
     */
    static function initWithList(/** @noinspection PhpUnusedParameterInspection */
        $first = NULL)
    {
        return static:: callStaticMethodWithArray('initWith', func_get_args());
    }

    //!Implementation
    /**
     * @method contains
     * @param \FNFoundation\object|object $object $object
     * @return boolean
     */
    function contains(object $object)
    {
        return in_array($object, $this->value());
    }

    /**
     * infinite arguments
     * @param \FNFoundation\object|object $object $object
     * @internal param \FNFoundation\object|object $object2
     * @return FNSet
     */
    function add(/** @noinspection PhpUnusedParameterInspection */
        object $object)
    {
        $value = $this->value();
        foreach (func_get_args() as $arg) {
            if (!$this->contains($arg) && $arg instanceof object) {
                $value[] = $arg;
            }
        }
        return $this->returnObjectWith($value);
    }

    /**
     * @method remove
     * @param \FNFoundation\object|object $object $object
     * @return FNSet
     */
    function remove(object $object)
    {
        $temp = $this->value();
        foreach ($temp as $key => $value) {
            if ($value === $object) {
                unset($temp[$key]);
                break;
            }
        }
        return $this->returnObjectWith($temp);
    }

    /**
     * @method removeSet
     * @param FNSet $set
     * @return FNSet
     */
    function removeSet(FNSet $set)
    {
        $temp = $this->value();
        foreach ($set->value() as $value) {
            foreach ($temp as $key => $object) {
                if ($value === $object) {
                    unset($temp[$key]);
                    break;
                }
            }
        }
        return $this->returnObjectWith($temp);
    }

    /**
     * @method mergeWithSet
     * @param FNSet $set
     * @return FNSet
     */
    function mergeWithSet(FNSet $set)
    {
        return $this->returnObjectWith(array_merge($this->value(), $set->value()));
    }

    /**
     * @static compare
     * @param mixed $value1
     * @param mixed $value2
     * @param int $mode
     * @return boolean
     */
    static private function compare($value1, $value2, $mode)
    {
        switch ($mode) {
            case FNSet::COMPARE_EQUAL:
                if ($value1 instanceof FNContainer && $value2 instanceof FNContainer) {
                    return $value1->isEqualTo($value2);
                } elseif ($value1 instanceof FNContainer || $value2 instanceof FNContainer)
                    return false; else return $value1 == $value2;
                break;
            case FNSet::COMPARE_NOT_EQUAL:
                return !static::compare($value1, $value2, FNSet::COMPARE_EQUAL);
                break;
            case FNSet::COMPARE_SAME:
                return $value1 === $value2;
                break;
            case FNSet::COMPARE_NOT_SAME:
                return $value1 !== $value2;
                break;
            default:
                return static::compare($value1, $value2, FNSet::COMPARE_EQUAL);
        }
    }

    /**
     * @method arrayWithAll
     * @return FNArray
     */
    function arrayWithAll()
    {
        return FNArray::initWith($this->value());
    }

    /**
     * @method arrayWithInstancesOf
     * @param FNString $FNci
     * @return FNArray;
     */
    function arrayWithInstancesOf(FNString $FNci)
    {
        $temp = array();
        foreach ($this->value() as $object) {
            $string = $FNci->value();
            if ($object instanceof $string) {
                $temp[] = $object;
            } else {
                $class = explode('\\', get_class($object));
                $class = $class[count($class) - 1];
                if ($class == $string)
                    $temp[] = $object;
            }
        }
        return FNArray::initWith($temp);
    }

    /**
     * @method compareWithInstancesOf
     * @param FNString $FNci
     * @return FNSet
     */
    function setWithInstancesOf(FNString $FNci)
    {
        return static::returnObjectWith($this->arrayWithInstancesOf($FNci)->value());
    }

    /**
     * @method arrayWithMethodReturned
     * @param FNString $method
     * @param FNArray $arguments
     * @param mixed $value
     * @param int $mode
     * @return FNArray
     */
    function arrayWithMethodReturned(FNString $method, FNArray $arguments, $value, $mode = FNSet::COMPARE_EQUAL)
    {
        $temp = array();
        $method = $method->value();
        foreach ($this->value() as $object) {
            if (static::compare(call_user_func_array(array($object, $method->value()), $arguments->value()), $value, $mode))
                $temp[] = $object;
        }
        return FNArray::initWith($temp);
    }

    /**
     * @method compareWithMethodReturned
     * @param FNString $method
     * @param FNArray $arguments
     * @param mixed $value
     * @param int $mode
     * @return FNSet
     */
    function setWithMethodReturned(FNString $method, FNArray $arguments, $value, $mode = FNSet::COMPARE_EQUAL)
    {
        return static::returnObjectWith($this->arrayWithMethodReturned($method, $arguments, $value, $mode)->value());
    }

    /**
     * @method arrayWithMethod
     * @param FNString $method
     * @param FNArray $arguments
     * @param int $mode
     * @return FNArray
     */
    function arrayWithMethod(FNString $method, FNArray $arguments, $mode = FNSet::RETURNED_TRUE)
    {
        $temp = array();
        $method = $method->value();
        foreach ($this->value() as $object) {
            $bool = call_user_func_array(array($object, $method->value()), $arguments->value());
            if (!$mode)
                $bool = !$bool;
            if ($bool)
                $temp[] = $object;
        }
        return FNArray::initWith($temp);
    }

    /**
     * @method compareWithMethod
     * @param FNString $method
     * @param FNArray $arguments
     * @param int $mode
     * @return FNSet
     */
    function setWithMethod(FNString $method, FNArray $arguments, $mode = FNSet::RETURNED_TRUE)
    {
        return static::returnObjectWith($this->arrayWithMethod($method, $arguments, $mode)->value());
    }

}

class FNMutableSet extends FNSet implements FNMutableContainer
{
    use FNDefaultMutableContainer;
}


?>
						