<?PHP
//
//!FNStep
//!FNArray.php
//
//!Created by Valentin Knabel on 26.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;
class FNArray extends FNContainer implements \Iterator, \ArrayAccess, FNCountable {
	private $position;
	
	/**
	 * 
	 * @param object $object1
	 * @param object $object2
	 * @return FNArray
	 */
	static function initWithList(object $object1, object $object2 = NULL /* infinite arguments */) {
		return static::initWith(func_get_args());
	}
	
    public function __construct($value = NULL) {
    	parent::__construct($value);
    	$this->position = 0;
    }
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::isValidValue($value)
     */
    static function isValidValue($value) {
    	return is_array($value);
    }
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::convertValue($value)
     */
    static function convertValue($value) {
    	if(is_array($value))
    		return array_values($value);
    	else return array();
    }
    
    //@MODIFIED - isMutable won't be overwritten
    
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::mutableCopy()
     */
    function mutableCopy() {
    	return FNMutableArray::initWith($this->value);
    }
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::immutableCopy()
     */
    function immutableCopy() {
    	return FNArray::initWith($this->value());
    }
##Countable
    /**
     *(non-PHPdoc)
     * @see FNCountable::count()
     */
    function count() {
    	return FNNumber::initWith(count($this->value()));
    }
##Iterator
    /**
     *(non-PHPdoc)
     * @see Iterator::current()
     */
    public function current() {
    	return $this->value[$this->position];
    }
    /**
     *(non-PHPdoc)
     * @see Iterator::key()
     */
    public function key() {
    	return $this->position;
    }
    /**
     *(non-PHPdoc)
     * @see Iterator::next()
     */
    public function next() {
    	++$this->position;
    }
    /**
     *(non-PHPdoc)
     * @see Iterator::rewind()
     */
    public function rewind() {
    	$this->position = 0;
    }
    /**
     *(non-PHPdoc)
     * @see Iterator::valid()
     */
    public function valid() {
    	return isset($this->value[$this->position]);
    }
##ArrayAccess
    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetExists()
     */
    function offsetExists($offset) {
    	if(!($offset instanceof FNNumber))
    		$offset = FNNumber::initWith($offset);
    	if($offset instanceof FNNumber)
    		return isset($this->value[$offset->value()]);
    	else return false;
    }
    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetGet()
     */
    function offsetGet($offset) {
    	if(!($offset instanceof FNNumber))
    		$offset = FNNumber::initWith($offset);
    	if($offset instanceof FNContainer)
    		return $this->value[$offset->value()];
    	else return;
    }
    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetSet()
     */
    function offsetSet($offset, $value) {
    	if(!($offset instanceof FNNumber))
    		$offset = FNNumber::initWith($offset);
    	if($offset instanceof FNNumber && $value instanceof object) {
    		$temp = $this->value[$offset->value()];
    		$temp[$offset->value()] = $value;
    		return $this->returnObjectWith($temp);
    	} else return false;
    }
    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetUnset()
     */
    function offsetUnset($offset) {
    	if(!($offset instanceof FNNumber))
    		$offset = FNNumber::initWith($offset);
    	if($offset instanceof FNContainer) {
    		$temp = $this->value[$offset->value()];
    		unset($temp[$offset->value()]);
    		return $this->returnObjectWith($temp);
    	}
    	else return false;
    }
    /**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @return boolean
     */
    function indexExists(FNNumber $index) {
    	return isset($this->value[$index->value()]);
    }
    /**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @param object $value
     * @return FNSArray
     */
    function setvalueForIndex(FNNumber $index,object $value) {
    	$array = $this->value();
    	$array[$index->value()] = $value;
    	return $this->returnObjectWith($array);
    }
    /**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @return FNArray
     */
    function valueForIndex(FNNumber $index) {
    	return $this->value[$index->value()];
    }
    /**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @return FNArray
     */
    function unsetIndex(FNNumber $index) {
    	$array = $this->value();
    	unset($array[$index->value()]);
    	return $this->returnObjectWith($array);
    }
##ArrayMethods
    /**
     * adds objects to the end of the array
     * infinite arguments
     * @param object $object
     * @param object $object2
     * @return FNArray
     */
    function add(object $object, object $object2 = NULL /* infinite arguments */) {
    	$value = $this->value();
    	foreach(func_get_args() as $arg) {
    		if($arg instanceof object) $value[] = $arg;
    	}
    	return $this->returnObjectWith($value);
    }
    /**
     * @method chunk
     * @param FNNumber $size
     * @return FNArray
     */
    function chunk(FNNumber $size) {
    	return $this->returnObjectWith(array_chunk($this->value(), $size->value()));
    }
    /**
     * @method combine
     * @param FNArray $values
     * @return FNDictionary
     */
    function combine(FNArray $values) {
    	return FNDictionary::initWith(array_combine($this->value(), $values->value()));
    }
    /**
     * @method containsObject
     * @param object $object
     * @return bool
     */
    function containsObject(object $object) {
    	return in_array($object, $this->value());
    }
    /**
     * @method difference
     * @param FNArray $array, infinite
     * @return FNSet
     */
    function difference(FNArray $array, FNArray $array1 = NULL /* FNArray infinite*/) {
    	$param_array = array();
    	foreach(func_get_args() as $value) {
    		if($value instanceof FNArray) {
    			$param_array[] = $value->value();
    		}
    	}
    	return FNSet::initWith(call_user_func_array('array_diff', $param_array));
    }
    /**
     * @method differenceAssociation
     * @param FNArray $array, infinite
     * @return FNSet
     */
    function differenceAssociation(FNArray $array, FNArray $array1 = NULL /* FNArray infinite*/) {
    	$param_array = array();
    	foreach(func_get_args() as $value) {
    		if($value instanceof FNArray) {
    			$param_array[] = $value->value();
    		}
    	}
    	return FNSet::initWith(call_user_func_array('array_diff_assoc', $param_array));
    }
    /**
     * @method differenceAssociation
     * @param FNArray $array, infinite..... FNString $callback
     * @return FNSet
     */
    function differenceIndexAssociation(FNArray $array, FNArray $array1 = NULL /* FNArray infinite*/) {
    	$param_array = array();
    	foreach(func_get_args() as $value) {
    		if($value instanceof FNArray) {
    			$param_array[] = $value->value();
    		}
    	}
    	$func = func_get_arg(func_num_args()-1);
    	if($func instanceof FNString)
    		$func = $func->value();
    	$param_array[] = $func;
    	return FNSet::initWith(call_user_func_array('array_diff_uassoc', $param_array));
    }
    /**
     * @method filter
     * @param FNString $function
     * @return FNArray
     */
    function filter(FNString $function) {
    	if($function) $function = $function->value();
    	return $this->returnObjectWith(array_filter($this->value(),$function));
    }
    /**
     * 
     * @param FNArray $array
     * @param FNArray $array2
     * @return FNArray
     */
    function mergeRecusive(FNArray $array, FNArray $array2 = NULL /*infinite arguments*/) {
    	$args = array($this->value());
    	foreach(func_get_args() as $arg) {
    		if($arg instanceof FNArray)
    			$args[] = $arg;
    	}
    	return $this->returnObjectWith(call_user_func_array('array_merge_recursive', $args));
    }
    /**
     * 
     * @param FNArray $array
     * @param FNArray $array2
     * @return FNArray
     */
	function merge(FNArray $array, FNArray $array2 = NULL /*infinite arguments*/) {
    	$args = array($this->value());
    	foreach(func_get_args() as $arg) {
    		if($arg instanceof FNArray)
    			$args[] = $arg;
    	}
    	return $this->returnObjectWith(call_user_func_array('array_merge', $args));
    }
}
class FNMutableArray extends FNArray implements FNMutable {} //@MODIFIED - instead of overwriting isMutable, implementing FNMutable

?>