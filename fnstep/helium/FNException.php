<?PHP
//
//!FNStep
//!FNException.php
//
//!Created by Valentin Knabel on 26.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;
use \Exception;
use object;
use FNDefaultObjectImplementation;

class FNException extends Exception implements object {
	use FNDefaultObjectImplementation;
	
	public function __construct($message = "", $code = 0, Exception $previous = NULL) {
		parent::__construct(cstring($message), intval($code), $previous);
	}
	
	function message() {
		return s($this->getMessage());
	}
	
	function code() {
		return n($this->getCode());
	}
	
	function previous() {
		return $this->getPrevious();
	}
	
	function file() {
		return s($this->getFile());
	}
	
	function line() {
		return n($this->getLine());
	}
	
	function trace() {
		$ctr = $this->getTrace();
		$trace = array();
		for($i = 0; $i < count($ctr); $i++) {
			$trace[i] = array();
			foreach($ctr as $key => $value) {
				switch(gettype($value)) {
					case STRING:
						$trace[$i][$key] = s($value);
						break;
					case INTEGER:
						$trace[$i][$key] = n($value);
						break;
					default:
						throw new FNTypeException(gettype($value));
				}
			}
		}
		return a($trace);
	}
	
	function traceDescription() {
		return s($this->getTraceAsString());
	}
	
	function __toString() {
		if($this->previous())
			return static::cls().': #'.$this->code().' \''.$this->message().'\' {'.$this->previous().'}';
		else return static::cls().': #'.$this->code().' \''.$this->message().'\'';
	}
	
	function description() {
		return s($this->__toString());
	}
}

class FNTypeException extends FNException {}
	
?>
						