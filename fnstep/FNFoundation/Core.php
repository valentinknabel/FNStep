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
use \Iterator;
use \ArrayAccess;

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
 * @param $value
 * @throws
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
	    	if($value instanceof Traversable) {
		    	$count = 0;
		    	foreach($value as $needle) {
			    	$count++;
		    	}
		    	return $count;
	    	}
	    	if($value instanceof FNNumber)
	        	return $value-> value();
	    	if($value instanceof FNIdentifiable)
	        	return cnumber($value-> numericIdentifier());
	        if($value instanceof Object)
	        	return cnumber($value-> __toString());
	        if(method_exists($value, '__toString'))
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
	return FNString:: initWith(func_get_args());
}

/**
 * Returns a mutable string.
 * @arg mixed $value = NULL
 * @return FNMutableString
 */
function ms($value = '') {
	return FNString:: initWith(func_get_args());
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
		        	if($needle == $value) throw new FNArgumentException('Recursive arrays can\'t be printed');
		            $string .= cstring($needle);
		        }
		        return $string;
		    case RESOURCE_TYPE:
		        return strval($value);
		    case OBJECT_TYPE:
		    	if($value instanceof Traversable) {
			    	$string = '';
			    	foreach($value as $needle) {
				    	if($needle == $value) throw new FNArgumentException('Recursive arrays can\'t be printed');
				    	$string .= cstring($needle);
			    	}
			    	return $string;
		    	}
		    	if($value instanceof FNString)
		        	return $value-> value();
		    	if($value instanceof FNIdentifiable)
		        	return cnum($value-> identifier());
		        if($value instanceof Object)
		        	return $value-> __toString();
		        if(method_exists($value, '__toString'))
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
	echo get_called_class().":: $function";
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
	echo get_called_class().":: $function";
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
	echo get_called_class()."-> $property";
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
	echo get_called_class()."-> $property";
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
		echo get_called_class().":: $method";
		return method_exists(isset($this)?$this:static::cls(), cstring($method));
	}
	
	/**
	 * Returns if the current class responds to a method.
	 * @return boolean
	 */
	public static function respondsToStaticMethod($method) {
	echo get_called_class().":: $method";
		return method_exists(static::cls(), cstring($method));
	}
	
	/**
	 * A (non) static function. Calls $method and returns it.
	 * @arg string|object $method
	 * @args mixed $list = NULL
	 * @return mixed
	 */
	public function callMethod($method, $list = NULL /*infinite arguments*/) {
	echo get_called_class().":: $method";
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), func_get_args());
	}
	
	/**
	 * A (non) static function. Calls $method and returns it.
	 * @arg string|object $method
	 * @args array $array
	 * @return mixed
	 */
	public function callMethodWithArray($method, array $array) {
	echo get_called_class().":: $method";
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), carray($array));
	}
	
	/**
	 * Calls $method and returns it.
	 * @arg string|object $method
	 * @args mixed $list = NULL
	 * @return mixed
	 */
	public static function callStaticMethod($method, $list = NULL /*infinite arguments*/) {
	echo get_called_class().":: $method";
		return call_user_func_array(array(static::cls(), cstring($method)), func_get_args());
	}
	
	/**
	 * Calls $method and returns it.
	 * @arg string|object $method
	 * @args array $array
	 * @return mixed
	 */
	public static function callStaticMethodWithArray($method, array $array) {
	echo get_called_class().":: $method";
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
		return $this-> description()-> value();
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
			return s(static::cls(),': #',$this->code(),' \'',$this->message(),'\' {',$this->previous(),'}');
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
		return s($this->_id);
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

interface FNMutableContainer extends FNMutable {
	/**
	 * Sets the value of the container.
	 * @arg mixed $value
	 * @return void
	 */
	public function setValue($value);
}

trait FNDefaultMutableContainer {
	/**
	 * Sets the value of the container.
	 * @arg mixed $value
	 * @return void
	 */
	public function setValue($value) {
		$this-> returnObjectWith($value);
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
		return s($this-> value);
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
				    if(method_exists($value, '__toString'))
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

class FNNil extends FNContainer  {
	
	//!FNObject
	/**
	 * Implement this method instead of __call.
	 * @arg FNString $function
	 * @arg array $arguments
	 * @return mixed
	 */
	public function unresolvedMethod(FNString $function, array $arguments) {
		if(DEBUG) {
			throw new FNUnresolvedMethod($function);
		} else return NULL;
	}
	
	/**
	 * Implement this method instead of __callStatic.
	 * @arg FNString $function
	 * @arg array $arguments
	 * @return mixed
	 */
	public static function unresolvedStaticMethod(FNString $function, array $arguments) {
		if(DEBUG) {
			throw new FNUnresolvedStaticsMethod($function);
		} else return NULL;
	}
	
	//!FNValidatable
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value) {
		return TRUE;
	}
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value) {
		return NULL;
	}
	
	/**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
	    return $this;
    }
    
     /**
      * Returns an immutable copy of the current object
      * @return FNContainer
      */
    public function immutableCopy() {
	    return $this;
    }
    
    //!FNCountable
	/**
	 * Returns the size.
	 * @return FNNumber
	 */
	public function size() {
		return n(0);
	}
	
}

class FNBoolean extends FNContainer {
	/**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
	    return FNBoolean:: initWith($this-> value());
    }
    
     /**
      * Returns an immutable copy of the current object
      * @return FNContainer
      */
    public function immutableCopy() {
	    return FNMutableBoolean:: initWith($this-> value());
    }
	
	/**
	 * Returns an FNBoolean containg TRUE
	 * @return FNBoolean
	 */
	public static function yes() {
		return static:: initWith(TRUE);
	}
	
	/**
	 * Returns an FNBoolean containg FALSE
	 * @return FNBoolean
	 */
	public static function no() {
		return static:: initWith(FALSE);
	}
	
	
	//!FNValidatable
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value) {
		return TRUE;
	}
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value) {
		return $value ? TRUE : FALSE;
	}
	
	//!FNCountable
	/**
	 * Returns the size.
	 * @return FNNumber
	 */
	public function size() {
		return n(1);
	}
	
}

class FNMutableBoolean extends FNBoolean implements FNMutableContainer {
	use FNDefaultMutableContainer;
}

class FNNumber extends FNContainer implements FNCountable {
	
	const ROUND_HALF_UP = PHP_ROUND_HALF_UP;
    const ROUND_HALF_DOWN = PHP_ROUND_HALF_DOWN;
    const ROUND_HALF_EVEN = PHP_ROUND_HALF_EVEN;
    const ROUND_HALF_ODD = PHP_ROUND_HALF_ODD; 
	
	/**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
	    return FNNumber:: initWith($this-> value());
    }
    
     /**
      * Returns an immutable copy of the current object
      * @return FNContainer
      */
    public function immutableCopy() {
	    return FNMuatbleNumber:: initWith($this-> value());
    }
	
	//!FNCountable
	/**
	 * Returns the size.
	 * @return FNNumber
	 */
	public function size() {
		return n(cint($this->value));
	}
	
	//!allocators
	/**	@static pi
     * 	@return FNNumber 3.14159265358979323846
     * 	@link http://cn.php.net/manual/en/math.constants.php
     */
    static function pi() {
    	return static::initWith(pi());
    }
    
    /**	@static e
     * 	@return FNNumer 2.7182818284590452354
     * 	@link http://cn.php.net/manual/en/math.constants.php
     */
    static function e() {
    	return static::initWith(M_E);
    }
    
    /**
     * @static initRandom
     * @return a random FNNumber
     * @link http://de2.php.net/manual/en/function.rand.php
     */
    static function initRandom() {
    	return static::initWith(rand());
    }
    /**
     * @static initRandomBetween
     * @param FNNumber $minimum
     * @param FNNumber $maximum
     * @return $minimum <= random FNNumber <= $maximum 
     * @link http://de2.php.net/manual/en/function.rand.php
     */
    static function initRandomBetween(FNNumber $minimum,FNNumber $maximum) {
    	return static::initWith(rand($minimum->value, $maximum->value));
    }
    /**
     * Returns a FNNumber
     * @param FNString $string
     * @return FNNumber
     */
    static function initWithString(FNString $string) {
    	return static::initWith($string->value());
    }
    /**
     * @static zero
     * @return FNNumber 0
     */
    static function zero() {
    	return static::initWith(0); 
    }
    
    static function initIntegerWith($value, $round = FNNumber::ROUND_HALF_UP) {
    	return static::initWith($value)->round(FNNumber::zero(),$round);
    }
    
    //!FNValidatable
    /**
     * @static isValidValue
     * @param mixed $value
     * @return boolean
     * 		true: string, int, float
     */
    static function isValidValue($value) {
    	/* '1.0' ist auch numerisch! */
    	if($value instanceof FNContainer) return true;
    	if(is_numeric($value)) return true;
    	else return false;
    }
    
    /**
     * @static convertValue
     * @param mixed $value
     * @return numeric
     */
    static function convertValue($value) {
    	return cnumber($value);
    }
    
    //!implementation
    ##Trigonometry
    //conversions
    //Converts from degrees to radian
    /**
     * @method radian
     * @return radian FNNumber from degree
     * @link http://de2.php.net/manual/en/function.deg2rad.php
     */
    function radian() {
    	return $this->returnObjectWith(deg2rad($this->value));
    }
    /**
     * @method degree
     * @return degree FNNumber from radian
     * @link http://de2.php.net/manual/en/function.rad2deg.php
     */
    function degree() {
    	return $this->returnObjectWith(rad2deg($this->value));
    }
    //triangles
    /**
     * @method hypotenuse
     * @param FNNumber $side
     * @return hypotenuse FNNumber
     * @link http://de2.php.net/manual/en/function.hypot.php
     * 		Calculates the length of the hypotenuse of a right-angle triangle
     */
    function hypotenuse(FNNumber $side) {
    	return $this->returnObjectWith(hypot($this->value, $side->value));
    }
    /**
     * @method sine
     * @return sine FNNumber
     * @link http://de2.php.net/manual/en/function.sin.php
     */
    //sin,cos,tan
    function sine() {
    	return $this->returnObjectWith(sin($this->value));
    }
    /**
     * @method cosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.cos.php
     */
    function cosine() {
    	return $this->returnObjectWith(cos($this->value));
    }
    /**
     * @method tangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.tan.php
     */
    function tangent() {
    	return $this->returnObjectWith(tan($this->value));
    }
    //hyperbolic
    /**
     * @method hyperbolicSine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.sinh.php
     */
    function hyperbolicSine() {
    	return $this->returnObjectWith(sinh($this->value));
    }
    /**
     * @method hyperbolicCosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.cosh.php
     */
    function hyperbolicCosine() {
    	return $this->returnObjectWith(cosh($this->value));
    }
    /**
     * @method hyperbolicTangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.tanh.php
     */
    function hyperbolicTangent() {
    	return $this->returnObjectWith(tanh($this->value));
    }
    //arc
    /**
     * @method arcSine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.asin.php
     */
    function arcSine() {
    	return $this->returnObjectWith(asin($this->value));
    }
    /**
     * @method arcCosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.acos.php
     */
    function arcCosine() {
    	return $this->returnObjectWith(acos($this->value));
    }
    /**
     * @method arcTangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.atan.php
     */
    function arcTangent() {
    	return $this->returnObjectWith(atan($this->value));
    }
    /**
     * @method arcDevidedTangent
     * @param FNNumber $divisor
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.atan2.php
     */
    function arcDevidedTangent(FNNumber $divisor) {
    	return $this->returnObjectWith(atan2($this->value, $divisor->value));
    }
    //arc hyperbolic
    /**
     * @method arcHyperbolicSine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.asinh.php
     */
    function arcHyperbolicSine() {
    	return $this->returnObjectWith(asinh($this->value));
    }
    /**
     * @method arcHyperbolicCosine
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.acosh.php
     */
    function arcHyperbolicCosine() {
    	return $this->returnObjectWith(acosh($this->value));
    }
    /**
     * @method arcHyperBolicTangent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.atanh.php
     */
    function arcHyperbolicTangent() {
    	return $this->returnObjectWith(atanh($this->value));
    }	
##round
    /**
     * @method ceil
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.ceil.php
     */
    function ceil() {
    	return $this->returnObjectWith((int)ceil($this->value));
    }
    /**
     * @method floor
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.floor.php
     */
    function floor() {
    	return $this->returnObjectWith((int)floor($this->value));
    }
    /**
     * @method round
     * @param FNNumber $precision
     * @param int $mode
     * 		use only FNNumber constants!!!
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.round.php
     */
    function round(FNNumber $precision = NULL, $mode = FNNumber::ROUND_HALF_UP) {
    	if(!$precision) $precision = FNNumber::zero();
    	return $this->returnObjectWith(round($this->value,$precision->value(),$mode));
    }
##string numbers
    /**
     * @method binaryString
     * @return FNString
     * @link http://de2.php.net/manual/en/function.decbin.php
     */
    function binaryString() {
    	return FNString::initWith(decbin($this->value));
    }
    /**
     * @method hexadecimalString
     * @return FNString
     * @link http://de2.php.net/manual/en/function.dechex.php
     */
    function hexadecimalString() {
    	return FNString::initWith(dechex($this->value));
    }
    /**
     * @method octalString
     * @return FNString
     * @link http://de2.php.net/manual/en/function.deoct.php
     */
    function octalString() {
    	return FNString::initWith(decoct($this->value));
    }
    /**
     * @method decimalString
     * @return FNString
     */
    function decimalString() {
    	return FNString::initWith((string)$this->value);
    }
##calculations
    /**
     * @method absolute
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.abs.php
     */
    function absolute() {
    	return $this->returnObjectWith(abs($this->value));
    }
    /**
     * @method sum
     * @param FNNumber $addend
     * @return FNNumber
     */
    function sum(FNNumber $addend) {
    	return $this->returnObjectWith($this->value+$addend->value);
    }
    /**
     * @method difference
     * @param FNNumber $subtrahend
     * @return FNNumber
     */
    function difference(FNNumber $subtrahend) {
    	return $this->returnObjectWith($this->value-$subtrahend->value);
    }
    /**
     * @method product
     * @param FNNumber $factor
     * @return FNNumber
     */
    function product(FNNumber $factor) {
    	return $this->returnObjectWith($this->value*$factor->value);
    }
    /**
     * @method quotient
     * @param FNNumber $divisor
     * @return FNNumber or false 
     */
    function quotient(FNNumber $divisor) {
    	if($divisor->value == 0) return false;
    	else return $this->returnObjectWith($this->value/$divisor->value);
    }
    /**
     * @method power
     * @param FNNumber $exponent
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.power.php
     */
    
    function absoluteDifference(FNNumber $subtrahend) {//@MODIFIED - D of difference tall
    	return $this->returnObjectWith(abs($this->value() - $subtrahend->value()));
    }
    
    //@MODIFIED - 
    /**
     * aadtler
     * Valentin Knabel
     * 21.09.12
     *
     * @return FNNumber
     */
    public function increase() {
    	return $this->returnObjectWith($this-> sum(n(1)));
    }
    
    /**
     * aadtler
     * Valentin Knabel
     * 21.09.12
     *
     * @return FNNumber
     */
    public function decrease() {
    	return $this->returnObjectWith($this-> difference(n(1)));
    }
    //@MODEND
    
    function power(FNNumber $exponent) {
    	return $this->returnObjectWith(pow($this->value, $exponent->value));
    }
    /**
     * @method squareRoot
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.sqrt.php
     */
    function squareRoot() {
    	return $this->returnObjectWith(sqrt($this->value));
    }
    /**
     * @method exponentiate10
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.exp10.php
     */
    function exponentiate10() {
    	return $this->returnObjectWith(pow($this->value,10));
    }
    /**
     * @method exponentiateE
     * @return FNNumber
     * FNNumber::e() is the base
     * @link http://de2.php.net/manual/en/function.exp.php
     */
    function exponentiateE() {
    	return $this->returnObjectWith(exp($this->value));
    }
    /**
     * @method exponentiateEMinus1
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.expm1.php
     */
    function exponentiateEMinus1() {
    	return $this->returnObjectWith(expm1($this->value));
    }
    /**
     * @method logarithm10
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log10.php
     */
    function logarithm10() {
    	return $this->returnObjectWith(log10($this->value));
    }
    /**
     * @method logarithm2
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log.php
     */
    function logarithm2() {
    	return $this->returnObjectWith(log($this->value,2));
    }
    /**
     * @method logarithmEPlus1
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log1p.php
     */
    function logarithmEPlus1() {
    	return $this->returnObjectWith(log1p($this->value));
    }
    /**
     * @method logarithmE
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log.php
     */
    function logarithmE() {
    	return $this->returnObjectWith(log($this->value));
    }
    /**
     * @method logarithmX
     * @param FNNumber $base
     * @return FNNumber
     * @link http://de2.php.net/manual/en/function.log.php
     */
    function logarithmX(FNNumber $base) {
    	return $this->returnObjectWith(log($this->value,$base->value));
    }	
##conditions
    /**
     * @method modulo
     * @param FNNumber $divisor
     * @return rest FNNumber
     * @example FNNumber::initWith(10)->modulo(FNNumber::initWith(6)) is FNNumber 4
     * @link http://de2.php.net/manual/en/function.mod.php
     */
    function modulo(FNNumber $divisor) {
    	return $this->returnObjectWith(fmod($this->value,$divisor->value));
    }
    /**
     * @method isFinite
     * @return boolean
     * 		true if $this is finite
     * @example FNNumber::e() is finite
     * @link http://de2.php.net/manual/en/function.is-finite.php
     */
    function isFinite() {
    	return is_finite($this->value);
    }
    /**
     * @method isInfinite
     * @return boolean
     * 		true if $this is infinite 
     * @example FNNumber::initWith(1)->devision(FNNumber::zero()) is infinite
     * @link http://de2.php.net/manual/en/function.is-infinite.php
     */
    function isInfinite() {
    	return is_infinite($this->value);
    }
    /**
     * @method isNotANumber
     * @return boolean
     * 		true if $this is Not-a-Number
     * @example ::cosine(FNNumber::initWith(1.1)) == NaN
     * @link http://de2.php.net/manual/en/function.is-nan.php
     */
    function isNotANumber() {
    	return is_nan($this->value);
    }
    /**
     * @method isLess
     * @param FNNumber $number
     * @return boolean
     * 		true if $this is less
     */
    function isLess(FNNumber $number) {
    	return $this->value < $number->value;
    }
    /**
     * @method isLessOrEqual
     * @param FNNumber $number
     * @return boolean
     * 		true if $number is greater
     */
    function isLessOrEqual(FNNumber $number) {
    	return $this->value <= $number->value;
    }
    /**
     * @method isGreater
     * @param FNNumber $number
     * @return boolean
     * 		true if $this is greater
     */
    function isGreater(FNNumber $number) {
    	return $this->value > $number->value;
    }
    /**
     * @method isGreaterOrEqual
     * @param FNNumber $number
     * @return boolean
     * 		true if $number is less
     */
    function isGreaterOrEqual(FNNumber $number) {
    	return $this->value >= $number->value;
    }
    
}

class FNMutableNumber extends FNNumber implements FNMutableContainer {
	use FNDefaultMutableContainer;
}

class FNString extends FNContainer {
	const CASE_LOWER = MB_CASE_LOWER;
    const CASE_UPPER = MB_CASE_UPPER;
    const CASE_TITLE = MB_CASE_TITLE;
    
    const UCS_4 = 'UCS-4';const UCS_4BE = 'UCS-4BE';const UCS_4LE = 'UCS-4LE';const UCS_2 = 'UCS-2';const UCS_2BE = 'UCS-2BE';const UCS_2LE = 'UCS-2LE';
    const UTF_32 = 'UTF-32';const UTF_32BE = 'UTF-32BE';const UTF_32LE = 'UTF-32LE';const UTF_16 = 'UTF-16';const UTF_16BE = 'UTF-16BE';const UTF_16LE = 'UTF-16LE';
    const UTF_7 = 'UTF-7';const UTF7_IMAP = 'UTF7-IMAP';const UTF_8 = 'UTF-8';
    const ASCII = 'ASCII';const EUC_JP = 'EUC-JP';const SJIS = 'SJIS';const eucJP_win = 'eucJP-win';const SJIS_win = 'SJIS-win';
    const ISO_2022_JP = 'ISO-2022-JP';const ISO_2022_JP_MS = 'ISO-2022-JP-MS';const CP932 = 'CP932';const CP51932 = 'CP51932';
    
    const MacJapanese = 'MacJapanese';
    const SJIS_DOCOMO = 'SJIS-DOCOMO';
    const SJIS_KDDI = 'SJIS-KDDI';
    const SJIS_SOFTBANK = 'SJIS-SOFTBANK';
    const UTF_8_DOCOMO = 'UTF-8-DOCOMO';
    const UTF_8_Mobile_KDDI_A = 'UTF-8-Mobile#KDDI-A';
    const UTF_8_KDDI = 'UTF-8-KDDI';
    const UTF_8_SOFTBANK = 'UTF-8-SOFTBANK';
    const ISO_2022_JP_KDDI = 'ISO-2022-JP-KDDI';
    
    const JIS = 'JIS';	const JIS_ms = 'JIS-ms';const CP50220 = 'CP50220';const CP50220raw = 'CP50220raw';const CP50221 = 'CP50221';const CP50222 = 'CP50222';
    const ISO_8859_1 = 'ISO-8859-1';const ISO_8859_2 = 'ISO-8859-2';const ISO_8859_3 = 'ISO-8859-3';const ISO_8859_4 = 'ISO-8859-4';const ISO_8859_5 = 'ISO-8859-5';
    const ISO_8859_6 = 'ISO-8859-6';const ISO_8859_7 = 'ISO-8859-7';const ISO_8859_8 = 'ISO-8859-8';const ISO_8859_9 = 'ISO-8859-9';const ISO_8859_10 = 'ISO-8859-10';
    const ISO_8859_13 = 'ISO-8859-13';const ISO_8859_14 = 'ISO-8859-14';const ISO_8859_15 = 'ISO-8859-15';const byte2be = 'byte2be';
    const byte2le = 'byte2le';const byte4be = 'byte4be';const byte4le = 'byte4le';const BASE64 = 'BASE64';const HTML_ENTITIES = 'HTML-ENTITIES';
    const _7bit = '7bit';const _8bit = '8bit';const EUC_CN = 'EUC-CN';const CP936 = 'CP936';
    /*const GB18030 = ''; PHP5.4*/
    const HZ = 'HZ';const EUC_TW = 'EUC-TW';const CP950 = 'CP950';const BIG_5 = 'BIG-5';const EUC_KR = 'EUC-KR';const UHC = 'UHC';const ISO_2022_KR = 'ISO-2022-KR';
    const Windows_1251 = 'Windows-1251';const Windows_1252 = 'Windows-1252';const CP866 = 'CP866';const KOI8_R = 'KOI8-R';
    
    const STANDARD_ENCODING = FNString::UTF_8;
	
	//!FNValidatable
	/**
	 * Returns if the value is valid.
	 * @return boolean
	 */
	public static function isValidValue($value) {
		if(is_string($value) || is_numeric($value) || $value == NULL || $value instanceof FNContainer || is_array($value))
    		return true;
    	return false;
	}
	
	/**
	 * Converts the given value for inner class use.
	 * @return mixed
	 */
	public static function convertValue($value) {
        return cstring($value);
	}
	
	//!FNCountable
	/**
	 * Returns the size.
	 * @return FNNumber
	 */
	public function size() {
		return mb_strlen($this-> value, FNString:: STANDARD_ENCODING);
	}

	//!FNContainer
    /**
     * Returns a mutable copy of the current object
     * @return FNContainer,FNMutable
     */
    public function mutableCopy() {
	    return FNMutableString:: initWith($this-> value);
    }
    
    /**
      * Returns an immutable copy of the current object
      * @return FNContainer
      */
    public function immutableCopy() {
	    return FNString:: initWith($this-> value);
    }
	
	//!Allocators
	/**
     * @static initWithRandom
     * @param FNNumber $length = 6
     * @param bool $characters = FALSE
     * @return FNString
     */
    static function initWithRandomString(FNNumber $length = NULL, FNString $characters = NULL) {
    	if($length != NULL) $length = $length->value();
    	else $length = 6;
    	if($characters == NULL) $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	else $characters = $characters->value();
    	$string = '';
    	for($p = 0; $p < $length; $p++) {
    		$string .= $characters[mt_rand(0, strlen($characters)-1)];
    	}
    	return static::initWith($string);
    }
    static function initWithArray(FNArray $array) {
    	$value = '';
    	foreach($array as $string) {
    		$value .= static::convertValue($string);
    	}
    	return static::initWith($value);
    }
    static function initWithList($arg1, $arg2 = '') {
    	$value = '';
    	foreach(func_get_args() as $string) {
    		$value .= static::convertValue($string);
    	}
    	return static::initWith($value);
    }

	//!Implementation
	/**
     * @method valueWithEncoding
     * @param int $encoding
     * @return string
     */
    function valueWithEncoding($encoding = FNString::UTF_8) {
    	if(function_exists('mb_convert_encoding'))
    		return mb_convert_encoding($this->value(),$encoding);
    	else return $this->value;
    }
	
}

FNTodo('FNString');
FNTodo('FNArrayAccess');
FNTodo('FNEnumerable');
FNTodo('FNEnumerator');
FNTodo('FNKeyedEnumerator');
FNTodo('FNSet');
FNTodo('FNArray');
FNTodo('FNDictionary');
FNTodo('FNResource');
FNTodo('FNNil ergänzen');
?>
						