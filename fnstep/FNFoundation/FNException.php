<?PHP
//
//!FNStep
//!FNException.php
//
//!Created by Valentin Knabel on 24.04.13
//!Copyright (c) 2013 Valentin Knabel. All rights reserved.
//
	
namespace FNFoundation;
use \Exception;

class FNException extends Exception implements Object {
	use FNDefaultObject;
	
	/**
	 * Caches the trace.
	 * @type FNArray
	 */
	private $trace;
	
	/**
	 * This constructor is not declared protected: just use new
	 * @arg string|Object $message = ""
	 * @arg int|FNCountable $code = 0
	 * @arg Exception $previous = NULL
	 */
	public function __construct($message = "", $code = 0, Exception $previous = NULL) {
		parent::__construct(cstring($message), cint($code), $previous);
	}
	
	/**
	 * Returns the description of the current object.
	 * @return string
	 */
	public function __toString() {
		if($this->previous())
			return cstring(static::cls(),': #',$this->code(),' \'',$this->message(),'\' {',$this->previous(),'}');
		else return cstring(static::cls(),': #',$this->code(),' \'',$this->message(),'\'');
	}
	
	//!Implementation
	/**
	 * Returns the message.
	 * @return FNString
	 */
	public function message() {
		return s($this->getMessage());
	}
	
	/**
	 * Returns the error code.
	 * @return FNNumber
	 */
	public function code() {
		return n($this->getCode());
	}
	
	/**
	 * Returns the previous exception
	 * @return Exception
	 */
	public function previous() {
		return $this->getPrevious();
	}
	
	/**
	 * Returns the file name.
	 * @return FNString
	 */
	public function fileName() {
		return s($this->getFile());
	}
	
	/**
	 * Returns the line.
	 * @return FNNumber
	 */
	public function line() {
		return n($this->getLine());
	}
	
	/**
	 * Returns the trace array.
	 * @return FNArray
	 */
	public function trace() {
		if(!isset($this->trace)) 
			$this-> trace = a($this-> getTrace());
		return $this-> trace;
	}
	
	/**
	 * Returns the description of the trace. This method may be faster than calling ->trace()->description()
	 * @return FNString
	 */
	public function traceDescription() {
		return s($this-> getTraceAsString());
	}
}

class FNVersionException extends FNException {}
class FNTodoException extends FNException {}

class FNTypeException extends FNException {}

class FNImplementationException extends FNException {}
class FNUnimplementedFunction extends FNImplementationException {}
class FNUnimplementedMethod extends FNUnimplementedFunction {}

class FNResolvabilityException extends FNException {}
class FNUnresolvedFunction extends FNResolvabilityException {}
class FNUnresolvedMethod extends FNUnresolvedFunction {}
class FNUnresolvedProperty extends FNResolvabilityException {}
class FNSetUnresolvedProperty extends FNUnresolvedProperty {}

class FNArgumentException extends FNException {}

?>
						