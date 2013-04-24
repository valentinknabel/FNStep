<?PHP
//
//!FNStep
//!FNObject.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

namespace FNFoundation;

interface FNMutable {}

interface Object {
	/**
	 * This method is declared as protected to disallow the use of the new-operator outside of this class and its subclasses.
	 */
	//protected function __construct();
	
	/**
	 * Implement unresolvedMethod instead
	 * @arg string $function
	 * @arg array $arguments
	 * @return mixed
	 */
	//public function __call($function, array $arguments);
	
	/**
	 * Implement this method instead of __call.
	 * @arg FNString $function
	 * @arg array $arguments
	 * @return mixed
	 */
	public function unresolvedMethod(FNString $function, array $arguments);
	
	/**
	 * Implement unresolvedStaticMethod instead
	 * @arg string $function
	 * @arg array $arguments
	 * @return mixed
	 */
	//public static function __callStatic($function, array $arguments);
	
	/**
	 * Implement this method instead of __callStatic.
	 * @arg FNString $function
	 * @arg array $arguments
	 * @return mixed
	 */
	public static function unresolvedStaticMethod(FNString $function, array $arguments);
	
	/**
	 * Implement unresolvedProperty instead.
	 * @arg string $property
	 * @return mixed
	 */
	//public function __get($property);
	
	/**
	 * Implement this method instead of __get. This method makes it possible to call methods without arguments without using the brackets.
	 * @arg FNString $property
	 * @return mixed
	 */
	public function unresolvedProperty(FNString $property);
	
	/**
	 * Implement setUnresolvedProperty intead.
	 * @arg string $property
	 * @arg mixed $value
	 * @return void
	 */
	//public function __set($property, $value);
	
	/**
	 * Implement this method instead of __set. This method makes it possible to call methods with one argument without using the brakes if they start with set followed by a tall character.
	 * @arg FNString $property
	 * @arg mixed $value
	 * @return void
	 */
	public function setUnresolvedProperty(FNString $property, $value);
	
	/**
	 * Returns a new instance or NULL
	 * @return Object|NULL
	 */
	public static function init();
	
	/**
	 * Returns the parent's class name.
	 * @return string
	 */
	public static function super();
	
	/**
	 * Returns the current class name.
	 * @return string
	 */
	public static function cls();
	
	/**
	 * A (non) static function. Returns if the receiver responds to a method.
	 * @return boolean
	 */
	public function respondsToMethod($method);
	
	/**
	 * Returns if the current class responds to a method.
	 * @return boolean
	 */
	public static function respondsToStaticMethod($method);
	
	/**
	 * A (non) static function. Calls $method and returns it.
	 * @arg string|object $method
	 * @args mixed $list = NULL
	 * @return mixed
	 */
	public function callMethod($method, $list = NULL /*infinite arguments*/);
	
	/**
	 * A (non) static function. Calls $method and returns it.
	 * @arg string|object $method
	 * @args array $array
	 * @return mixed
	 */
	public function callMethodWithArray($method, array $array);
	
	/**
	 * Calls $method and returns it.
	 * @arg string|object $method
	 * @args mixed $list = NULL
	 * @return mixed
	 */
	public static function callStaticMethod($method, $list = NULL /*infinite arguments*/);
	
	/**
	 * Calls $method and returns it.
	 * @arg string|object $method
	 * @args array $array
	 * @return mixed
	 */
	public static function callStaticMethodWithArray($method, array $array);
	
	/**
	 * Returns if the current object is kind of $type
	 * @arg string|object $type
	 * @return boolean
	 */
	public function isKindOf($type);
	
	/**
	 * Returns if the current object is a member of $type
	 * @arg string|object $class
	 * @return boolean
	 */
	public function isMemberOf($class);
	
	/**
	 * Returns if the given object is mutable.
	 * @return boolean
	 */
	public function isMutable();
	
	/**
	 * Returns the description of the current object.
	 * @return FNString
	 */
	public function description();
	
	/**
	 * Returns the description of the current object.
	 * @return string
	 */
	public function __toString();
}

trait FNDefaultObject {
	//!additions
	/**
	 * This method is declared as protected to disallow the use of the new-operator outside of this class and its subclasses.
	 */
	protected function __construct() {}
	
	/**
	 * Implement unresolvedMethod instead
	 * @arg string $function
	 * @arg array $arguments
	 * @return mixed
	 */
	final public function __call($function, array $arguments) {
		return $this-> unresolvedMethod(s($function), $arguments);
	}
	
	/**
	 * Implement this method instead of __call.
	 * @arg FNString $function
	 * @arg array $arguments
	 * @return mixed
	 */
	public function unresolvedMethod(FNString $function, array $arguments) {
		throw new FNUnresolvedMethod($function);
	}
	
	/**
	 * Implement unresolvedStaticMethod instead
	 * @arg string $function
	 * @arg array $arguments
	 * @return mixed
	 */
	final public static function __callStatic($function, array $arguments) {
		return static:: unresolvedStaticMethod(s($function), $arguments);
	}
	
	/**
	 * Implement this method instead of __callStatic.
	 * @arg FNString $function
	 * @arg array $arguments
	 * @return mixed
	 */
	public static function unresolvedStaticMethod(FNString $function, array $arguments) {
		throw new FNUnresolvedStaticMethod($function);
	}
	
	/**
	 * Implement unresolvedProperty instead.
	 * @arg string $property
	 * @return mixed
	 */
	final public function __get($property) {
		return $this-> unresolvedProperty(s($property));
	}
	
	/**
	 * Implement this method instead of __get. This method makes it possible to call methods without arguments without using the brackets.
	 * @arg FNString $property
	 * @return mixed
	 */
	public function unresolvedProperty(FNString $property) {
		if($this-> respondsToMethod($property)) {
			return $this-> callMethod($property);
		} else throw new FNUnresolvedProperty($property);
	}
	
	/**
	 * Implement setUnresolvedProperty intead.
	 * @arg string $property
	 * @arg mixed $value
	 * @return void
	 */
	final public function __set($property, $value) {
		return $this-> setUnresolvedProperty(s($property), $value);
	}
	
	/**
	 * Implement this method instead of __set. This method makes it possible to call methods with one argument without using the brakes if they start with set followed by a tall character.
	 * @arg FNString $property
	 * @arg mixed $value
	 * @return void
	 */
	public function setUnresolvedProperty(FNString $property, $value) {
		$setter = s('set')->appendString($property-> firstCharacterToUpperCase());
		if($this-> respondsToMethod($setter)) {
			return $this-> callMethod($setter, $value); 
		} else throw new FNSetUnresolvedProperty($property);
	}
	
	//!object
	/**
	 * Returns a new instance or NULL
	 * @return Object|NULL
	 */
	public static function init() {
		return new static();
	}
	
	/**
	 * Returns the parent's class name.
	 * @return string
	 */
	public static function super() {
		return parent:: cls();
	}
	
	/**
	 * Returns the current class name.
	 * @return string
	 */
	public static function cls() {
		return get_called_class();
	}
	
	/**
	 * A (non) static function. Returns if the receiver responds to a method.
	 * @return boolean
	 */
	public function respondsToMethod($method) {
		return method_exists(isset($this)?$this:static::cls(), cstring($method));
	}
	
	/**
	 * Returns if the current class responds to a method.
	 * @return boolean
	 */
	public static function respondsToStaticMethod($method) {
		return method_exists(static::cls(), cstring($method));
	}
	
	/**
	 * A (non) static function. Calls $method and returns it.
	 * @arg string|object $method
	 * @args mixed $list = NULL
	 * @return mixed
	 */
	public function callMethod($method, $list = NULL /*infinite arguments*/) {
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), func_get_args());
	}
	
	/**
	 * A (non) static function. Calls $method and returns it.
	 * @arg string|object $method
	 * @args array $array
	 * @return mixed
	 */
	public function callMethodWithArray($method, array $array) {
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), carray($array));
	}
	
	/**
	 * Calls $method and returns it.
	 * @arg string|object $method
	 * @args mixed $list = NULL
	 * @return mixed
	 */
	public static function callStaticMethod($method, $list = NULL /*infinite arguments*/) {
		return call_user_func_array(array(static::cls(), cstring($method)), func_get_args());
	}
	
	/**
	 * Calls $method and returns it.
	 * @arg string|object $method
	 * @args array $array
	 * @return mixed
	 */
	public static function callStaticMethodWithArray($method, array $array) {
		return call_user_func_array(array(static::cls(), cstring($method)), carray($array));
	}
	
	/**
	 * Returns if the current object is kind of $type
	 * @arg string|object $type
	 * @return boolean
	 */
	public function isKindOf($type) {
		return $this instanceof $type;
	}
	
	/**
	 * Returns if the current object is a member of $type
	 * @arg string|object $class
	 * @return boolean
	 */
	public function isMemberOf($class) {
		return $this::cls() == cstring($class);
	}
	
	/**
	 * Returns if the given object is mutable.
	 * @return boolean
	 */
	public function isMutable() {
		return $this instanceof FNMutable;
	}
	
	/**
	 * Returns the description of the current object.
	 * @return FNString
	 */
	final public function description() {
		return s($this->__toString());
	}
	
	/**
	 * Returns the description of the current object.
	 * @return string
	 */
	public function __toString() {
		return '<'.$this::cls().'>';
	}
}

class FNObject implements Object {
	use FNDefaultObject;
}
	
?>
						