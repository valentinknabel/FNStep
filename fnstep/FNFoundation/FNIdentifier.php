<?PHP
//
//!FNStep
//!FNIdentifier.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;
use \Countable;

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

trait FNDefaultCountable {
	/**
	 * Implement size instead.
	 * @return int
	 */
	final public function count() {
		return cint($this-> size());
	}
	
	/**
	 * Returns the size.
	 * @return FNNumber
	 */
	abstract public function size();
}

interface FNComparable {
	/**
	 * Returns if both objects/values are equal
	 * @arg mixed $value
	 * @return boolean
	 */
	public function isEqual($value);
}

trait FNDefaultComparable {
	/**
	 * Returns if both objects/values are equal
	 * @arg mixed $value
	 * @return boolean
	 */
	public function isEqual($value) {
		if(!is_object($value)) return FALSE;
		if($value instanceof Object && $this instanceof Object) {
			return $value::cls() == $this::cls();
		} else return get_class($value) == get_class($this);
	}
}

interface FNValidatable {
	/**
	 * Returns an instance.
	 * @return FNValidatable
	 */
	public static function initWith($value);
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value);
	
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value);
}

trait FNDefaultValidatable {
	/**
	 * Returns an instance.
	 * @return FNValidatable|NULL
	 */
	public static function initWith($value) {
		if(static::isValidValue($value))
			return new static($value);
		else return NULL;
	}
	
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value) {
		throw FNUnimplementedMethod(__METHOD__);
	}
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value) {
		throw new FNUnimplementedMethod(__METHOD__);
	}
}

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
		if($this instanceof FNIdentifier) {
			return $this;
		} else return FNIdentifier::initWithId($this);
	}
	
	/**
	 * Returns a numeric identifier.
	 * @return FNNumericIdentifier
	 */
	public function numericIdentifier() {
		if($this instanceof FNNumericIdentifier) {
			return $this;
		} else return FNNumericIdentifier::initWithId($this);
	}
	
	/**
	 * Returns a common identifier.
	 * @return FNCommonIdentifier
	 */
	public function commonIdentifier() {
		if($this instanceof FNCommonIdentifier) {
			return $this;
		} else return FNCommonIdentifier::initWithId($this);
	}
	
	/**
	 * Returns a generic identifier.
	 * @return FNGenericIdentifier
	 */
	public function genericIdentifier() {
		if($this instanceof FNGenericIdentifier) {
			return $this;
		} else return FNGenericIdentifier::initWithId($this);
	}
}

abstract class FNIdentifier extends FNObject implements FNIdentifiable, FNValidatable, FNComparable, FNCountable {
	use FNDefaultIdentifiable, FNDefaultValidatable, FNDefaultCountable;
	
	/**
	 * Saves the id.
	 * @type FNString|FNNumber
	 */
	private $_id;
	
	protected function __construct($id) {
		$this-> _id = static::convertValue($id);
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
	 * @return FNIdentifier
	 */
	public static function initWithId(FNIdentifiable $id) {
		return static::cls() == FNIdentifier::cls() ? FNGenericIdentifier::initWith($id) : FNIdentifier::initWith($id);
	}
	
	//!FNComparable
	/**
	 * Returns if both objects/values are equal
	 * @arg mixed $value
	 * @return boolean
	 */
	public function isEqual($value) {
		if(is_object($value)) {
			if($value instanceof FNIdentifiable) {
				try {
					return $this-> id()-> isEqual(static::convertValue($value->id()));
				} catch(FNTypeException $exeption) {
					return FALSE;
				}
			}
		} else {
			return $this->isEqual(id($value));
		}
	}
	
	//!FNIdentifiable
	/**
	 * Returns the id.
	 * @return FNString|FNNumber
	 */
	public function id() {
		return $this-> _id;
	}
	
	//!FNCountable
	/**
	 * Returns the size.
	 * @return FNNumber
	 */
	public function size() {
		return $this-> id()-> size();
	}
	
}

class FNGenericIdentifier extends FNIdentifier {
	//!FNValidatable
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value) {
		return cstring($value);
	}
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value) {
		return s($value);
	}
}

class FNNumericIdentifier extends FNIdentifier {
	//!FNValidatable
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value) {
		return isN($value);
	}
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value) {
		return n($value);
	}
}

class FNCommonIdentifier extends FNIdentifier {
	//!FNValidatable
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value) {
		FNTodo('doesMatch');
		return cstring($value) != '' && s($value)-> doesMatch("/[a-z_][a-z0-9_]+/i");
	}
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value) {
		FNTodo('match (only one or none), matches (array)');
		return s($value)-> match(s("/[a-z_][a-z0-9_]+/i"));
	}
}

?>
