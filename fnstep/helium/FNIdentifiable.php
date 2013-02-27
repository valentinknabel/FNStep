<?PHP
//
//!FNStep
//!FNIdentifiable.php
//
//!Created by Valentin Knabel on 27.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;

interface FNIdentifiable {
	function id();
	function identifier();
	function numericIdentifier();
	function commonIdentifier();
}

trait FNDefaultIdentifiable implements FNIdentifiable {
	abstract function id();
	
	function identifier() {
		if($this instanceof FNIdentifier) {
			return $this;
		} else return FNIdentifier::initWithId($this-> id());
	}
	
	function numericIdentifier() {
		if($this instanceof FNNumericIdentifier) {
			return $this;
		} else return FNNumericIdentifier::initWithId($this-> id());
	}
	function commonIdentifier() {
		if($this instanceof FNCommonIdentifier) {
			return $this;
		} else return FNCommonIdentifier::initWithId($this-> id());
	}
}
	
?>
						