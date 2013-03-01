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
	function offsetExists($offset) {
		return $this-> idExists(FNIdentifier::initWith($offset));
	}
	
	function offsetUnset($offset) {
		return $this-> unsetId(FNIdentifier::initWith($offset));
	}
	
	function offsetSet($offset, $value) {
		return $this-> setValueForId(object($value) , FNIdentifier::initWith($offset));
	}
	
	function offsetGet($offset) {
		return $this-> valueForId(FNIdentifier::initWith($offset));
	}
	
	abstract function idExists(FNIdentifiable $id);
	abstract function unsetId(FNIdentifiable $id);
	abstract function setValueForId(FNIdentifiable $id, object $value);
	abstract function valueForId(FNIdentifiable $id);
	
}

?>
						