<?PHP
//
//!FNStep
//!FNDictionary.php
//
//!Created by Valentin Knabel on 26.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;
class FNDictionary extends FNContainer implements \Iterator, \ArrayAccess, FNCountable {
    private $position;
    private $tempKeys;
    
    /**
     * Returns an instance for FNDictionary using a list of parameters
     * @param FNString $key1
     * @param FNInitializable $value1
     * @param FNString $key2
     * @param FNInitializable $value2
     * @param ...
     */
    static function initWithList(FNString $key1, FNInitializable $value1,FNString $key2 = NULL, FNInitializable $value2 = NULL /* infinite arguments */) {
    	$tempArr = array();
    	$key = '';
    	for($i = 0;$i < func_num_args();$i++) {
    		if($i % 2 == 1) { //odd
    			$key = func_get_arg($i);
    		} else { //even
    			$tempArr[$key] = func_get_arg($i);
    		}
    	}
    	return static::initWith($tempArr);
    }
    /**
     * Returns an instance of FNDictionary using FNArray $key and FNArray $value
     * @param FNArray $keys
     * @param FNArray $values
     */
    static function initWithArray(FNArray $keys, FNArray $values) {
    	return static::initWith(array_combine($keys, $values));
    }
    
    static function initWithSet(FNSet $keys, FNSet $values) {
    	return static::initWithArray($keys->arrayWithInstancesOf(FNString::initWith('FNString')),$values->arrayWithInstancesOf(FNString::initWith('FNInitializable')));
    }
    
    public function __construct($value = NULL) {
    	parent::__construct($value);
    	$this->position = 0;
    	$this->tempKeys = array_keys($this->value());
    }
    
    /**
     * Returns TRUE if the FNDictionary contains the value $value
     * @param FNInitializable $value
     * @return boolean
     */
    function contains(FNInitializable $value) {
    	$bool = false;
    	foreach($this->value() as $val) {
    		if($val == $value) {
    			$bool = true;
    			break;
    		}
    	}
    	return $bool;
    }
    
    public function add(FNString $key1, FNInitializable $value1,FNString $key2 = NULL, FNInitializable $value2 = NULL /* infinite arguments */) {
    	$value = $this->value();
    	$key = '';
    	for($i = 0;$i < func_num_args();$i++) {
    		if($i % 2 == 0) { //even
    			$key = func_get_arg($i)->value();
    		} else { //odd
    			$value[$key] = func_get_arg($i);
    		}
    	}
    	
    	return $this->returnObjectWith($value);
    }
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::value()
     */
    public function value() {
    	return $this->_value;
    }
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::isValidValue($value)
     */
    static function isValidValue($value) {
    	return is_array($value) || is_null($value);
    }
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::convertValue($value)
     */
    static function convertValue($value) {
    	if(is_array($value)) {
    		$helpArr = array();
    		foreach($value as $key => $val) {
    			if($val instanceof FNInitializable) {
    				$helpArr[$key] = $val;
    			}
    		}
    		return $helpArr;
    	}
    	elseif(is_null($value))
    		return array();
    	else return array();
    }
    
    //@MODIFIED - no isMutable
    
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::mutableCopy()
     */
    function mutableCopy() {
    	return FNMutableDictionary::initWith($this->value());
    }
    /**
     *(non-PHPdoc)
     * @see FNScript\FNFoundation.FNContainer::immutableCopy()
     */
    function immutableCopy() {
    	return FNDictionary::initWith($this->value());
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
    	return $this->value[$this->tempKeys[$this->position]];
    }
    /**
    *(non-PHPdoc)
    * @see Iterator::key()
    */
    public function key() {
    	return $this->tempKeys[$this->position];
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
    	$this->tempKeys = array_keys($this->value());
    }
    /**
    *(non-PHPdoc)
    * @see Iterator::valid()
    */
    public function valid() {
    	return isset($this->tempKeys[$this->position]) && isset($this->value[$this->tempKeys[$this->position]]);
    }
##ArrayAccess
    /**
    *(non-PHPdoc)
    * @see ArrayAccess::offsetExists()
    */
    function offsetExists($offset) {
    	if(!($offset instanceof FNString))
    		$offset = FNString::initWith($offset);
    	return $this->keyExists($offset);
    }
    /**
    *(non-PHPdoc)
    * @see ArrayAccess::offsetGet()
    */
    function offsetGet($offset) {
    	if(!($offset instanceof FNString))
    		$offset = FNString::initWith($offset);
    	return $this->valueForKey($offset);
    }
    /**
    *(non-PHPdoc)
    * @see ArrayAccess::offsetSet()
    */
    function offsetSet($offset, $value) {
    	if(!($offset instanceof FNString))
    		$offset = FNString::initWith($offset);
    	return $this->setValueForKey($offset, $value);
    }
    /**
     *(non-PHPdoc)
     * @see ArrayAccess::offsetUnset()
     */
    function offsetUnset($offset) {
    	if(!($offset instanceof FNString))
    		$offset = FNString::initWith($offset);
    	return $this->unsetValueForKey($offset);
    }
    /**
     * 
     * Enter description here ...
     * @param FNString $key
     * @param FNInitializable $value
     * @return FNDictionary
     */
    function setValueForKey(FNString $key,FNInitializable $value) {
    	$array = $this->value();
    	$array[$key->value()] = $value;
    	return $this->returnObjectWith($array);
    }
    /**
     * 
     * @param FNString $key
     * @return FNInitializable
     */
	function valueForKey(FNString $key) {
    	$array = $this->value();
    	if(isset($array[$key->value()])) return $array[$key->value()];
    }
    /**
     * 
     * Enter description here ...
     * @param FNString $key
     * @return FNDictionary
     */
    function unsetValueForKey(FNString $key) {//@MODIFIED V not v
    	$array = $this->value();
    	unset($array[$key->value()]);
    	return $this->returnObjectWith($array);
    }
    /**
     * 
     * Enter description here ...
     * @param FNString $key
     * @return boolean
     */
    function keyExists(FNString $key) {
    	$array = $this->value();
    	return isset($array[$key->value()]);
    }
}
class FNMutableDictionary extends FNDictionary implements FNMutable {} //@MODIFIED

?>  				