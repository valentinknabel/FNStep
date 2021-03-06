<?PHP
//
//!FNStep
//!FNIdentifier.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

use Countable;

/**
 * Class FNCountable
 * @package FNFoundation
 */
interface FNCountable extends Countable {
    /**
     * Implement size instead.
     * @return int
     */
    //public function count();

    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size();
}

/**
 * Class FNDefaultCountable
 * @package FNFoundation
 */
trait FNDefaultCountable {
    /**
     * Implement size instead.
     * @return int
     */
    final public function count() {
        return cint($this->size());
    }

    /**
     * Returns the size.
     * @return FNNumber
     */
    abstract public function size();
}

/**
 * Class FNValidatable
 * @package FNFoundation
 */
interface FNValidatable {
    /**
     * Returns an instance.
     * @param $value
     * @return FNValidatable
     */
    public static function initWith($value);

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value);

    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value);
}

/**
 * Class FNDefaultValidatable
 * @package FNFoundation
 */
trait FNDefaultValidatable {
    /**
     * Returns an instance.
     * @param $value
     * @return FNValidatable|NULL
     */
    public static function initWith($value) {
        if (static::isValidValue($value))
            return new static($value); else return NULL;
    }

    /**
     * Returns if the value is valid.
     * @param $value
     * @throws FNUnimplementedMethod
     * @return boolean
     */
    public static function isValidValue(/** @noinspection PhpUnusedParameterInspection */
        $value) {
        throw new FNUnimplementedMethod(__METHOD__);
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @throws FNUnimplementedMethod
     * @return mixed
     */
    public static function convertValue(/** @noinspection PhpUnusedParameterInspection */
        $value) {
        throw new FNUnimplementedMethod(__METHOD__);
    }
}

/**
 * Class FNIdentifiable
 * @package FNFoundation
 */
interface FNIdentifiable {
    /**
     * Returns the id.
     * @return FNString|FNNumber|string|int
     */
    public function id();

    /**
     * Returns an identifier.
     * @return FNIdentifier
     */
    public function identifier();

    /**
     * Returns a numeric identifier.
     * @return FNNumericIdentifier
     */
    public function numericIdentifier();

    /**
     * Returns a common identifier.
     * @return FNCommonIdentifier
     */
    public function commonIdentifier();

    /**
     * Returns a generic identifier.
     * @return FNGenericIdentifier
     */
    public function genericIdentifier();
}

/** @noinspection PhpInconsistentReturnPointsInspection */
trait FNDefaultIdentifiable {
    /**
     * Returns the id.
     * @return FNString|FNNumber
     */
    abstract public function id();

    /**
     * Returns an identifier.
     * @return FNIdentifier
     */
    public function identifier() {
        if ($this instanceof FNIdentifier) {
            return $this;
        }
        /** @var $this FNIdentifiable */
        return FNIdentifier::initWithId($this);
    }

    /**
     * Returns a numeric identifier.
     * @return FNNumericIdentifier
     */
    public function numericIdentifier() {
        if ($this instanceof FNNumericIdentifier) {
            return $this;
        }
        /** @noinspection PhpParamsInspection */
        return FNNumericIdentifier::initWithId($this);
    }

    /**
     * Returns a common identifier.
     * @return FNCommonIdentifier
     */
    public function commonIdentifier() {
        if ($this instanceof FNCommonIdentifier) {
            return $this;
        }
        /** @noinspection PhpParamsInspection */
        return FNCommonIdentifier::initWithId($this);
    }

    /**
     * Returns a generic identifier.
     * @return FNGenericIdentifier
     */
    public function genericIdentifier() {
        if ($this instanceof FNGenericIdentifier) {
            return $this;
        }
        /** @noinspection PhpParamsInspection */
        return FNGenericIdentifier::initWithId($this);
    }
}

/**
 * Class FNIdentifier
 * @package FNFoundation
 */
abstract class FNIdentifier extends FNObject implements FNIdentifiable, FNValidatable, FNComparable, FNCountable {
    use FNDefaultIdentifiable, FNDefaultValidatable, FNDefaultCountable;

    /**
     * Saves the id.
     * @type FNString|FNNumber
     */
    private $_id;

    /**
     * @param $id
     */
    protected function __construct($id) {
        $this->_id = static::convertValue($id);
    }

    /**
     * Returns the description of the current object.
     * @return string
     */
    public function __toString() {
        return $this->_id;
    }

    //!Implementation
    /**
     * If the called class is FNIdentifier this method will call FNGenericIdentifier
     * @param FNIdentifiable $id
     * @return FNIdentifier
     */
    public static function initWithId(FNIdentifiable $id) {
        return static::cls() == FNIdentifier::cls() ? FNGenericIdentifier::initWith($id) : FNIdentifier::initWith($id);
    }

    //!FNComparable
    /**
     * Returns if both objects/values are equal
     * @arg mixed $value
     * @param $value
     * @return boolean
     */
    public function isEqualTo($value) {
        if (is_object($value)) {
            if ($value instanceof FNIdentifiable) {
                try {
                    return $this->id()->isEqualTo(static::convertValue($value->id()));
                } catch (FNTypeException $exception) {
                    return FALSE;
                }
            } else return parent::isEqualTo($value);
        } else {
            return $this->isEqualTo(con($value));
        }
    }

    //!FNIdentifiable
    /**
     * Returns the id.
     * @return FNString|FNNumber
     */
    public function id() {
        return $this->_id;
    }

    //!FNCountable
    /**
     * Returns the size.
     * @return FNNumber
     */
    public function size() {
        return $this->id()->size();
    }

}

/**
 * Class FNGenericIdentifier
 * @package FNFoundation
 */
class FNGenericIdentifier extends FNIdentifier {
    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value) {
        return cstring($value);
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value) {
        return s($value);
    }
}

/**
 * Class FNNumericIdentifier
 * @package FNFoundation
 */
class FNNumericIdentifier extends FNIdentifier {
    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value) {
        return cint($value) == $value;
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value) {
        return n(cint($value));
    }
}

/**
 * Class FNCommonIdentifier
 * @package FNFoundation
 */
class FNCommonIdentifier extends FNIdentifier {
    //!FNValidatable
    /**
     * Returns if the value is valid.
     * @param $value
     * @return boolean
     */
    public static function isValidValue($value) {
        FNTodo('doesMatch');
        return cstring($value) != '' && s($value)->matches(s("/[a-z_][a-z0-9_]+/i"));
    }

    /**
     * Converts the given value for inner class use.
     * @param $value
     * @return mixed
     */
    public static function convertValue($value) {
        FNTodo('match (only one or none), matches (array)');
        return s($value)->matches(s("/[a-z_][a-z0-9_]+/i"));
    }
}


