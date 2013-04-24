<?PHP
//
//!FNStep
//!functions.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//


use FNFoundation\FNString;
use FNFoundation\FNArray;
use FNFoundation\FNTodoException;

//!––––––––––––––––––––––––––––––––
//!constants

define('NULL_TYPE', gettype(NULL));
define('BOOLEAN_TYPE', gettype(TRUE));
define('INTEGER_TYPE', gettype(0));
define('FLOAT_TYPE', gettype(0.0));
define('STRING_TYPE', gettype(''));
define('ARRAY_TYPE', gettype(array()));
define('RESOURCE_TYPE', 'resource');
define('OBJECT_TYPE', 'object');

//!––––––––––––––––––––––––––––––––
//!functions

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
		    	return $value;
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
	return carraya(func_get_args());
}

/**
 * Returns an array.
 * @arg array
 * @return array
 */
function carraya($value = NULL) {
	return array_values($value);
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
	
?>
						