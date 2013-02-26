<?PHP
//
//!FNStep
//!FNException.php
//
//!Created by Valentin Knabel on 26.02.13
//!Copyright © 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;

class FNException extends \Exception implements object {
	public function __construct($message = "", $code = 0, \Exception $previous = NULL) {
		parent::__construct(cstring($message), intval($code), $previous);
	}

	public static function init() {
		return new static();
	}
	
	public static function super() {
		return parent:: cls();
	}
	public static function cls() {
		return get_called_class();
	}
	public function callMethod($method, $list = NULL /*infinite arguments*/) {//is static AND non-static
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), func_get_args());
	}
	
	public function callMethodWithArray($method, array $array) {//is static AND non-static
		return call_user_func_array(array(isset($this)?$this:static::cls(), cstring($method)), carray($array));
	}
	
	public static function callStaticMethod($method, $list = NULL /*infinite arguments*/) {
		return call_user_func_array(array(static::cls(), cstring($method)), func_get_args());
	}
	public static function callStaticMethodWithArray($method, array $array) {
		return call_user_func_array(array(static::cls(), cstring($method)), carray($array));
	}
	
	public function isKindOf($type) {
		return $this instanceof $type;
	}
	
	public function isMemberOf($class) {
		return $this::cls() == cstring($class);
	}
	
	public function respondsToMethod($method) {//is static AND non-static
		return function_exists(array(isset($this)?$this:static::cls(), cstring($method)));
	}
	
	public static function respondsToStaticMethod($method) {
		return function_exists(array(static::cls(), cstring($method)));
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
						