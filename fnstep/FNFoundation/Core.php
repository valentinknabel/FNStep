<?PHP
//
//!FNStep
//!Core.php
//
//!Created by Valentin Knabel on 28.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;
use \Exception;
use \Countable;

define('NULL_TYPE', gettype(NULL));
define('BOOLEAN_TYPE', gettype(TRUE));
define('INTEGER_TYPE', gettype(0));
define('FLOAT_TYPE', gettype(0.0));
define('STRING_TYPE', gettype(''));
define('ARRAY_TYPE', gettype(array()));
define('RESOURCE_TYPE', 'resource');
define('OBJECT_TYPE', 'object');

/**
 * Throws an exception to signalize what's up next.
 * @return void
 */
function FNTodo($message = '') {
	throw new FNTodoException($message);
}

/**
 * Puts the given value into a container.
 * @arg mixed $value
 * @return FNContainer
 */
function con($value) {
	return FNContainer::initWith($value);
}

/**
 * Returns a number.
 * @return FNNumber
 */
function n($value) {
	return FNNumber::initWith(cnumber($value));
}

/**
 * Returns a number.
 * @arg mixed $value
 * @return number
 */
function cnumber($value) {
	switch(gettype($value)) {
	    case NULL_TYPE:
	    	return 0;
	    case BOOLEAN_TYPE:
	    	return $value ? 1 : 0;
	    case INTEGER_TYPE:
	    	return $value;
	    case FLOAT_TYPE:
	    	return $value;
	    case STRING_TYPE:
	    	return is_numeric($value) ? (floatval($value) == intval($value) ? intval($value) : floatval($value)) : 0;
	    case ARRAY_TYPE:
	        return count($value);
	    case RESOURCE_TYPE:
	        return intval($value);
	    case OBJECT_TYPE:
	    	if($value instanceof Countable)
	    		return count($value);
	    	if($value instanceof FNNumber)
	        	return $value-> value();
	    	if($value instanceof FNIdentifiable)
	        	return cnumber($value-> numericIdentifier());
	        if($value instanceof Object)
	        	return cnumber($value-> __toString());
	        if(function_exists(array($value, '__toString')))
	        	return cnumber($value-> __toString());
	        return 1;
	    default:
	        throw FNVersionException('Update FNFoundation: a new PHP-type has been added');
	}
}

/**
 * Returns an integer.
 * @arg mixed $value
 * @return int
 */
function cint($value) {
	return intval(cnumber($value));
}

/**
 * Returns a string.
 * @arg mixed $value = NULL
 * @return FNString
 */
function s($value = '') {
	return FNString::initWith(call_user_func_array('cstring', func_get_args()));
}

/**
 * Returns a mutable string.
 * @arg mixed $value = NULL
 * @return FNMutableString
 */
function ms($value = '') {
	return FNMutableString::initWith(call_user_func_array('cstring', func_get_args()));
}

/**
 * Returns a string.
 * @arg mixed $value = NULL
 * @return string
 */
function cstring($value = '') {
	if(func_num_args() == 1) {
		switch(gettype($value)) {
		    case NULL_TYPE:
		    	return '';
		    case BOOLEAN_TYPE:
		    	return $value ? 'true' : 'false';
		    case INTEGER_TYPE:
		    	return strval($value);
		    case FLOAT_TYPE:
		    	return strval($value);
		    case STRING_TYPE:
		    	return sprintf("%f", $value);
		    case ARRAY_TYPE:
		        $string = '';
		        foreach($value as $needle) {
		            $string .= cstring($needle);
		        }
		        return $string;
		    case RESOURCE_TYPE:
		        return strval($value);
		    case OBJECT_TYPE:
		    	if($value instanceof FNString)
		        	return $value-> value();
		    	if($value instanceof FNIdentifiable)
		        	return cnum($value-> identifier());
		        if($value instanceof Object)
		        	return $value-> __toString();
		        if(function_exists(array($value, '__toString')))
		        	return $value-> __toString();
		        return serialize($value);
		    default:
		        throw FNVersionException('Update FNFoundation: a new PHP-type has been added');
		}
	} else {
		$string = '';
		foreach(func_get_args() as $arg) {
			$string .= cstring($arg);
		}
		return $string;
	}
}

/**
 * Returns an array.
 * @arg mixed $value = NULL
 * @return FNArray
 */
function a($value = NULL) {
	return FNArray::initWith(call_user_func_array('carray', func_get_args()));
}

/**
 * Returns a mutable array.
 * @arg mixed $value = NULL
 * @return FNMutableArray
 */
function ma($value = NULL) {
	return FNMutableArray::initWith(call_user_func_array('carray', func_get_args()));
}

/**
 * Returns an array.
 * @arg array $value = NULL
 * @return array
 */
function carray($value = NULL) {
	FNTodo(__FUNCTION__);
}

/**
 * Returns a dictionary.
 * @arg mixed $key = NULL
 * @arg mixed $value = NULL
 * @return FNDictionary
 */
function d($key = NULL, $value = NULL) {
	return FNDictionary::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a mutable dictionary.
 * @arg mixed $key = NULL
 * @arg mixed $value = NULL
 * @return FNMutableDictionary
 */
function md($key = NULL, $value = NULL) {
	return FNMutableDictionary::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a dictionary.
 * @arg mixed $key = NULL
 * @arg mixed $value = NULL
 * @return FNDictionary
 */
function cdict($key = NULL, $value = NULL) {
	FNTodo(__FUNCTION__);
}

/**
 * Returns a set.
 * @arg mixed $value = NULL
 * @return FNSet
 */
function set($value = NULL) {
	return FNSet::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a mutable set.
 * @arg mixed $value = NULL
 * @return FNMutableSet
 */
function mset($value = NULL) {
	return FNMutableSet::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a dictionary.
 * @arg mixed $value = NULL
 * @return FNDictionary
 */
function cset($value = NULL) {
	FNTodo(__FUNCTION__);
}

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
		return $this-> unresolvedMethod(s($function), $arguments);
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
		return static:: alloc();
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
		return function_exists(array(isset($this)?$this:static::cls(), cstring($method)));
	}
	
	/**
	 * Returns if the current class responds to a method.
	 * @return boolean
	 */
	public static function respondsToStaticMethod($method) {
		return function_exists(array(static::cls(), cstring($method)));
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
	public function description() {
		return s('<',$this::cls(),'>');
	}
	
	/**
	 * Returns the description of the current object.
	 * @return string
	 */
	final public function __toString() {
		return cstring($this-> description());
	}
}

class FNObject implements Object {
	use FNDefaultObject;
}

class FNException extends Exception implements Object {
	use FNDefaultObject;
	
	/**
	 * Caches the trace.
	 * @type FNArray
	 */
	private $trace;
	
	/**
	 * This constructor is not declared protected: just use new
	 * @arg string|Object $message = ""
	 * @arg int|FNCountable $code = 0
	 * @arg Exception $previous = NULL
	 */
	public function __construct($message = "", $code = 0, Exception $previous = NULL) {
		parent::__construct(cstring($message), cint($code), $previous);
	}
	
	/**
	 * Returns the description of the current object.
	 * @return FNString
	 */
	public function description() {
		if($this->previous())
			return s(static::cls(),': #'.$this->code(),' \'',$this->message(),'\' {',$this->previous(),'}');
		else return s(static::cls(),': #',$this->code(),' \'',$this->message(),'\'');
	}
	
	//!Implementation
	/**
	 * Returns the message.
	 * @return FNString
	 */
	public function message() {
		return s($this->getMessage());
	}
	
	/**
	 * Returns the error code.
	 * @return FNNumber
	 */
	public function code() {
		return n($this->getCode());
	}
	
	/**
	 * Returns the previous exception
	 * @return Exception
	 */
	public function previous() {
		return $this->getPrevious();
	}
	
	/**
	 * Returns the file name.
	 * @return FNString
	 */
	public function fileName() {
		return s($this->getFile());
	}
	
	/**
	 * Returns the line.
	 * @return FNNumber
	 */
	public function line() {
		return n($this->getLine());
	}
	
	/**
	 * Returns the trace array.
	 * @return FNArray
	 */
	public function trace() {
		if(!isset($this->trace)) 
			$this-> trace = a($this-> getTrace());
		return $this-> trace;
	}
	
	/**
	 * Returns the description of the trace. This method may be faster than calling ->trace()->description()
	 * @return FNString
	 */
	public function traceDescription() {
		return s($this-> getTraceAsString());
	}
}

class FNVersionException extends FNException {}
class FNTodoException extends FNException {}

class FNTypeException extends FNException {}

class FNImplementationException extends FNException {}
class FNUnimplementedFunction extends FNImplementationException {}
class FNUnimplementedMethod extends FNUnimplementedFunction {}

class FNResolvabilityException extends FNException {}
class FNUnresolvedFunction extends FNResolvabilityException {}
class FNUnresolvedMethod extends FNUnresolvedFunction {}
class FNUnresolvedProperty extends FNResolvabilityException {}
class FNSetUnresolvedProperty extends FNUnresolvedProperty {}


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
	 * @return FNString
	 */
	public function description() {
		return s($id);
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

abstract class FNContainer extends FNObject implements FNComparable, FNCountable, FNValidatable {
	use FNDefaultCountable;
	
	/**
	 * The contained value
	 * @type mixed
	 */
	private $_value;
	
	protected function __construct($value) {
		$this->_value = static::convertValue($value);
	}
	
	/**
	 * Returns the description of the current object.
	 * @return FNString
	 */
	public function description() {
		return s($this-> value());
	}
	
	//!Implementation
	/**
	 * Changes the own value if mutable, else returns a new object.
	 * @arg mixed $value
	 * @return FNContainer
	 */
	protected function returnObjectWith($value) {
		if($this-> isMutable()) {
			$this-> _value = static:: convertValue($value);
		} else return static:: initWith($value);
	}
	
	/**
	 * Returns the represented value
	 * @return mixed
	 */
	public function value() {
		return $this-> _value;
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
	 * @return boolean
	 */
	public function isEqual($value) {
		if(static::isValidValue($value)) {
			$value = static::convertValue($value);
			if($this-> _value instanceof FNComparable) {
				return $this-> _value-> isEqual($value);
			} else return $this-> _value == $value;
		} else return FALSE;
	}
	
	//!FNValidatable
	/**
	 * Returns an instance.
	 * @return FNValidatable|NULL
	 */
	public static function initWith($value) {
		if(static::cls() != FNContainer::cls()) {
			if(static::isValidValue($value))
				return new static($value);
			else return NULL;
		} else {
			switch(gettype($value)) {
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
				    $keyed = TRUE; $indexed = TRUE;
				    foreach(array_keys($value) as $id) {
				    	if($keyed) {
				    		$keyed = is_string($id);
				    	} 
				    	if($indexed) {
				    		$indexed = is_int($id);
				    	} else break;
				    }
				    if($indexed) {
				    	return FNArray::initWith($value);
				    } else if($keyed) {
				    	return FNDictionary::initWith($value);
				    } else return FNSet::initWith(array_values($value));
				case RESOURCE_TYPE:
				    return FNResource::initWith($value);
				case OBJECT_TYPE:
				    if($value instanceof FNContainer)
				    	return $value;
				    if($value instanceof FNIdentifiable)
				    	return FNContainer::initWith($value);
				    if($value instanceof FNObject)
				    	return FNString::initWithObject($value);
				    if(function_exists(array($value, '__toString')))
				    	return FNString::initWith($value-> __toString());
				    return FNObjectContainer::initWith($value);
				default:
				    throw FNVersionException('Update FNFoundation: a new PHP-type has been added');
			}
		}
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

FNTodo('FNNil');
FNTodo('FNBoolean');
FNTodo('FNNumber');
FNTodo('FNString');
FNTodo('FNArrayAccess');
FNTodo('FNEnumeratable');
FNTodo('FNEnumerator');
FNTodo('FNKeyedEnumerator');
FNTodo('FNSet');
FNTodo('FNArray');
FNTodo('FNDictionary');
FNTodo('FNResource');

?>
						