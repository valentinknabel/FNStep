<?PHP
//
//!FNStep
//!FNContainer.php
//
//!Created by Valentin Knabel on 26.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
 namespace FNFoundation;
 
 abstract class FNContainer extends FNObject {
     protected $_value;
     
     /**
      * @abstract @static isValidValue
      * @param mixed $value
      * @return boolean
      */
     static function isValidValue($value) { //@MODIFIED - not abstract(warning)
     	throw new FNUnimplementedMethod();
     }
     
     /**
      * @abstract @static convertValue
      * @param mixed $value
      * @return mixed
      */
     static function convertValue($value) { //@MODIFIED - not abstract(warning)
     	throw new FNUnimplementedMethod();
     }
     
     /**
      * @abstract isMutable
      * @return boolean
      */
     public function isMutable() {//@MODIFIED - not abstract
     	return $this instanceof FNMutable;
     }
     
     /**
      * @abstract mutableCopy
      * @return FNContainer
      */
     abstract public function mutableCopy();
     /**
      * @return FNContainer
      */
     abstract public function immutableCopy();
     
     /**
      * @method __construct
      * @param mixed $value
      */
     public function __construct($value = NULL) {
     	if(static::isValidValue($value)) {
     		$this->_value = static::convertValue($value);
     	}
     }
     /**
      * @static initWith
      * @param $value
      * @return FNContainer; NULL on failure
      */
     static function initWith($value) {
     	if(static::isValidValue($value)) {
     		return new static($value);
     	} else return NULL;
     }
     /**
      * @method __get
      * @param string $prop
      * @return mixed
      */
     function __get($prop) {
     	if($prop === 'value')
     		return $this->_value;
     	else return parent::__get($prop);
     }
     /**
      * @method value
      * @return mixed
      */
     function value() {
     	return $this->_value;
     }
     /**
      * @method returnObjectWith
      * @param mixed $value
      * @return FNContainer
      * 		if the FNContainer isMutable, it's value will be set;
      * 		else a new FNContainer will be returned
      */
     protected function returnObjectWith($value) {
 		if($this->isMutable()) {
     		$this->_value = static::convertValue($value);
     		return $this; 
     	} else return static::initWith($value);
     }
     /**
      * @method isEqualTo
      * @param FNContainer $container
      * @param boolean $strict
      * @return boolean
      */
     function isEqualTo(FNContainer $container, $strict = FALSE) {
     	if($strict) {
     		if($this->value() === $container->value()) return true;
     		else return false;
     	} else {
     		if ($this->value() == $container->value()) {
     			return true;
     		}
     		else return false;
     	}
     }
     function isEmpty() {
     	$tmp = $this->value();
     	if(empty($tmp)) return true;
     	else return false;
     }
     function valueIsSet() {
     	$tmp = $this->value();
     	if(isset($tmp)) return true;
     	else return false;
     }
 }
 
?>
						