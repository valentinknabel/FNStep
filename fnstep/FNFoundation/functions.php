<?PHP
//
//!FNStep
//!functions.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//

use FNFoundation\FNContainer;
use FNFoundation\Object;
use FNFoundation\FNIdentifiable;
use FNFoundation\FNString;
use FNFoundation\FNArray;
use FNFoundation\FNTodoException;
use FNFoundation\FNNumber;
use FNFoundation\FNSet;
use FNFoundation\FNMutableSet;
use FNFoundation\FNMutableString;
use FNFoundation\FNDictionary;
use FNFoundation\FNMutableDictionary;
use FNFoundation\FNVersionException;
use FNFoundation\FNMutableArray;
use FNFoundation\FNArgumentException;

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
 * @param string $message
 * @throws FNFoundation\FNTodoException
 * @return void
 */
function FNTodo($message = '') {
	throw new FNTodoException($message);
}

/**
 * Puts the given value into a container.
 * @arg mixed $value
 * @param $value
 * @return FNContainer
 */
function con($value) {
	return FNContainer::initWith($value);
}

/**
 * Returns a number.
 * @param $value
 * @return FNNumber
 */
function n($value) {
	return FNNumber::initWith(cnumber($value));
}

/**
 * Returns a number.
 * @arg mixed $value
 * @param $value
 * @throws FNFoundation\FNVersionException
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
                /** @noinspection PhpUnusedLocalVariableInspection */
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
                /** @noinspection PhpUndefinedMethodInspection */
                return cnumber($value-> __toString());
	        return 1;
	    default:
	        throw new FNVersionException('Update FNFoundation: a new PHP-type has been added');
	}
}

/**
 * Returns an integer.
 * @arg mixed $value
 * @param $value
 * @return int
 */
function cint($value) {
	return intval(cnumber($value));
}

/**
 * Returns a string.
 * @arg mixed $value = NULL
 * @param string $value
 * @return FNString
 */
function s(/** @noinspection PhpUnusedParameterInspection */
    $value = '') {
	return FNString:: initWith(func_get_args());
}

/**
 * Returns a mutable string.
 * @arg mixed $value = NULL
 * @param string $value
 * @return FNMutableString
 */
function ms(/** @noinspection PhpUnusedParameterInspection */
    $value = '') {
	return FNMutableString:: initWith(func_get_args());
}

/**
 * Returns a string.
 * @arg mixed $value = NULL
 * @param string $value
 * @throws FNFoundation\FNArgumentException
 * @throws FNFoundation\FNVersionException
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
                /** @noinspection PhpWrongForeachArgumentTypeInspection */
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
		        	return cnumber($value-> identifier());
		        if($value instanceof Object)
		        	return $value-> __toString();
		        if(method_exists($value, '__toString'))
                    /** @noinspection PhpUndefinedMethodInspection */
                    return $value-> __toString();
		        return serialize($value);
		    default:
		        throw new FNVersionException('Update FNFoundation: a new PHP-type has been added');
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
 * @param null $value
 * @return FNArray
 */
function a(/** @noinspection PhpUnusedParameterInspection */
    $value = NULL) {
	return FNArray::initWith(call_user_func_array('carray', func_get_args()));
}

/**
 * Returns a mutable array.
 * @arg mixed $value = NULL
 * @param null $value
 * @return FNMutableArray
 */
function ma(/** @noinspection PhpUnusedParameterInspection */
    $value = NULL) {
	return FNMutableArray::initWith(call_user_func_array('carray', func_get_args()));
}

/**
 * Returns an array.
 * @arg array $value = NULL
 * @param null $value
 * @return array
 */
function carray(/** @noinspection PhpUnusedParameterInspection */
    $value = NULL) {
	return carraya(func_get_args());
}

/**
 * Returns an array.
 * @arg array
 * @param null $value
 * @return array
 */
function carraya($value) {
	return array_values($value);
}

/**
 * Returns a dictionary.
 * @arg mixed $key = NULL
 * @arg mixed $value = NULL
 * @param null $key
 * @param null $value
 * @return FNDictionary
 */
function d(/** @noinspection PhpUnusedParameterInspection */
    $key = NULL, $value = NULL) {
	return FNDictionary::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a mutable dictionary.
 * @arg mixed $key = NULL
 * @arg mixed $value = NULL
 * @param null $key
 * @param null $value
 * @return FNMutableDictionary
 */
function md(/** @noinspection PhpUnusedParameterInspection */
    $key = NULL, $value = NULL) {
	return FNMutableDictionary::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a dictionary.
 * @arg mixed $key = NULL
 * @arg mixed $value = NULL
 * @param null $key
 * @param null $value
 * @return FNDictionary
 */
function cdict(/** @noinspection PhpUnusedParameterInspection */
    $key = NULL, $value = NULL) {
	FNTodo(__FUNCTION__);
}

/**
 * Returns a set.
 * @arg mixed $value = NULL
 * @param null $value
 * @return FNSet
 */
function set(/** @noinspection PhpUnusedParameterInspection */
    $value = NULL) {
	return FNSet::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a mutable set.
 * @arg mixed $value = NULL
 * @param null $value
 * @return FNMutableSet
 */
function mset(/** @noinspection PhpUnusedParameterInspection */
    $value = NULL) {
	return FNMutableSet::initWith(call_user_func_array('cdict', func_get_args()));
}

/**
 * Returns a dictionary.
 * @arg mixed $value = NULL
 * @param null $value
 * @return void FNDictionary
 */
function cset(/** @noinspection PhpUnusedParameterInspection */
    $value = NULL) {
	FNTodo(__FUNCTION__);
}

						