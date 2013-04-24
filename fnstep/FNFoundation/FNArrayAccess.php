<?PHP
//
//!FNStep
//!FNArrayAccess.php
//
//!Created by Valentin Knabel on 27.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;
use \ArrayAccess;

interface FNArrayAccess extends ArrayAccess {
	function idExists(FNIdentifiable $id);
	function unsetId(FNIdentifiable $id);
	function setValueForId(FNIdentifiable $id, object $value);
	function valueForId(FNIdentifiable $id);
}

trait FNDefaultArrayAccess {
	abstract function offsetExists($offset);
	abstract function offsetUnset($offset);
	abstract function offsetSet($offset, $value);
	abstract function offsetGet($offset);
	
	/**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @return boolean
     */
    function idExists(FNIdentifiable $index) {
    	return isset($this->value[$index->numericIdentifier()]);
    }
    /**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @param object $value
     * @return FNSArray
     */
    function setValueForId(FNIdentifiable $index,object $value) {
    	$array = $this->value();
    	$array[$index->numericIdentifier()] = $value;
    	return $this->returnObjectWith($array);
    }
    /**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @return FNArray
     */
    function valueForId(FNIdentifiable $index) {
    	return $this->value()[$index->numericIdentifier()];
    }
    /**
     * 
     * Enter description here ...
     * @param FNNumber $index
     * @return FNArray
     */
    function unsetId(FNIdentifiable $index) {
    	$array = $this->value();
    	unset($array[$index->numericIdentifier()]);
    	return $this->returnObjectWith($array);
    }
	
}

?>
